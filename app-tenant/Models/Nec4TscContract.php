<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nec4TscContract extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'nec4_tsc_contracts';

    // protected $casts = [
    //     'share_assesed_on' => 'array'
    // ];

    protected $fillable = [
        'id',
        'contract_id',
        'senior_representative_name_1',
        'senior_representative_name_2',
        'senior_representative_address_1',
        'senior_representative_address_2',
        'senior_representative_electronic_address_1',
        'senior_representative_electronic_address_2',
        'indices_are',
        'inflation_adjustment_dates',
        'undertakings_provide_to_1',
        'undertakings_provide_to_2',
        'subcontractor_undertakings_works_1',
        'subcontractor_undertakings_works_2',
        'subcontractor_undertakings_provide_to_1',
        'subcontractor_undertakings_provide_to_2',
        'subcontractor_undertakings_client_works_1',
        'subcontractor_undertakings_client_works_2',
        'x10_info_exec_plan_period',
        'x10_min_insurance_amount',
        'x10_service_period_end',
        'x12_promoter_is',
        'x12_shedule_is_in',
        'x12_promortors_objective',
        'x19_min_service_period',
        'x19_notice_period',
        'x23_max_period',
        'employer_electronic_address_is',
        'sm_electronic_address_is',
        'adj_electronic_address_is',
        'outside_works_information',
        'except_period_for_reply_for_1',
        'except_period_for_reply_is_1',
        'except_period_for_reply_for_2',
        'except_period_for_reply_is_2',
        'early_warnings_no_longer_than',
        'revised_plans_interval_no_longer_than',
        'end_task_order_programme_period',
        'quality_policy_plan_period',
        'final_assessment_period',
        'a_value_engineering_percentage',
        'additional_compansation_events',
        'x23_extension_period_1',
        'x23_notice_date_1',
        'x23_extension_period_2',
        'x23_notice_date_2',
        'x23_extension_period_3',
        'x23_notice_date_3',
        'x23_extension_period_4',
        'x23_notice_date_4',
        'x23_extension_criteria_1',
        'x23_extension_criteria_2',
        'x23_extension_criteria_3',
        'x24_account_period_1',
        'x24_account_period_2',
        'x24_account_period_3',
        'x24_account_period_4',
        'yuk2_accounting_period',
        'yuk2_due_payment_period'
    ];

    public function contractData()
    {
        return $this->belongsTo('AppTenant\Models\Contract', 'contract_id');
    }

    public function exceptReplyPeriods()
    {
        return $this->hasMany('AppTenant\Models\ExceptReplyPeriod', 'contract_id', 'contract_id');
    }
}
