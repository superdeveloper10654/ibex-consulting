<?php

namespace AppTenant\Http\Controllers;

use AppTenant\Http\Controllers\BaseController\BaseController;
use AppTenant\Mail\ContractEdited;
use AppTenant\Models\Contract;
use AppTenant\Models\ContractApplication;
use AppTenant\Models\NEC4Contract;
use AppTenant\Models\PartTwoContractData;
use AppTenant\Models\PartTwoNec4ContractData;
use AppTenant\Models\Profile;
use AppTenant\Models\Statical\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class ContractApplicationController extends BaseController
{
    const TSC = 'TSC';
    const NEC4_TSC = 'NEC4_TSC';
    const NEC4_ECS = 'NEC4_ECS';
    const NEC3_ECS = 'ECS';

    // step2 screen
    public function viewStep2($id)
    {
        $contractData = Contract::findOrFail($id);
        $contractAppl = $contractData->applicationOne;
        $contractType = $contractData->contract_type;
        $nec4Contract = $contractData->NEC4Contract;

        return t_view('contracts.steps.step2', compact('id', 'contractAppl', 'contractType', 'nec4Contract'));
    }

    // store step2 screen
    public function updateStep2(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'main_opt' => 'required',
                'resolution_opt' => 'required'
            ],
            [
                'main_opt.required' => 'Main option is required',
                'resolution_opt.required' => 'Resolution option is required',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $contractAppl = ContractApplication::where('contract_id', $id);
        if ($contractAppl) {
            $isUpdatedSucess = $contractAppl->update([
                'main_opt' => $request->input('main_opt'),
                'resolution_opt' => $request->input('resolution_opt'),
                'sec_opt_X1' => $request->input('x1') === "on" ? 1 : 0,
                'sec_opt_X2' => $request->input('x2') === "on" ? 1 : 0,
                'sec_opt_X3' => $request->input('x3') === "on" ? 1 : 0,
                'sec_opt_X4' => $request->input('x4') === "on" ? 1 : 0,
                'sec_opt_X5' => $request->input('x5') === "on" ? 1 : 0,
                'sec_opt_X6' => $request->input('x6') === "on" ? 1 : 0,
                'sec_opt_X7' => $request->input('x7') === "on" ? 1 : 0,
                'sec_opt_X8' => $request->input('x8') === "on" ? 1 : 0,
                // 'sec_opt_X9' => $request->input('x9') === "on" ? 1:0,
                'sec_opt_X10' => $request->input('x10') === "on" ? 1 : 0,
                // 'sec_opt_X11' => $request->input('x11') === "on" ? 1:0,
                'sec_opt_X12' => $request->input('x12') === "on" ? 1 : 0,
                'sec_opt_X13' => $request->input('x13') === "on" ? 1 : 0,
                'sec_opt_X14' => $request->input('x14') === "on" ? 1 : 0,
                'sec_opt_X15' => $request->input('x15') === "on" ? 1 : 0,
                'sec_opt_X16' => $request->input('x16') === "on" ? 1 : 0,
                'sec_opt_X17' => $request->input('x17') === "on" ? 1 : 0,
                'sec_opt_X18' => $request->input('x18') === "on" ? 1 : 0,
                'sec_opt_X19' => $request->input('x19') === "on" ? 1 : 0,
                'sec_opt_X20' => $request->input('x20') === "on" ? 1 : 0,
                'sec_opt_X23' => $request->input('x23') === "on" ? 1 : 0,
                'sec_opt_X24' => $request->input('x24') === "on" ? 1 : 0,
                'sec_opt_yUK1' => $request->input('yUK1') === "on" ? 1 : 0,
                'sec_opt_yUK2' => $request->input('yUK2') === "on" ? 1 : 0,
                'sec_opt_yUK3' => $request->input('yUK3') === "on" ? 1 : 0,
                'sec_opt_Z1' => $request->input('z1') === "on" ? 1 : 0
            ]);
            if ($isUpdatedSucess) {
                if (isProductionOrStaging()) {
                    $contract = Contract::findOrFail($id);
                    $queue_id = Mail::to(admin_profile()->email)->later(now()->addMinutes(4), new ContractEdited($contract));
                    debounceJobInQueue('ContractEdited' . $contract->id, $queue_id);
                }

                return redirect('/contracts/' . $id . '/step3');
            }
        }
    }

    // step3 screen
    public function viewStep3($id)
    {
        $contract = Contract::findOrFail($id);
        $contractAppl = $contract->applicationOne;
        $contractType = $contract->contract_type;
        $admin = Profile::where('role', Role::ADMIN_ID)->first();
        $serviceManagerProfiles = Profile::where('role', Role::SERVICE_MANAGER_ID)->get();
        $projectManagerProfiles = Profile::where('role', Role::PROJECT_MANAGER_ID)->get();
        $employerProfiles = Profile::where('role', Role::getClientRoleIds())->get();
        $adjudicatorProfiles = Profile::where('role', Role::ADJUDICATOR_ID)->get();
        $supervisorProfiles = Profile::where('role', Role::SUPERVISOR_ID)->get();

        return t_view('contracts.steps.step3', compact(
            'id',
            'admin',
            'serviceManagerProfiles',
            'projectManagerProfiles',
            'employerProfiles',
            'adjudicatorProfiles',
            'supervisorProfiles',
            'contractAppl',
            'contractType',
            'contract'
        ));
    }

    // store step3 screen
    public function updateStep3(Request $request, $id)
    {
        $contractAppl = ContractApplication::where('contract_id', $id)->first();
        $contractType = $contractAppl->contractData->contract_type;
        $validations = [
            'works_are' => 'required',
            'employer_name_is' => 'required',
            'employer_address_is' => 'required',
            'pm_or_sm_id' => 'required'
        ];

        if (!str_starts_with($contractType, 'NEC4')) {
            $validations['adj_id'] = 'required';
            if (str_contains($contractType, 'ECS')) {
                $validations['sub_adj_id'] = 'required';
            }
        } else {
            $validations['employer_electronic_address_is'] = 'required';
        }

        if (str_contains($contractType, 'TSC')) {
            $validations['affected_property_is'] = 'required';
        } else {
            $validations['sup_id'] = 'required';
            if (str_contains($contractType, 'ECS')) {
                $validations['subcontract_works_are'] = 'required';
            }
        }

        $validationMessages = [
            'works_are.required' => 'Please fill this field',
            'subcontract_works_are.required' => 'Please fill this field',
            'employer_name_is.required' => 'This field is required',
            'employer_address_is.required' => 'This field is required',
            'pm_or_sm_id.required' => 'This field is required',
            'adj_id.required' => 'This field is required',
            'sub_adj_id.required' => 'This field is required',
            'affected_property_is.required' => 'Affected property is required',
        ];

        $validator = Validator::make(
            $request->all(),
            $validations,
            $validationMessages
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        if ($contractAppl->update($request->all())) {
            str_contains($contractType, 'NEC4') &&  $contractAppl->NEC4Contract()->update($request->only(['employer_electronic_address_is']));
            if (isProductionOrStaging()) {
                $contract = Contract::findOrFail($id);
                $queue_id = Mail::to(admin_profile()->email)->later(now()->addMinutes(4), new ContractEdited($contract));
                debounceJobInQueue('ContractEdited' . $contract->id, $queue_id);
            }

            return redirect('/contracts/' . $id . '/step4');
        }
    }

    // step4 screen
    public function viewStep4($id)
    {
        $contract = Contract::findOrFail($id);
        $contractAppl = $contract->applicationOne;
        $contractType = $contract->contract_type;
        $replyExceptPeriods = $contract->exceptReplyPeriods;
        $nec4Contract = $contract->NEC4Contract;

        return t_view('contracts.steps.step4', compact('id', 'contractAppl', 'contractType', 'replyExceptPeriods', 'nec4Contract'));
    }

    // store step4 screen
    public function updateStep4(Request $request, $id)
    {

        $contract = Contract::findOrFail($id);
        $contractType = $contract->contract_type;

        $validations = [
            'works_information_is_in' => 'required',
            'wi100' => 'required',
            'wi200' => 'required',
            'wi300' => 'required',
            'wi400' => 'required',
            'wi500' => 'required',
            'wi600' => 'required',
            'wi700' => 'required',
            'wi800' => 'required',
            'wi900' => 'required',
            'wi1000' => 'required',
            'wi1100' => 'required',
            'wi1200' => 'required',
            'wi1300' => 'required',
            'wi2000' => 'required',
            'language_is' => 'required',
            'law_is' => 'required',
            'period_for_reply_is' => 'required',
            'risk_register_matters_are' => 'required',
        ];

        if (!str_contains($contractType, 'TSC')) {
            $validations['site_information_is_in'] = 'required';
            $validations['boundaries_are'] = 'required';
            if (str_contains($contractType, 'ECS')) {
                $validations['subcontractor_period_for_reply_is'] = 'required';
            }
        }

        if (str_contains($contractType, 'NEC4')) {
            $validations['except_reply_periods'] = 'array';
            $validations['early_warnings_no_longer_than'] = 'required';
            if (str_contains($contractType, 'TSC')) {
                $validations['outside_works_information'] = 'required';
            }
        } else {
            $validations['adjudicator_body_is'] = 'required';
            $validations['tribunal_is'] = 'required';
        }

        $validationMessages = [
            'works_information_is_in.required' => 'This field is required',
            'wi100.required' => 'This field is required',
            'wi200.required' => 'This field is required',
            'wi300.required' => 'This field is required',
            'wi400.required' => 'This field is required',
            'wi500.required' => 'This field is required',
            'wi600.required' => 'This field is required',
            'wi700.required' => 'This field is required',
            'wi800.required' => 'This field is required',
            'wi900.required' => 'This field is required',
            'wi1000.required' => 'This field is required',
            'wi1100.required' => 'This field is required',
            'wi1200.required' => 'This field is required',
            'wi1300.required' => 'This field is required',
            'wi2000.required' => 'This field is required',
            'language_is.required' => 'Language is required',
            'law_is.required' => 'Law is required',
            'period_for_reply_is.required' => 'This field is required',
            'risk_register_matters_are.required' => 'This field is required',
            'site_information_is_in.required' => 'This field is required',
            'boundaries_are.required' => 'This field is required',
            'subcontractor_period_for_reply_is.required' => 'This field is required',
            'except_reply_periods.required' => 'This field is required',
            'early_warnings_no_longer_than.required' => 'This field is required',
            'outside_works_information.required' => 'This field is required',
            'adjudicator_body_is.required' => 'This field is required',
            'tribunal_is.required' => 'Tribunal is required'
        ];

        $validator = Validator::make(
            $request->all(),
            $validations,
            $validationMessages
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $contractAppl = ContractApplication::where('contract_id', $id)->first();
        $this->updateHasManyRelationRecords($id, $request["except_reply_periods"], 'AppTenant\Models\ExceptReplyPeriod');
        str_contains($contractType, 'NEC4') && $contract->NEC4Contract()->update($request->only(['outside_works_information', 'early_warnings_no_longer_than']));

        if ($contractAppl->update($request->all())) {
            if (isProductionOrStaging()) {
                $queue_id = Mail::to(admin_profile()->email)->later(now()->addMinutes(4), new ContractEdited($contract));
                debounceJobInQueue('ContractEdited' . $contract->id, $queue_id);
            }

            return redirect('/contracts/' . $id . '/step5');
        }
    }

    // step5 screen
    public function viewStep5($id)
    {
        $contract = Contract::findOrFail($id);
        $contractAppl = $contract->applicationOne;
        $contractType = $contract->contract_type;
        $accessDates = $contract->contractAccessDates;
        $workConditions = $contract->contractWorkConditions;
        $nec4Contract = $contract->NEC4Contract;

        return t_view('contracts.steps.step5', compact('id', 'contractAppl', 'contractType', 'accessDates', 'workConditions', 'nec4Contract'));
    }

    // store step5 screen
    public function updateStep5(Request $request, $id)
    {
        $contract = Contract::findOrFail($id);
        $contractType = $contract->contract_type;

        $validations = [
            'starting_date' => 'required|date'
        ];

        if (str_contains($contractType, 'TSC')) {
            $validations['service_period_is'] = 'required|date';
        } else {
            $validations['access_dates'] = 'array';
            $validations['programme_interval_is'] = 'required';
        }

        if (str_starts_with($contractType, 'NEC4')) {
            $validations['first_programme_within'] = 'required';
            if (str_contains($contractType, 'TSC')) {
                $validations['programme_interval_is'] = 'required';
                $validations['x19_end_task_order_programme_days_number'] = 'required|numeric';
            } else {
                $validations['work_cond'] = 'array';
                // $validations['is_takeover_completion_date'] = 'required';
                $validations['takeover_completion_date'] = 'required_if:is_takeover_completion_date,on';
                $validations['completion_date'] = 'required';
            }
        }

        $validationMessages = [
            'starting_date.required' => 'Starting date is required',
            'service_period_is.required' => 'Service period is required',
            'access_dates.required' => 'Access dates are required',
            'programme_interval_is.required' => 'This field is required',
            'first_programme_within.required' => 'This field is required',
            'x19_end_task_order_programme_days_number.required' => 'This field is required',
            'work_cond.required' => 'Work conditions are required',
            'takeover_completion_date.required' => 'Takeover completion date is required',
            'completion_date.required' => 'Completion date is required'
        ];

        $validator = Validator::make(
            $request->all(),
            $validations,
            $validationMessages
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $contractAppl = ContractApplication::where('contract_id', $id)->first();
        $this->updateHasManyRelationRecords($id, $request["access_dates"], 'AppTenant\Models\ContractAccessDate');
        $this->updateHasManyRelationRecords($id, $request["work_cond"], 'AppTenant\Models\ContractWorkCondition');
        $request["is_takeover_completion_date"] = $request->input('is_takeover_completion_date') === "on" ? 1 : 0;
        str_contains($contractType, 'NEC4') &&  $contract->NEC4Contract()->update($request->only(['is_takeover_completion_date', 'takeover_completion_date']));

        if ($contractAppl->update($request->all())) {
            if (isProductionOrStaging()) {
                $queue_id = Mail::to(admin_profile()->email)->later(now()->addMinutes(4), new ContractEdited($contract));
                debounceJobInQueue('ContractEdited' . $contract->id, $queue_id);
            }

            return redirect('/contracts/' . $id . '/step6');
        }
    }

    // step6 screen
    public function viewStep6($id)
    {
        $contract = Contract::findOrFail($id);
        $contractAppl = $contract->applicationOne;
        $contractType = $contract->contract_type;
        $defectExceptPeriods = $contract->ContractDefectCorrectionExceptPeriod;
        $nec4Contract = $contract->NEC4Contract;

        return t_view('contracts.steps.step6', compact('id', 'contractAppl', 'contractType', 'defectExceptPeriods', 'nec4Contract'));
    }

    // store step6 screen
    public function updateStep6(Request $request, $id)
    {

        $contract = Contract::findOrFail($id);
        $contractType = $contract->contract_type;
        $contractAppl = ContractApplication::where('contract_id', $id)->first();

        $validations = [
            'currency_is' => 'required',
            'assessment_interval' => 'required|numeric|max:5',
            'interest_rate_percentage' => 'required',
            'interest_rate_text_1' => 'required',
            'interest_rate_text_2' => 'required',
        ];

        if (!str_contains($contractType, 'TSC')) {
            $validations['defects_date'] = 'required';
            $validations['defect_correction_period'] = 'required';
            $validations['defect_except_periods'] = 'array';
        }

        if (str_starts_with($contractType, 'NEC4')) {
            $validations['quality_policy_plan_period'] = 'required';
            if ($contractAppl->sec_opt_yUK2) {
                $validations['payment_period_yuk2_number'] = 'required';
                $validations['payment_period_yuk2_text'] = 'required';
            }
            if (str_contains($contractType, 'TSC')) {
                $validations['final_assessment_period'] = 'required';
            }
        }

        $validationMessages = [
            'currency_is.required' => 'Currency is required',
            'assessment_interval.required' => 'Assessment interval is required',
            'interest_rate_percentage.required' => 'Interest rate is required',
            'interest_rate_text_1.required' => 'This field is required',
            'interest_rate_text_2.required' => 'This field is required',
            'defects_date.required' => 'Defects dates are required',
            'defect_correction_period.required' => 'Defect correction period is required',
            'defect_except_periods.required' => 'This field is required',
            'quality_policy_plan_period.required' => 'This field is required',
            'payment_period_yuk2_number.required' => 'This field is required',
            'payment_period_yuk2_text.required' => 'This field is required',
            'final_assessment_period.required' => 'Final assessment period is required'
        ];

        $validator = Validator::make(
            $request->all(),
            $validations,
            $validationMessages
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $this->updateHasManyRelationRecords($id, $request["defect_except_periods"], 'AppTenant\Models\ContractDefectCorrectionExceptPeriod');
        str_contains($contractType, 'NEC4') && $contract->NEC4Contract()->update($request->only(['quality_policy_plan_period', 'final_assessment_period']));

        if ($contractAppl->update($request->all())) {
            if (isProductionOrStaging()) {
                $queue_id = Mail::to(admin_profile()->email)->later(now()->addMinutes(4), new ContractEdited($contract));
                debounceJobInQueue('ContractEdited' . $contract->id, $queue_id);
            }

            return redirect('/contracts/' . $id . '/step7');
        }
    }

    // step7 screen
    public function viewStep7($id)
    {
        $contract = Contract::findOrFail($id);
        $contractAppl = $contract->applicationOne;
        $contractType = $contract->contract_type;
        $nec4Contract = $contract->NEC4Contract;

        return t_view('contracts.steps.step7', compact('id', 'contractAppl', 'contractType', 'nec4Contract'));
    }

    // store step7 screen
    public function updateStep7(Request $request, $id)
    {

        $contract = Contract::findOrFail($id);
        $contractType = $contract->contract_type;
        $contractAppl = ContractApplication::where('contract_id', $id)->first();
        $validations = [];
        if (str_contains($contractType, 'TSC')) {
            if (str_starts_with($contractType, 'NEC4')) {
                $validations['a_value_engineering_percentage'] = 'required';
                $validations['additional_compansation_events'] = 'required';
            } else {
                $validations['insurance_min_amount_to_emp_prop'] = 'required';
                $validations['insurance_text_1'] = 'required';
                $validations['insurance_min_text_2'] = 'required';
            }
        } else {
            $validations['weather_recording_place_is'] = 'required';
            $validations['weather_recording_snow_hour'] = 'required';
            $validations['weather_recording_additional'] = 'required';
            $validations['weather_recording_supplier'] = 'required';
            $validations['weather_data_recorded_at'] = 'required';
            $validations['weather_data_available_from'] = 'required';
            $validations['weather_data_assumed'] = 'required';
            if (str_starts_with($contractType, 'NEC4')) {
                if (str_starts_with($contractAppl->main_opt, 'Option A:') || str_starts_with($contractAppl->main_opt, 'Option B:')) {
                    $validations['a_value_engineering_percentage'] = 'required';
                }
                if (str_starts_with($contractAppl->main_opt, 'Option B:') || str_starts_with($contractAppl->main_opt, 'Option D:')) {
                    $validations['method_of_measurement_is'] = 'required';
                    $validations['additional_compansation_events'] = 'required';
                }
            } else {
                $validations['insurance_text_1'] = 'required';
                $validations['insurance_min_text_2'] = 'required';
            }
        }

        $validationMessages = [
            'a_value_engineering_percentage.required' => 'A value engineering percentage is required',
            'additional_compansation_events.required' => 'Additional compansation events are required',
            'insurance_min_amount_to_emp_prop.required' => 'This field is required',
            'insurance_text_1.required' => 'This field is required',
            'insurance_min_text_2.required' => 'This field is required',
            'weather_recording_place_is.required' => 'This field is required',
            'weather_recording_snow_hour.required' => 'This field is required',
            'weather_recording_additional.required' => 'This field is required',
            'weather_recording_supplier.required' => 'This field is required',
            'weather_data_recorded_at.required' => 'This field is required',
            'weather_data_available_from.required' => 'This field is required',
            'weather_data_assumed.required' => 'This field is required'
        ];

        $validator = Validator::make(
            $request->all(),
            $validations,
            $validationMessages
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        str_contains($contractType, 'NEC4') &&  $contract->NEC4Contract()->update($request->only(['a_value_engineering_percentage', 'additional_compansation_events']));

        if ($contractAppl->update($request->all())) {
            if (isProductionOrStaging()) {
                $queue_id = Mail::to(admin_profile()->email)->later(now()->addMinutes(4), new ContractEdited($contract));
                debounceJobInQueue('ContractEdited' . $contract->id, $queue_id);
            }

            return redirect('/contracts/' . $id . '/step8');
        }
    }

    // step8 screen
    public function viewStep8($id)
    {

        $contract = Contract::findOrFail($id);
        $contractAppl = ContractApplication::where('contract_id', $id)->first();
        $contractType = $contract->contract_type;
        $createdAdditionalEmployerRisks = $contract->additionalEmployerRisks;
        $createdInsurances = $contract->insurances;
        $workConditions = $contract->contractWorkConditions;
        $adjudicatorProfiles = Profile::where('role', Role::ADJUDICATOR_ID)->get();
        $seniorRepresentativeProfiles = Profile::where('role', Role::SENIOR_REPRESENTATIVE_ID)->get();
        $seniorRepresentatives = $contract->seniorRepresentatives;

        return t_view('contracts.steps.step8', compact(
            'id',
            'contractAppl',
            'contractType',
            'createdAdditionalEmployerRisks',
            'createdInsurances',
            'workConditions',
            'adjudicatorProfiles',
            'seniorRepresentativeProfiles',
            'seniorRepresentatives'
        ));
    }

    // store step8 screen
    public function updateStep8(Request $request, $id)
    {

        $contract = Contract::findOrFail($id);
        $contractType = $contract->contract_type;
        $contractAppl = ContractApplication::where('contract_id', $id)->first();

        $validations = [
            'arbitration_proceedure_is' => 'required',
            'arbitration_place_is' => 'required',
            'arbitration_chooser_is' => 'required',
            'employer_insurance_plant_materials' => 'required',
            'additional_empr' => 'array',
            'new_insurance' => 'array',
        ];


        if (str_starts_with($contractType, 'NEC4')) {
            $validations['insurance_text_1'] = 'required';
            $validations['insurance_min_text_2'] = 'required';
            $validations['employer_insurance_plant_materials'] = 'required';
            $validations['tribunal_is'] = 'required';
            $validations['senior_representatives'] = 'required';
            $validations['adj_id'] = 'required';
            if (str_contains($contractType, 'ECS')) {
                $validations['sub_adj_id'] = 'required';
            }
        } else {
            $validations['first_programme_within'] = 'required';
            if (!$contractAppl->sec_opt_yUK2) {
                $validations['payment_period_not_yuk2_number'] = 'required';
                $validations['payment_period_not_yuk2_text'] = 'required';
            }
            if (str_contains($contractType, 'TSC')) {
                // $validations['ynz1_payment_period'] = 'required';
            } else {
                $validations['completion_date'] = 'required';
                $validations['work_cond'] = 'array';
                if ($contractAppl->sec_opt_yUK2) {
                    $validations['payment_period_yuk2_number'] = 'required';
                    $validations['payment_period_yuk2_text'] = 'required';
                }
            }
        }

        $validationMessages = [
            'arbitration_proceedure_is.required' => 'Arbitration proceedure is required',
            'arbitration_place_is.required' => 'Arbitration place is required',
            'arbitration_chooser_is.required' => 'Arbitration chooser is required',
            'employer_insurance_plant_materials.required' => 'This field is required',
            'additional_empr.required' => 'This field is required',
            'new_insurance.required' => 'This field is required',
            'insurance_text_1.required' => 'This field is required',
            'insurance_min_text_2.required' => 'This field is required',
            'tribunal_is.required' => 'Tribunal is required',
            'senior_representatives.required' => 'Senior representatives are required',
            'adj_id.required' => 'This field is required',
            'sub_adj_id.required' => 'This field is required',
            'first_programme_within.required' => 'This field is required',
            'payment_period_not_yuk2_number.required' => 'This field is required',
            'payment_period_not_yuk2_text.required' => 'This field is required',
            'ynz1_payment_period.required' => 'This field is required',
            'completion_date.required' => 'Completion date is required',
            'work_cond.required' => 'Work conditions are required'
        ];

        $validator = Validator::make(
            $request->all(),
            $validations,
            $validationMessages
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $this->updateHasManyRelationRecords($id, $request["additional_empr"], 'AppTenant\Models\AdditionalEmployerRisk');
        $this->updateHasManyRelationRecords($id, $request["new_insurance"], 'AppTenant\Models\ContractInsurance');
        $this->updateHasManyRelationRecords($id, $request["work_cond"], 'AppTenant\Models\ContractWorkCondition');
        $contract->seniorRepresentatives()->sync($request->senior_representatives);

        if ($contractAppl->update($request->all())) {
            if (isProductionOrStaging()) {
                $queue_id = Mail::to(admin_profile()->email)->later(now()->addMinutes(4), new ContractEdited($contract));
                debounceJobInQueue('ContractEdited' . $contract->id, $queue_id);
            }

            return redirect('/contracts/' . $id . '/step9');
        }
    }



    // step9 screen
    public function viewStep9($id)
    {
        $contract = Contract::findOrFail($id);
        $contractAppl = ContractApplication::where('contract_id', $id)->first();
        $contractType = $contract->contract_type;
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
        $employerProfiles = Profile::where('role', Role::getClientRoleIds())->get();
        $nec4Contract = $contract->NEC4Contract;

        return t_view(
            'contracts.steps.step9',
            compact(
                'id',
                'contractAppl',
                'contractType',
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
                'employerProfiles',
                'nec4Contract'
            )
        );
    }

    // store step9 screen
    public function updateStep9(Request $request, $id)
    {
        $contract = Contract::findOrFail($id);
        $contractAppl = ContractApplication::where('contract_id', $id)->first();
        $contractType = $contract->contract_type;

        $validations = [
            "benificiaries" => 'array',

            "section_compl_dates" => 'array',
            "bonuses" => "array",
            "damages" => "array",
            "to_others" => "array",
            "to_clients" => "array",
            "sub_to_others" => "array"

        ];

        if ($contractAppl->sec_opt_X12) {
            $validations['x12_client_is'] = 'required';
            $validations['x12_client_objective_is'] = 'required';
            $validations['x12_partnering_information_in'] = 'required';
        }

        if ($contractAppl->sec_opt_X20) {
            $validations['x20_incentive_schedule'] = 'required';
            $validations['x20_kpi_number'] = 'required';
        }

        if ($contractType == 'NEC4_TSC') {
            if ($contractAppl->sec_opt_X23) {
                $validations['x23_max_period'] = 'required';
                $validations['extensions'] = 'array';
                // $validations['extension_crite'] = 'array';
            }
            $contractAppl->sec_opt_X24 && !str_starts_with($contractAppl->main_opt, 'Option C') && $validations['accountings'] = 'array';
        }
        $contractAppl->sec_opt_X17 && $validations['x17_end_liability_number'] = 'required|numeric';

        if ($contractAppl->sec_opt_X18) {
            $validations['x18_indirect_loss'] = 'required';
            $validations['x18_loss_damage1'] = 'required';
            $validations['x18_loss_damage2'] = 'required';
            $validations['x18_loss_damage3'] = 'required';
        }

        $contractAppl->sec_opt_Z1 && $validations['add_cond_z1'] = 'required';


        if (str_contains($contractType, 'TSC')) {
            $contractAppl->sec_opt_X17 && $validations['x17_slt'] = 'required';
        } else {
            $validations['low_perform_damages'] = 'array';
        }

        !str_contains($contractType, 'ECS') && $contractAppl->sec_opt_yUK1 && $validations['yuk1_pay_any_charge'] = 'required';

        if (str_starts_with($contractType, 'NEC4')) {
            $contractAppl->sec_opt_X12 && $validations['x12_shedule_is_in'] = 'required';
            $contractAppl->sec_opt_yUK2 && $validations['yuk2_due_payment_period'] = 'required|numeric';
            if (str_contains($contractType, 'TSC')) {
                if ($contractAppl->sec_opt_X19) {
                    $validations['x19_min_service_period'] = 'required|numeric';
                    $validations['x19_notice_period'] = 'required|numeric';
                }
                $contractAppl->sec_opt_yUK2 &&  $validations['yuk2_accounting_period'] = 'required|numeric';
            }
        } else {
            $validations['paf'] = 'array';
            $validations['base_date'] = 'required|date';
            $validations['indices_prepared_by'] = 'required';
            $validations['pay_items'] = 'array';
            if ($contractAppl->sec_opt_X3) {
                $validations['x3_exchange_rates_text'] = 'required';
                $validations['x3_exchange_rates_date'] = 'required|date';
            }
            if (str_contains($contractType, 'TSC')) {
                $contractAppl->sec_opt_X19 &&  $validations['x19_end_task_order_programme_days_number'] = 'required';
            }
        }

        if (in_array(explode(':', $contractAppl->main_opt)[0], ['Option A', 'Option B', 'Option C', 'Option D'])) {
            if (str_starts_with($contractType, 'NEC4')) {
                $validations['paf'] = 'array';
                $validations['base_date'] = 'required|date';
                $validations['indices_prepared_by'] = 'required';
                if (str_contains($contractType, 'TSC')) {
                    $validations['inflation_adjustment_dates'] = 'required';
                }

                if (in_array(explode(':', $contractAppl->main_opt)[0], ['Option A', 'Option B'])) {
                    $validations['pay_items'] = 'array';
                    if ($contractAppl->sec_opt_X3) {
                        $validations['x3_exchange_rates_text'] = 'required';
                        $validations['x3_exchange_rates_date'] = 'required|date';
                    }
                }
            } else {

                if (in_array(explode(':', $contractAppl->main_opt)[0], ['Option C', 'Option D'])) {
                    $validations['share_range_less_than'] = 'required';
                    $validations['less_than_share_percentage'] = 'required';
                    $validations['share_range_from_1'] = 'required';
                    $validations['share_range_to_1'] = 'required';
                    $validations['from_to_share_percentage_1'] = 'required';
                    $validations['share_range_from_2'] = 'required';
                    $validations['share_range_to_2'] = 'required';
                    $validations['from_to_share_percentage_2'] = 'required';
                    $validations['share_range_greater_than'] = 'required';
                    $validations['greater_than_share_percentage'] = 'required';
                    if (str_contains($contractType, 'TSC')) {
                        $validations['share_assesed_on'] = 'required';
                    }
                }
            }
        }

        if (!str_starts_with($contractType, 'NEC4') && in_array(explode(':', $contractAppl->main_opt)[0], ['Option C', 'Option D', 'Option E', 'Option F'])) {
            $validations['max_prepare_forcast_week_interval'] = 'required';
            $validations['exchange_rates_text'] = 'required';
            $validations['exchange_rates_date'] = 'required';
        }

        $validationMessages = [
            'x12_client_is.required' => 'This field is required',
            'x12_client_objective_is.required' => 'This field is required',
            'x12_partnering_information_in.required' => 'This field is required',
            'x13_performance_bond.required' => 'This field is required',
            'x18_indirect_loss.required' => 'This field is required',
            'x18_loss_damage1.required' => 'This field is required',
            'x18_loss_damage2.required' => 'This field is required',
            'x18_loss_damage3.required' => 'This field is required',
            'x20_incentive_schedule.required' => 'This field is required',
            'x20_kpi_number.required' => 'This field is required',
            'x23_max_period.required' => 'This field is required',
            'extensions.required' => 'This field is required',
            'extension_crite.required' => 'This field is required',
            'accountings.required' => 'This field is required',

            'x17_end_liability_number.required' => 'This field is required',
            'benificiaries.required' => 'Benificiaries are required',
            'add_cond_z1.required' => 'This field is required',

            'x17_slt.required' => 'This field is required',
            'low_perform_damages.required' => 'This field is required',
            'yuk1_pay_any_charge.required' => 'This field is required',
            'x12_shedule_is_in.required' => 'This field is required',

            'yuk2_due_payment_period.required' => 'This field is required',
            'x19_end_task_order_programme_days_number.required' => 'This field is required',
            'x19_min_service_period.required' => 'This field is required',
            'x19_notice_period.required' => 'This field is required',
            'yuk2_accounting_period.required' => 'This field is required',

            'paf.required' => 'This field is required',
            'base_date.required' => 'Base date is required',
            'indices_prepared_by.required' => 'This field is required',
            'pay_items.required' => 'This field is required',
            'x3_exchange_rates_text.required' => 'Exchange rates are publised in is required',
            'x3_exchange_rates_date.required' => 'Exchange rates are publised on is required',
            'inflation_adjustment_dates.required' => 'This field is required',

            'share_range_less_than.required' => 'This field is required',
            'less_than_share_percentage.required' => 'This field is required',
            'share_range_from_1.required' => 'This field is required',
            'share_range_to_1.required' => 'This field is required',
            'from_to_share_percentage_1.required' => 'This field is required',
            'share_range_from_2.required' => 'This field is required',
            'share_range_to_2.required' => 'This field is required',
            'from_to_share_percentage_2.required' => 'This field is required',
            'share_range_greater_than.required' => 'This field is required',
            'greater_than_share_percentage.required' => 'This field is required',
            'share_assesed_on.required' => 'This field is required',

            'max_prepare_forcast_week_interval.required' => 'This field is required',
            'exchange_rates_text.required' => 'This field is required',
            'exchange_rates_date.required' => 'This field is required'

        ];

        $validator = Validator::make(
            $request->all(),
            $validations,
            $validationMessages
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $this->updateHasManyRelationRecords($id, $request["paf"], 'AppTenant\Models\ContractPriceAdjustmentFactor');
        $this->updateHasManyRelationRecords($id, $request["pay_items"], 'AppTenant\Models\ContractPayItemActivity');
        $this->updateHasManyRelationRecords($id, $request["section_compl_dates"], 'AppTenant\Models\ContractWorkSectionCompletionDate');
        $this->updateHasManyRelationRecords($id, $request["bonuses"], 'AppTenant\Models\ContractWorkSectionBonus');
        $this->updateHasManyRelationRecords($id, $request["damages"], 'AppTenant\Models\ContractWorkSectionDelayDamage');
        $this->updateHasManyRelationRecords($id, $request["to_others"], 'AppTenant\Models\ContractUndertakingToOthers');
        $this->updateHasManyRelationRecords($id, $request["to_clients"], 'AppTenant\Models\ContractUndertakingToClient');
        $this->updateHasManyRelationRecords($id, $request["sub_to_others"], 'AppTenant\Models\SubcontractorUndertakingToOthers');
        $this->updateHasManyRelationRecords($id, $request["low_perform_damages"], 'AppTenant\Models\ContractLowPerformanceDamageAmount');
        $this->updateHasManyRelationRecords($id, $request["extensions"], 'AppTenant\Models\ContractExtensionPeriod');
        $this->updateHasManyRelationRecords($id, $request["extension_crite"], 'AppTenant\Models\ContractExtensionCriteria');
        $this->updateHasManyRelationRecords($id, $request["accountings"], 'AppTenant\Models\ContractAccountingPeriod');
        $this->updateHasManyRelationRecords($id, $request["benificiaries"], 'AppTenant\Models\ContractBenificiaryTerm');

        $request["x14_bond"] = $request->input('x14_bond') === "on" ? 1 : 0;
        $request["x16_retention_bond"] = $request->input('x16_retention_bond') === "on" ? 1 : 0;

        str_contains($contractType, 'NEC4') &&  NEC4Contract::updateOrCreate(
            ['contract_id' => $id],
            $request->all()
        );

        if ($contractAppl->update($request->all())) {
            if (isProductionOrStaging()) {
                $queue_id = Mail::to(admin_profile()->email)->later(now()->addMinutes(4), new ContractEdited($contract));
                debounceJobInQueue('ContractEdited' . $contract->id, $queue_id);
            }

            return redirect('/contracts/' . $id . '/step10');
        }
    }

    // step10 screen
    public function viewStep10($id)
    {
        $contract = Contract::findOrFail($id);
        $contractData2 = $contract->applicationTwo;
        $contractType = $contract->contract_type;

        $seniorRepresentativeProfiles = Profile::where('role', Role::SENIOR_REPRESENTATIVE_ID)->get();
        $createdSeniorRepresentatives = $contract->partTwoSeniorRepresentatives;
        $createdKeyPeoples = $contract->contractKeyPeoples;
        $contractAppl = $contract->applicationOne;
        $nec4ContractData2 = $contract->partTwoNEC4Contract;

        $createdBoqSchedules = $contract->boqSchedules;
        $createdPriceLists = $contract->priceLists;
        $createdActivitySchedules = $contract->activitySchedules;
        return t_view('contracts.steps.step10', compact(
            'id',
            'contract',
            'contractAppl',
            'contractData2',
            'createdKeyPeoples',
            'createdSeniorRepresentatives',
            'nec4ContractData2',
            'contractType',
            'seniorRepresentativeProfiles',
            'createdBoqSchedules',
            'createdPriceLists',
            'createdActivitySchedules'
        ));
    }

    // store step10 screen
    public function updateStep10(Request $request, $id)
    {
        $contract = Contract::findOrFail($id);
        $contractAppl = $contract->applicationOne;
        $contractType = $contract->contract_type;

        $validations = [
            'direct_fee' => 'required',
            'key_peoples' => 'required|array',
            'risk_register' => 'required',
            // 'contractor_wi1' => 'required',
            // 'contractor_ident_plan' => 'required',
        ];

        if (str_starts_with($contractType, 'NEC4')) {
            $validations['senior_representatives'] = 'required';
            $validations['named_suppliers'] = 'required';
            if (!str_contains($contractType, 'ECS')) {
                $validations['project_bank'] = 'required';
            }
            if (!str_contains($contractType, 'ECC')) {
                $validations['contract_working_areas'] = 'required';
            }
        } else {
            $validations['subcontracted_fee'] = 'required';
            if (str_contains($contractType, 'ECS')) {
                $validations['contract_working_areas'] = 'required';
            }
        }

        if (str_contains($contractType, 'TSC')) {
            $validations['pri_lists'] = 'required|array';
        } else {
            // $validations['completion_date_works'] = 'required';
            if (str_starts_with($contractAppl->main_opt, 'Option B:') || str_starts_with($contractAppl->main_opt, 'Option D:')) {
                $validations['boq_schedules'] = 'required|array';
            } elseif (str_starts_with($contractAppl->main_opt, 'Option A:') || str_starts_with($contractAppl->main_opt, 'Option C:')) {
                $validations['activity_schedules'] = 'required|array';
            }
        }

        if (in_array(explode(':', $contractAppl->main_opt)[0], ['Option A', 'Option B', 'Option C', 'Option D'])) {
            // if (!(str_starts_with($contractAppl->main_opt, 'Option E:') || str_starts_with($contractAppl->main_opt, 'Option F:'))) {
            $validations['total_prices'] = 'required';
        }

        $validationMessages = [
            'direct_fee.required' => 'This field is required',
            'key_peoples.required' => 'Key peoples are required',
            'risk_register.required' => 'This field is required',
            'contractor_wi1.required' => 'This field is required',
            'contractor_ident_plan.required' => 'Identified plan is required',

            'senior_representatives.required' => 'Senior representatives are required',
            'named_suppliers.required' => 'Named suppliers are required',
            'project_bank.required' => 'Project bank is required',
            'contract_working_areas.required' => 'This field is required',
            'pri_lists.required' => 'Price list is required',
            'completion_date_works.required' => 'This field is required',
            'boq_schedules.required' => 'Boq schedules are required',
            'activity_schedules.required' => 'Activity schedules are required',
            'total_prices.required' => 'Tendered total price is required',

        ];

        $validator = Validator::make(
            $request->all(),
            $validations,
            $validationMessages
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        PartTwoContractData::where('contract_id', $id)->first()->update($request->all());
        str_contains($contractType, 'NEC4') &&  $contract->partTwoNEC4Contract()->update($request->only(['x10_info_execution_plan']));

        $this->updateHasManyRelationRecords($id, $request["key_peoples"], 'AppTenant\Models\ContractKeyPeople');
        $contract->partTwoSeniorRepresentatives()->sync($request->senior_representatives);

        $this->updateHasManyRelationRecords($id, $request["boq_schedules"], 'AppTenant\Models\BoqSchedule');
        $this->updateHasManyRelationRecords($id, $request["activity_schedules"], 'AppTenant\Models\ActivitySchedule');
        $this->updateHasManyRelationRecords($id, $request["pri_lists"], 'AppTenant\Models\PriceList');

        if (isProductionOrStaging()) {
            $queue_id = Mail::to(admin_profile()->email)->later(now()->addMinutes(4), new ContractEdited($contract));
            debounceJobInQueue('ContractEdited' . $contract->id, $queue_id);
        }

        if ($contractType === ContractApplicationController::TSC) {
            return redirect('/contracts');
        }

        return redirect('/contracts/' . $id . '/step11');
    }

    // step11 screen
    public function viewStep11($id)
    {
        $contract = Contract::findOrFail($id);
        $contractAppl = $contract->applicationOne;
        $contractType = $contract->contract_type;
        $contractData2 = $contract->applicationTwo;
        $createdOtherEquipments = $contract->contractSizeBaseEquipments()->where('type', 'Other')->get();
        $createdSpecialEquipments = $contract->contractSizeBaseEquipments()->where('type', 'Special')->get();
        $createdTimeEquipments = $contract->contractTimeBaseEquipments;

        $createdOtherDefinedCosts = $contract->contractDefinedCosts()->where('type', 'Other')->get();
        $createdManufactAndFabDefinedCosts = $contract->contractDefinedCosts()->where('type', 'ManufactureAndFabrication')->get();
        $createdDesignCosts = $contract->contractDefinedCosts()->where('type', 'Design')->get();
        $createdSharedDefineCosts = $contract->contractSharedServiceDefinedCosts;
        $nec4ContractData2 = $contract->partTwoNEC4Contract;
        return t_view('contracts.steps.step11', compact(
            'id',
            'contractData2',
            'nec4ContractData2',
            'createdOtherEquipments',
            'createdSpecialEquipments',
            'createdTimeEquipments',
            'createdOtherDefinedCosts',
            'createdManufactAndFabDefinedCosts',
            'createdDesignCosts',
            'createdSharedDefineCosts',
            'contractType',
            'contractAppl'
        ));
    }

    // store step11 screen
    public function updateStep11(Request $request, $id)
    {
        $contract = Contract::findOrFail($id);
        $contractAppl = $contract->applicationOne;
        $contractData2 = $contract->applicationTwo;
        $contractType = $contract->contract_type;
        $validations = [];

        if ($contractType == 'NEC4_TSC') {
            $validations['shared_costs'] = 'array';
        } else {
            $validations['design_defined_costs'] = 'array';
            $validations['design_expenses_cats'] = 'required';
        }

        if (in_array(explode(':', $contractAppl->main_opt)[0], ['Option A', 'Option B'])) {

            $validations['equipment_publisher'] = 'required';
            $validations['equipment_adj'] = 'required';
            $validations['other_equipments'] = 'array';

            if (str_starts_with($contractType, 'NEC4')) {
                $validations['manufact_fabric_defined_costs'] = 'array';
                $validations['other_defined_costs'] = 'array';
            } else {
                $validations['people_oh_percent'] = 'required';
                $validations['design_oh_percent'] = 'required';
            }
        } elseif (in_array(explode(':', $contractAppl->main_opt)[0], ['Option C', 'Option D', 'Option E'])) {

            $validations['time_equipments'] = 'array';
            $validations['special_equipments'] = 'array';
            $validations['manufact_fabric_defined_costs'] = 'array';

            if (!str_starts_with($contractType, 'NEC4')) {
                $validations['people_oh_percent'] = 'required';
                $validations['design_oh_percent'] = 'required';
                $validations['equipment_publisher'] = 'required';
                $validations['equipment_adj'] = 'required';
                $validations['other_equipments'] = 'array';
            }
        }

        $validationMessages = [

            'shared_costs.required' => 'This field is required',
            'design_defined_costs.required' => 'This field is required',
            'design_expenses_cats.required' => 'Categories of design people is required',
            'equipment_publisher.required' => 'Equipment publisher is required',
            'equipment_adj.required' => 'Percentage adjustment for Equipment in the published list is required',
            'other_equipments.required' => 'This field is required',
            'manufact_fabric_defined_costs.required' => 'This field is required',
            'other_defined_costs.required' => 'This field is required',
            'people_oh_percent.required' => 'The percentage for people overheads is required',
            'design_oh_percent.required' => 'The percentage for design overheads is required',
            'time_equipments.required' => 'This field is required',
            'special_equipments.required' => 'This field is required'
        ];

        $validator = Validator::make(
            $request->all(),
            $validations,
            $validationMessages
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $this->updateHasManyRelationRecords($id, $request["other_equipments"], 'AppTenant\Models\ContractSizeBaseEquipment', 'Other');
        $this->updateHasManyRelationRecords($id, $request["special_equipments"], 'AppTenant\Models\ContractSizeBaseEquipment', 'Special');
        $this->updateHasManyRelationRecords($id, $request["time_equipments"], 'AppTenant\Models\ContractTimeBaseEquipment');
        $this->updateHasManyRelationRecords($id, $request["shared_costs"], 'AppTenant\Models\ContractSharedServiceDefinedCost');
        $this->updateHasManyRelationRecords($id, $request["other_defined_costs"], 'AppTenant\Models\ContractDefinedCost', 'Other');
        $this->updateHasManyRelationRecords($id, $request["manufact_fabric_defined_costs"], 'AppTenant\Models\ContractDefinedCost', 'ManufactureAndFabrication');
        $this->updateHasManyRelationRecords($id, $request["design_defined_costs"], 'AppTenant\Models\ContractDefinedCost', 'Design');

        str_contains($contractType, 'NEC4') &&  PartTwoNec4ContractData::where('contract_id', $id)->first()->update($request->all());

        $contractData2->update($request->all());

        if (isProductionOrStaging()) {
            $queue_id = Mail::to(admin_profile()->email)->later(now()->addMinutes(4), new ContractEdited($contract));
            debounceJobInQueue('ContractEdited' . $contract->id, $queue_id);
        }

        return redirect('/contracts');
    }

    public function updateHasManyRelationRecords($contractId, $dataArray, $model, $type = null)
    {
        $query = $model::where('contract_id', $contractId);
        $type &&  $query =  $query->where('type', $type);
        if (is_array($dataArray) && count($dataArray)) {
            $query->whereNotIn('id', array_diff(array_column($dataArray, 'id'), ['NEW']))->delete();
            // $query->whereNotIn('id', array_column($dataArray, 'id'))->delete();
            foreach ($dataArray as $data) {
                if ($data["id"] == "NEW") {
                    unset($data["id"]);
                    $model::create($data);
                } else {
                    $employerRisk = $model::findOrFail($data["id"]);
                    $employerRisk->update($data);
                }
            }
        } else {
            $query->delete();
        }
    }
}
