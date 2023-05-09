<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NEC4Contract extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'nec4_contracts';

    // protected $casts = [
    //     'share_assesed_on' => 'array'
    // ];

    protected $fillable = [
        'id',
        'contract_id',

        'employer_electronic_address_is',
        'inflation_adjustment_dates',

        'is_takeover_completion_date',
        'takeover_completion_date',

        'x10_info_exec_plan_period',
        'x10_min_insurance_amount',
        'x10_service_period_end',

        'x12_shedule_is_in',

        'x15_retention_period',
        'x15_min_insurance_amount',
        'x15_completion_or_termination_period',

        'x16_retention_bond',

        'x19_min_service_period',
        'x19_notice_period',
        'x23_max_period',
        'outside_works_information',
        'early_warnings_no_longer_than',
        'revised_plans_interval_no_longer_than',
        'end_task_order_programme_period',
        'quality_policy_plan_period',
        'final_assessment_period',
        'a_value_engineering_percentage',
        'additional_compansation_events',


        'yuk2_accounting_period',
        'yuk2_due_payment_period'
    ];

    public function contractData()
    {
        return $this->belongsTo('AppTenant\Models\Contract', 'contract_id');
    }
}
