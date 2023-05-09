<?php

namespace AppTenant\Http\Controllers;

use AppTenant\Http\Controllers\BaseController\BaseController;
use AppTenant\Http\Controllers\Resource\Traits\HasComments;
use AppTenant\Http\Controllers\Resource\Traits\HasDeletionsAndDrafts;
use AppTenant\Mail\CompensationEventQuotationEdited;
use AppTenant\Mail\CompensationEventQuotationNotified;
use AppTenant\Models\Activity;
use AppTenant\Models\Contract;
use AppTenant\Models\Notification;
use AppTenant\Models\Programme;
use AppTenant\Models\Quotation;
use App\Models\Statical\Constant;
use AppTenant\Models\Statical\MediaCollection;
use AppTenant\Models\Status\QuotationStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class QuotationsController extends BaseController
{
    use HasComments, HasDeletionsAndDrafts;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quotations = Quotation::notDraftedOrMine()
                        ->latest()
                        ->paginate(config('app.pagination_size'));

        return t_view('quotations.index', [
            'quotations'    => $quotations
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = $this->dataForCreateEditPages();

        return t_view('quotations.create', [
            'contracts'                 => $data->contracts,
            'programmes'                => $data->programmes,
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
        $this->validateRequest($request);
        $status = $request->get('is_draft', false) ? QuotationStatus::DRAFT_ID : QuotationStatus::NOTIFIED_ID;

        $quotation = Quotation::create([
            'programme_id'                      => $request->get('programme'),
            'title'                             => $request->get('title'),
            'description'                       => $request->get('description'),
            'contract_completion_date_effect'   => $request->get('contract_completion_date_effect', 0),
            'contract_key_date_1_effect'        => 0,
            'contract_key_date_2_effect'        => 0,
            'contract_key_date_3_effect'        => 0,
            'price_effect'                      => $request->get('price_effect', 0),
            'status'                            => $status,
            'created_by'                        => t_profile()->id,
        ]);

        if (!in_array($quotation->contract->contract_type, [ContractApplicationController::TSC, ContractApplicationController::NEC4_TSC])) {
            $quotation->update([
                'contract_key_date_1_effect'    => $request->get('contract_key_date_1_effect', 0),
                'contract_key_date_2_effect'    => $request->get('contract_key_date_2_effect', 0),
                'contract_key_date_3_effect'    => $request->get('contract_key_date_3_effect', 0),
            ]);
        }

        if (!$quotation) {
            $this->jsonError();
        }

        if (!$quotation->isDraft()) {
            Activity::resource('notified', $quotation);
            Notification::resource('notified', $quotation);

            if (isProductionOrStaging()) {
                Mail::to(admin_profile()->email)->queue(new CompensationEventQuotationNotified($quotation));
            }
        }

        return $this->jsonSuccess('Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $quotation = Quotation::with(['programme', 'programme.contract', 'comments.commentator'])->notDraftedOrMine()->findOrFail($id);

        $files = Media::where('collection_name', MediaCollection::COLLECTION_QUOTATIONS)
            ->where('custom_properties->resource_id', $id)
            ->get();

        if ($quotation->contract->applicationOne) {
            $contract_completion_date = $this->contractDateDiff($quotation->contract->applicationOne->completion_date, $quotation->contract_completion_date_effect);
            $contract_key_date_1 = $this->contractDateDiff($quotation->contract->applicationOne->key_date_1, $quotation->contract_key_date_1_effect);
            $contract_key_date_2 = $this->contractDateDiff($quotation->contract->applicationOne->key_date_2, $quotation->contract_key_date_2_effect);
            $contract_key_date_3 = $this->contractDateDiff($quotation->contract->applicationOne->key_date_3, $quotation->contract_key_date_3_effect);
        } else {
            $contract_completion_date = null;
            $contract_key_date_1 = null;
            $contract_key_date_2 = null;
            $contract_key_date_3 = null;
        }

        return t_view('quotations.show', compact([
            'quotation',
            'contract_completion_date',
            'contract_key_date_1',
            'contract_key_date_2',
            'contract_key_date_3',
            'files',
        ]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $quotation = Quotation::findOrFail($id);

        if (empty($quotation) || !$quotation->canBeUpdated()) {
            abort(404);
        }

        $data = $this->dataForCreateEditPages();

        return t_view('quotations.edit', [
            'contracts'         => $data->contracts,
            'programmes'        => $data->programmes,
            'quotation'         => $quotation,
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
        $quotation = Quotation::findOrFail($id);

        if (empty($quotation) || !$quotation->canBeUpdated()) {
            abort(404);
        }
        
        $this->validateRequest($request, Constant::ACTION_UPDATE);

        $data = [
            'programme_id'                      => $request->get('programme'),
            'title'                             => $request->get('title'),
            'description'                       => $request->get('description'),
            'contract_completion_date_effect'   => $request->get('contract_completion_date_effect', 0),
            'contract_key_date_1_effect'        => 0,
            'contract_key_date_2_effect'        => 0,
            'contract_key_date_3_effect'        => 0,
            'price_effect'                      => $request->get('price_effect', 0),
        ];

        if (!in_array($quotation->contract->contract_type, [ContractApplicationController::TSC, ContractApplicationController::NEC4_TSC])) {
            array_push($data, [
                'contract_key_date_1_effect'    => $request->get('contract_key_date_1_effect', 0),
                'contract_key_date_2_effect'    => $request->get('contract_key_date_2_effect', 0),
                'contract_key_date_3_effect'    => $request->get('contract_key_date_3_effect', 0),
            ]);
        }

        $quotation->update($data);

        if (!$quotation->isDraft()) {
            Activity::resource('Updated', $quotation);
        }

        if ($quotation->isNotified() && isProductionOrStaging()) {
            Mail::to(admin_profile()->email)->queue(new CompensationEventQuotationEdited($quotation));
        }

        return $this->jsonSuccess('Updated');
    }

    /**
     * Update Quotation status to Notified
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function notify($id)
    {
        $quotation = Quotation::findMineDraftedOrFail($id);
        $quotation->status = QuotationStatus::NOTIFIED_ID;
        $quotation->save();

        Activity::resource('notified', $quotation);
        Notification::resource('notified', $quotation);

        if (isProductionOrStaging()) {
            Mail::to(admin_profile()->email)->queue(new CompensationEventQuotationNotified($quotation));
        }

        return redirect( t_route('quotations.show', $id));
    }

    /**
     * Update Quotation status to Accepted
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function accept($id)
    {
        $quotation = Quotation::where('status', QuotationStatus::NOTIFIED_ID)->find($id);
        $quotation->status = QuotationStatus::ACCEPTED_ID;
        $quotation->save();

        Activity::resource('accepted', $quotation);
        Notification::resource('accepted', $quotation);

        return redirect( t_route('quotations.show', $id));
    }

    /**
     * Generate data required for create and edit methods
     * 
     * @return object<array>
     */
    protected function dataForCreateEditPages()
    {
        $contracts = Contract::get()->map(function($contract) {
            return (object) [
                'id'                => $contract->id,
                'text'              => $contract->contract_name,
                'contract_type'     => $contract->contract_type,
                'completion_date'   => $contract->applicationOne->completion_date ?? '',
                'key_date_1'        => $contract->applicationOne->key_date_1 ?? '',
                'key_date_2'        => $contract->applicationOne->key_date_2 ?? '',
                'key_date_3'        => $contract->applicationOne->key_date_3 ?? '',
            ];
        });
        $programmes = Programme::get()->map(function($programme) {
            return (object) [
                'id'            => $programme->id,
                'text'          => $programme->name,
                'visible_for'   => [
                    'contract'   => $programme->contract_id,
                ],
            ];
        });

        return (object) [
            'contracts'         => $contracts,
            'programmes'        => $programmes,
        ];
    }

    /**
     * Correct contract date depending from difference
     * 
     * @param string $date_str
     * @param int $date_diff
     * @return Carbon|null
     */
    protected function contractDateDiff($date_str, $date_diff)
    {
        if (empty($date_str)) {
            return null;
        }

        $date = Carbon::parse($date_str);
        if ($date_diff > 0) {
            $date->addDays($date_diff);
        } else if ($date_diff < 0) {
            $date->subDays($date_diff);
        }

        return $date;
    }

    /**
     * Validate request depending from action
     * 
     * @param \Illuminate\Http\Request $request
     * @param string $action store|update
     * @param Mitigation $mitigation to update
     */
    protected function validateRequest($request, $action = Constant::ACTION_STORE, $quotation = null)
    {
        $rules = [
            'contract'                          => 'required|exists:contracts,id',
            'programme'                         => 'required|exists:programmes,id',
            'title'                             => 'required|string|max:255',
            'description'                       => 'required|string|max:5000',
            'contract_completion_date_effect'   => 'nullable|integer|min:-9999|max:9999',
            'contract_key_date_1_effect'        => 'nullable|integer|min:-9999|max:9999',
            'contract_key_date_2_effect'        => 'nullable|integer|min:-9999|max:9999',
            'contract_key_date_3_effect'        => 'nullable|integer|min:-9999|max:9999',
            'price_effect'                      => 'required|numeric|min:-99999999|max:99999999',
        ];

        if ($action == Constant::ACTION_STORE) {

        } else {

        }

        $request->validate($rules);
    }
}