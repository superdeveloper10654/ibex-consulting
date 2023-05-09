<?php

namespace AppTenant\Http\Controllers;

use AppTenant\Http\Controllers\BaseController\BaseController;
use AppTenant\Http\Controllers\Resource\Traits\HasComments;
use AppTenant\Mail\ContractCreated;
use AppTenant\Mail\ContractEdited;
use AppTenant\Models\Activity;
use AppTenant\Models\Contract;
use AppTenant\Models\ActivitySchedule;
use AppTenant\Models\BoqSchedule;
use AppTenant\Models\ContractApplication;
use AppTenant\Models\ContractDefinedCost;
use AppTenant\Models\ContractKeyPeople;
use AppTenant\Models\ContractPartTwoSeniorRepresentative;
use AppTenant\Models\ContractSharedServiceDefinedCost;
use AppTenant\Models\ContractSizeBaseEquipment;
use AppTenant\Models\ContractTimeBaseEquipment;
use AppTenant\Models\PartTwoContractData;
use AppTenant\Models\PartTwoNec4ContractData;
use AppTenant\Models\PriceList;
use AppTenant\Models\Profile;
use App\Models\Statical\Constant;
use AppTenant\Models\Statical\Format;
use AppTenant\Models\Statical\MediaCollection;
use AppTenant\Models\Statical\Role;
use AppTenant\Models\Status\QuotationStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ContractsController extends BaseController
{
    use HasComments;
    
    const ECC = 'ECC';
    const ECS = 'ECS';
    const TSC = 'TSC';
    const NEC4_TSC = 'NEC4_TSC';
    const NEC4_ECS = 'NEC4_ECS';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contracts = Contract::orderBy('id', 'desc')->paginate(config('app.pagination_size'));

        return t_view('contracts.index', [
            'contracts' => $contracts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->checkDemo();
        $contractor_profiles = Profile::where('email', '<>', env('SUPPORT_PROFILE_EMAIL'))->where('role', Role::CONTRACTOR_ID)->get();
        $subcontractor_profiles = Profile::where('role', Role::SUBCONTRACTOR_ID)->get();

        return t_view('contracts.steps.step1', [
            'contractor_profiles'       => $contractor_profiles,
            'subcontractor_profiles'    => $subcontractor_profiles->map(function ($profile) {
                return (object) [
                    'id'            => $profile->id,
                    'name'          => $profile->organisation,
                    'visible_for'   => ['contractor_profile_id' => $profile->parent_id],
                ];
            }),
            'contractType'              => isPaidSubscription() ? 'NONE' : static::NEC4_ECS,
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
        $this->checkDemo();
        $this->validateContract($request);

        $contract = Contract::create([
            'contract_type'             => $request->get('contract_type'),
            'contract_name'             => $request->get('contract_name'),
            'profile_id'                => $request->get('contractor_profile_id'),
            'subcontractor_profile_id'  => $request->get('subcontractor_profile_id'),
            'order_ref'                 => $request->get('order_ref'),
            'kml_filepath'              => !is_null($request->get('additional_documents')) ? $request->get('additional_documents') : '',
            'latitude'                  => $request->get('lat'),
            'longitude'                 => $request->get('lng'),
            'created_by'                => t_profile()->id,
        ]);

        ContractApplication::create(['contract_id' => $contract->id]);
        PartTwoContractData::create(['contract_id' => $contract->id]);
        if (str_contains($request->contract_type, 'NEC4')) {
            $contract->NEC4Contract()->create();
            $contract->partTwoNec4Contract()->create();
        }

        Activity::resource("Submitted new", $contract);

        if (isProductionOrStaging()) {
            Mail::to(admin_profile()->email)->queue(new ContractCreated($contract));
        }

        return $contract ? redirect('/contracts/' . $contract->id . '/step2') : $this->jsonError();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contract = Contract::findOrFail($id);
        $files = Media::where('collection_name', MediaCollection::COLLECTION_CONTRACTS)
            ->where('custom_properties->resource_id', $id)
            ->get();

        $contractAppl = $contract->applicationOne;
        $contractType = $contract->contract_type;
        $nec4Contract = $contract->NEC4Contract;

        //step 2
        $admin = Profile::where('role', Role::ADMIN_ID)->first();
        $serviceManagerProfiles = Profile::where('role', Role::SERVICE_MANAGER_ID)->get();
        $projectManagerProfiles = Profile::where('role', Role::PROJECT_MANAGER_ID)->get();
        $employerProfiles = Profile::where('role', Role::getClientRoleIds())->get();
        $adjudicatorProfiles = Profile::where('role', Role::ADJUDICATOR_ID)->get();
        $supervisorProfiles = Profile::where('role', Role::SUPERVISOR_ID)->get();

        $replyExceptPeriods = $contract->exceptReplyPeriods;
        $accessDates = $contract->contractAccessDates;
        $workConditions = $contract->contractWorkConditions;
        $defectExceptPeriods = $contract->ContractDefectCorrectionExceptPeriod;
        $createdAdditionalEmployerRisks = $contract->additionalEmployerRisks;
        $createdInsurances = $contract->insurances;
        $seniorRepresentativeProfiles = Profile::where('role', Role::SENIOR_REPRESENTATIVE_ID)->get();
        $seniorRepresentatives = $contract->seniorRepresentatives;

        //step 9
        $priceAdjustmentFactors = $contract->contractPriceAdjustmentFactors()->where('is_non_adjustable', 0)->get();
        $nonAdjustablePriceAdjustmentFactor = $contract->contractPriceAdjustmentFactors()->where('is_non_adjustable', 1)->firstOrCreate([
            'is_non_adjustable' => 1
        ]);

        $payItems = $contract->contractPayItemActivities;
        $completionDates = $contract->contractWorkSectionCompletionDates;
        $workSectionBonuses = $contract->contractWorkSectionBonuses;
        $workSectionDelayDamages = $contract->contractWorkSectionDelayDamages;
        $undertakingsToOthers = $contract->contractUndertakingToOthers;
        $undertakingsToClients = $contract->contractUndertakingToClients;
        $subcontractorUndertakingsToOthers = $contract->subcontractorUndertakingToOthers;
        $lowPerformanceDamageAmounts = $contract->contractLowPerformanceDamageAmounts;
        $extensionPeriods = $contract->contractExtensionPeriods;
        $extensionCriteria = $contract->contractExtensionCriteria;
        $accountingPeriods = $contract->contractAccountingPeriods;
        $benificiaryTerms = $contract->contractBenificiaryTerms;

        $contractData2 = PartTwoContractData::where('contract_id', $id)->first();
        $createdBoqSchedules = BoqSchedule::where('contract_id', $id)->get();
        $createdPriceLists = PriceList::where('contract_id', $id)->get();
        $createdActivitySchedules = ActivitySchedule::where('contract_id', $id)->get();

        // $insuranceGroups = $contract->insurances()
        //     ->orderBy('is_additional', 'asc')
        //     ->orderByRaw("FIELD(provider , 'employer/client', 'employer', 'contractor') ASC")
        //     ->get()
        //     ->groupBy(['is_additional', 'provider']);

        $createdOtherEquipments = ContractSizeBaseEquipment::where('type', 'Other')->where('contract_id', $id)->get();
        $createdSpecialEquipments = ContractSizeBaseEquipment::where('type', 'Special')->where('contract_id', $id)->get();
        $createdTimeEquipments = ContractTimeBaseEquipment::where('contract_id', $id)->get();
        $nec4ContractData2 = PartTwoNec4ContractData::where('contract_id', $id)->first();
        $createdOtherDefinedCosts = ContractDefinedCost::where('type', 'Other')->where('contract_id', $id)->get();
        $createdManufactAndFabDefinedCosts = ContractDefinedCost::where('type', 'ManufactureAndFabrication')->where('contract_id', $id)->get();
        $createdDesignCosts = ContractDefinedCost::where('type', 'Design')->where('contract_id', $id)->get();
        $createdSeniorRepresentatives = ContractPartTwoSeniorRepresentative::where('contract_id', $id)->get();
        $createdKeyPeoples = ContractKeyPeople::where('contract_id', $id)->get();
        $createdSharedDefineCosts = ContractSharedServiceDefinedCost::where('contract_id', $id)->get();

        return t_view('contracts.show', compact(
            'id',
            'contract',
            'contractAppl',
            'files',
            'contractType',
            'contractData2',
            'nec4Contract',
            'nec4ContractData2',
            'admin',
            'serviceManagerProfiles',
            'projectManagerProfiles',
            'employerProfiles',
            'adjudicatorProfiles',
            'supervisorProfiles',
            'replyExceptPeriods',
            'accessDates',
            'workConditions',
            'defectExceptPeriods',
            'createdAdditionalEmployerRisks',
            'createdInsurances',
            'seniorRepresentativeProfiles',
            'seniorRepresentatives',

            'priceAdjustmentFactors',
            'nonAdjustablePriceAdjustmentFactor',
            'payItems',
            'completionDates',
            'workSectionBonuses',
            'workSectionDelayDamages',
            'undertakingsToOthers',
            'undertakingsToClients',
            'subcontractorUndertakingsToOthers',
            'lowPerformanceDamageAmounts',
            'extensionPeriods',
            'extensionCriteria',
            'accountingPeriods',
            'benificiaryTerms',

            'createdBoqSchedules',
            'createdPriceLists',
            'createdActivitySchedules',
            'createdOtherEquipments',
            'createdSpecialEquipments',
            'createdTimeEquipments',
            'createdOtherDefinedCosts',
            'createdManufactAndFabDefinedCosts',
            'createdDesignCosts',
            'createdKeyPeoples',
            'createdSeniorRepresentatives',
            'createdSharedDefineCosts',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contractType = 'NONE';
        $contract = Contract::findOrFail($id);
        if ($contract) {
            $contractType = $contract->contract_type;
            $subcontractor_profiles = Profile::where('role', Role::SUBCONTRACTOR_ID)->get();

            return t_view('contracts.edit', [
                'contractor_profiles'       => Profile::where('email', '<>', env('SUPPORT_PROFILE_EMAIL'))->where('role', Role::CONTRACTOR_ID)->get(),
                'subcontractor_profiles'    => $subcontractor_profiles->map(function ($profile) {
                    return (object) [
                        'id'            => $profile->id,
                        'name'          => $profile->organisation,
                        'visible_for'   => ['contractor_profile_id' => $profile->parent_id],
                    ];
                }),
                'contract'                  => $contract,
                'contractType'              => $contractType,
            ]);
        }
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
        $contract = Contract::findOrFail($id);
        $this->validateContract($request, 'update', $id);

        if ($contract) {
            $isUpdatedSucess = $contract->update([
                // 'contract_type'     => $request->get('contract_type'),
                'contract_name'         => $request->get('contract_name'),


                'order_ref'             => $request->get('order_ref'),
                'kml_filepath'          => !is_null($request->get('additional_documents')) ? $request->get('additional_documents') : '',
                'latitude'              => $request->get('lat'),
                'longitude'             => $request->get('lng'),
            ]);

            if (isProductionOrStaging()) {
                $queue_id = Mail::to(admin_profile()->email)->later(now()->addMinutes(4), new ContractEdited($contract));
                debounceJobInQueue('ContractEdited' . $contract->id, $queue_id);
            }

            if ($isUpdatedSucess) {
                return redirect('/contracts/' . $id . '/step2');
            }
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
     * Get history of the completion date changes
     *
     * @param int  $id
     * @param string $date_type Constant::DATE_TYPE_
     * @return \Illuminate\Http\Response
     */
    public function dates_history_modal($id, $date_type)
    {
        $date_types_arr = Constant::getDateTypes();

        if (!in_array($date_type, array_keys($date_types_arr))) {
            return $this->jsonError("This date type doesn't exist");
        }

        // $contract = Contract::with(['quotations', 'quotations.author'])->findOrFail($id);
        $contract = Contract::findOrFail($id);
        $quotations = $contract->quotations->where('status', QuotationStatus::ACCEPTED_ID);

        if (empty($quotations)) {
            return $this->jsonSuccess('', [
                'body'  => 'Has no events that affect the date',
            ]);
        }

        $modal_body = '';
        $date_type_name = $date_types_arr[$date_type];

        foreach ($quotations as $quotation) {
            $title = $quotation->title;
            $author = $quotation->author->full_name();
            $link = t_route('quotations.show', $quotation->id);
            $date = '<span class="fst-italic">' . (new Carbon($quotation->updated_at))->format(Format::DATE_READABLE) . '</span>';
            $date_effect_variable = "contract_{$date_type}_effect";
            $date_effect = $quotation->$date_effect_variable;

            if ($date_effect > 0) {
                $date_effect = "<span class='badge badge-soft-danger fs-6'>+$date_effect days.</span>";
            } else if ($date_effect < 0) {
                $date_effect = "<span class='badge badge-soft-success fs-6'>-$date_effect days.</span>";
            } else {
                $date_effect = "<span class='badge badge-soft-info fs-6'>$date_effect days.</span>";
            }

            $modal_body .= trim("
                <div class='history-line'>
                    <p class='text'>
                        $date $author accepted Quotation <a href='$link'>{$title}<i class='mdi mdi-link-variant'></i></a> that changed $date_type_name to $date_effect.
                    </p>
                </div>
            ");
        }

        return $this->jsonSuccess('', [
            'body'  => $modal_body,
        ]);
    }

    /**
     * Check and validate in case it's Demo subscription
     * 
     * @throws Exception
     */
    protected function checkDemo()
    {
        if (!isPaidSubscription()) {
            $contracts = Contract::all();

            if ($contracts->count() >= env('DEMO_MAX_CONTRACTS')) {
                abort(403);
            }
        }
    }

    /**
     * Validates contract store/update data
     *
     * @param string $action store|update
     */
    protected function validateContract(Request $request, $action = 'store', $id = null)
    {
        $rules = [
            'order_ref'             => 'required|string|max:255',
            'additional_documents'  => 'nullable|string|max:64000',
            'lat'                   => 'required|numeric',
            'lng'                   => 'required|numeric',
        ];

        $validationMessages = [
            'lat.required' => "Latitude is required",
            'lng.required' => "Longitude is required",
        ];

        if ($action == 'store') {
            $rules['contract_name'] = 'required|string|unique:contracts|max:255';
            $rules['contractor_profile_id'] = [
                'required',
                Rule::exists((new Profile())->getTable(), 'id')->where('role', Role::CONTRACTOR_ID),
            ];
            $rules['subcontractor_profile_id'] = [
                Rule::exists((new Profile())->getTable(), 'id')->where('role', Role::SUBCONTRACTOR_ID),
            ];
            $rules['contract_type'] = 'required';
        } else if ($action == 'update') {
            $rules['contract_name'] = 'required|string|max:255|unique:contracts,contract_name,' . $id;
        }

        $request->validate($rules, $validationMessages);
    }
}
