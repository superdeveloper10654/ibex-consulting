<?php

namespace AppTenant\Http\Controllers;

use AppTenant\Http\Controllers\BaseController\BaseController;
use AppTenant\Http\Controllers\Resource\Traits\HasComments;
use AppTenant\Models\Activity;
use AppTenant\Models\Application;
use AppTenant\Models\Assessment;
use AppTenant\Models\Status\AssessmentStatus;
use AppTenant\Models\Contract;
use AppTenant\Models\Notification;
use AppTenant\Models\Payment;
use AppTenant\Models\Quotation;
use AppTenant\Models\Status\PaymentStatus;
use AppTenant\Models\RateCard;
use App\Models\Statical\Constant;
use AppTenant\Models\Statical\Department;
use AppTenant\Models\Statical\MediaCollection;
use AppTenant\Models\Statical\Role;
use AppTenant\Models\Status\QuotationStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class AssessmentsController extends BaseController
{
    use HasComments;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assessments = Assessment::with(['contract'])->paginate(config('app.pagination_size'));

        return t_view('assessments.index', [
            'assessments'  => $assessments
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $contracts = Contract::all();
        $rate_cards = RateCard::all();

        if (request()->get('quotation_id')) {
            $quotation = Quotation::findOrFail(request()->get('quotation_id'));
            $selected_contract_id = $quotation->contract->id;
        }

        return t_view('assessments.create', [
            'contracts'             => $contracts,
            'rate_cards'            => $rate_cards,
            'selected_contract_id'  => $selected_contract_id
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
        $this->validateAssessment($request);

        // assessment
        $data = [
            'contract_id'   => $request->get('contract'),
            'profile_id'    => t_profile()->id,
            'net'           => $request->get('net'),
            'title'         => $request->get('title'),
            'description'   => $request->get('description'),
            'items'         => $request->get('items'),
            'period_from'   => $request->get('period_from'),
            'period_to'     => $request->get('period_to'),
            'status'        => AssessmentStatus::PRIMED_ID,
        ];
        $assessment = Assessment::create($data);

        if ($request->get('quotation_id')) {
            if (!t_profile()->can('quotations.accept-reject')) {
                abort(403);
            }

            $quotation = Quotation::findOrFail($request->quotation_id);
            $quotation->assessment_id = $assessment->id;
            $quotation->status = QuotationStatus::REJECTED_ID;
            $quotation->update();

            Activity::resource('Rejected', $quotation);
            Activity::resource('Submitted', $assessment);
            Notification::resource('Rejected', $quotation);
            Notification::resource('Submitted', $assessment);
        }

        Activity::resource('Submitted', $assessment, null, Department::OPERATIONAL_ID);
        Notification::resource('Submitted', $assessment, null, Department::OPERATIONAL_ID);

        return $this->jsonSuccess('Assessment successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $assessment = Assessment::with(['profile', 'application', 'comments.commentator'])->findOrFail($id);
        $application = $assessment->application;
        $files = Media::where('collection_name', MediaCollection::COLLECTION_ASSESSMENTS)
                        ->where('custom_properties->resource_id', $id)
                        ->get();;

        return t_view('assessments.show', [
            'assessment'    => $assessment,
            'application'   => $application,
            'files'         => $files,
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
        $assessment = Assessment::with(['contract'])->findOrFail($id);
        $contracts = Contract::all();
        $rate_cards = RateCard::all();

        return t_view('assessments.edit', [
            'assessment'    => $assessment,
            'contracts'     => $contracts,
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
        $assessment_id = $request->get('assessment_id');
        $assessment = Assessment::findOrFail($request->get('assessment_id'));

        $this->validateAssessment($request, 'update', $assessment);
        
        $data = [
            'contract_id'   => $request->get('contract'),
            'net'           => $request->get('net'),
            'description'   => $request->get('description'),
            'items'         => $request->get('items'),
            'period_from'   => $request->get('period_from'),
            'period_to'     => $request->get('period_to'),
        ];

        $assessment_res = $assessment->update($data);

        Activity::resource('Updated', $assessment, Role::CONTRACTOR_ID);
        Notification::resource('Updated', $assessment, Role::CONTRACTOR_ID);

        return $assessment_res ? $this->jsonSuccess('Assessment successfully edited') : $this->jsonError();
    }

    /**
     * Update status
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        $assessment = Assessment::with('application')->findOrFail($id);

        if ($assessment->status == AssessmentStatus::PRIMED_ID) {
            $assessment->certify(t_profile()->id);

            $payment = Payment::create([
                'contract_id'   => $assessment->contract_id,
                'assessment_id' => $assessment->id,
                'cuml_net'      => $assessment->net,
                'title'         => $assessment->title,
                'description'   => $assessment->description,
                'items'         => $assessment->items,
                'from_date'     => $assessment->period_from,
                'due_date'      => $assessment->period_to,
                'status'        => PaymentStatus::PENDING_ID,
            ]);

            Activity::resource('Certified', $assessment, null, Department::OPERATIONAL_ID);
            Notification::resource('Certified', $assessment, null, Department::OPERATIONAL_ID);
            
            Activity::resource('Submitted', $payment, null, Department::OPERATIONAL_ID);
            Notification::resource('Submitted', $payment, null, Department::OPERATIONAL_ID);

            return $this->jsonSuccess('Assessment status successfully updated');
        } else {
            return $this->jsonError();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Validates application store/update data
     * 
     * @param Request $request
     * @param string $action store|update
     * @param Assessment $assessment
     */
    protected function validateAssessment(Request $request, $action = Constant::ACTION_STORE, $assessment = null)
    {
        if ($action == Constant::ACTION_UPDATE) {
            $request->validate(['assessment_id' => 'required|integer|exists:assessments,id']);

            if ($assessment->quotation) {
                // Quotation should have the same contract as the Assessment
                $contract = Contract::findOrFail($request->get('contract'));
                
                if ($contract && $contract->id != $assessment->quotation->contract->id) {
                    throw ValidationException::withMessages(['Quotation Contract and Assessment Contract can not be different']);
                }
            }
        } else {
            if ($request->get('quotation_id')) {
                $acceptable_quotation_ids = Quotation::where('status', QuotationStatus::NOTIFIED_ID)->get()->pluck('id')->implode(',');
                $request->validate(['quotation_id' => "nullable|integer|in:$acceptable_quotation_ids"]);

                // Quotation should have the same contract as the Assessment
                $contract = Contract::findOrFail($request->get('contract'));
                $quotation = Quotation::findOrFail($request->get('quotation_id'));
                
                if ($contract && $quotation && $contract->id != $quotation->contract->id) {
                    throw ValidationException::withMessages(['Quotation Contract and Assessment Contract can not be different']);
                }
            }
        }

        $request->validate([
            'contract'              => 'required|integer|exists:contracts,id',
            'title'                 => 'required|string|max:255',
            'description'           => 'required|string|max:5000',
            'period_from'           => 'required|date',
            'period_to'             => 'required|date',
            'net'                   => [
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
                        $fail(__('Application net is not correct'));
                    }
                }
            ],
            'items'                 => 'required|array',
            'items.*.rate_card_id'  => 'required|integer|exists:rate_cards,id',
            'items.*.qty'           => 'required|numeric|min:1|max:999999',
            'items.*.unit'          => 'required|string|max:255',
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
            ]
        ]);
    }
}