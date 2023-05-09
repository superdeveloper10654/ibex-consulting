<?php

namespace AppTenant\Http\Controllers;

use AppTenant\Http\Controllers\BaseController\BaseController;
use AppTenant\Models\Application;
use AppTenant\Models\Assessment;
use AppTenant\Models\Status\AssessmentStatus;
use AppTenant\Models\Contract;
use AppTenant\Models\Payment;
use AppTenant\Models\Status\PaymentStatus;
use AppTenant\Models\RateCard;
use AppTenant\Models\Statical\MediaCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PaymentsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::with(['contract'])->paginate(config('app.pagination_size'));

        return t_view('payments.index', [
            'payments'  => $payments,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404);
        $contracts = Contract::all();
        $rate_cards = RateCard::all();

        return t_view('payments.create', [
            'contracts'     => $contracts,
            'rate_cards'    => $rate_cards,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort(404);
        $this->validateStoreUpdate($request);

        $payment = Payment::create([
            'contract_id'   => $request->get('contract'),
            'cuml_net'      => $request->get('payment_sub_total'),
            'description'   => $request->get('description'),
            'items'         => $request->get('items'),
            'from_date'     => $request->get('start'),
            'due_date'      => $request->get('finish'),
            'status'        => PaymentStatus::PENDING_ID,
        ]);

        $data = [
            'contract_id'   => $request->get('contract'),
            'profile_id'    => t_profile()->id,
            'net'           => $request->get('payment_sub_total'),
            'title'         => $request->get('title'),
            'description'   => $request->get('description'),
            'items'         => $request->get('items'),
            'period_from'   => $request->get('start'),
            'period_to'     => $request->get('finish'),
            'status'        => AssessmentStatus::CERTIFIED_ID,
        ];

        $assessment = Assessment::create($data);

        $data['assessment_id'] = $assessment->id;
        $data['payment_id'] = $payment->id;
        $application = Application::create($data);

        return $payment && $assessment && $application ? $this->jsonSuccess('Payment successfully created') : $this->jsonError();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payment = Payment::with(['contract'])->findOrFail($id);
        $files = Media::where('collection_name', MediaCollection::COLLECTION_PAYMENTS)
                        ->where('custom_properties->resource_id', $id)
                        ->get();

        return t_view('payments.show', [
            'payment'   => $payment,
            'files'     => $files,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $payment = Payment::findOrFail($id);
        $assessments = Assessment::all();
        $contracts = Contract::all();
        $rate_cards = RateCard::where('contract_id', $payment->contract_id)->get();

        return t_view('payments.edit', [
            'assessments'   => $assessments,
            'contracts'     => $contracts,
            'payment'       => $payment,
            'rate_cards'    => $rate_cards,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        $this->validateStoreUpdate($request, 'update');

        $payment->description = $request->get('description');
        $payment->from_date = $request->get('start');
        $payment->due_date = $request->get('finish');
        $payment->items = $request->get('items');
        $payment->cuml_net = $request->get('payment_sub_total');
        $payment->save();

        return $this->jsonSuccess('Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort(404);
    }

    /**
     * Validates request for post/update actions
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param string $type store/update
     */
    protected function validateStoreUpdate(Request $request, $type = 'store')
    {
        $params = [
            'description'           => 'required|string|max:5000',
            'start'                 => 'required|date',
            'finish'                => 'required|date',
            'items'                 => 'required|array',
            'items.*.rate_card_id'  => 'required|integer|exists:rate_cards,id',
            'items.*.qty'           => 'required|numeric|min:1|max:99999999',
            'items.*.rate'          => 'required|numeric|min:0.01|max:99999999',
            'items.*.sum'           => [
                'required',
                'numeric',
                'min:0.01',
                'max:99999999',
                function($attr, $sum, $fail) use($request) {
                    $i = explode('.', $attr)[1];

                    $rate_card_id = $request->get("items")[$i]['rate_card_id'];
                    $qty = $request->get("items")[$i]['qty'];

                    $rate_card = RateCard::find($rate_card_id);
                    $correct_sum = $rate_card->rate * $qty;
                    
                    if ($correct_sum != $sum ) {
                        $fail(__('Sum is not correct'));
                    }
                }
            ],
            'payment_sub_total'     => [
                'required',
                'numeric',
                'min:0.01',
                'max:99999999',
                function($attr, $net, $fail) use($request) {
                    $items = $request->get("items");
                    $net_backend = array_reduce($items, function($net_backend, $item) {
                        return $net_backend + $item['sum'];
                    }, 0);
                    
                    if ($net_backend != $net ) {
                        $fail(__('Net is not correct'));
                    }
                }
            ],
        ];

        if ($type == 'store') {
            $params['contract'] = 'required|integer|exists:contracts,id';
            $params['title'] = 'required|string|max:255';
        }
    
        $request->validate($params);
    }
}
