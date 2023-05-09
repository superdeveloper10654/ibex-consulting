<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContractApplication extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'contract_applications';
    protected $guarded = [
        'id',
    ];
    protected $fillable = [
        'id',
        'contract_id',

        // step2 attr
        'main_opt',
        'resolution_opt',
        'sec_opt_X1',
        'sec_opt_X2',
        'sec_opt_X3',
        'sec_opt_X4',
        'sec_opt_X5',
        'sec_opt_X6',
        'sec_opt_X7',
        'sec_opt_X8',
        'sec_opt_X9',
        'sec_opt_X10',
        'sec_opt_X11',
        'sec_opt_X12',
        'sec_opt_X13',
        'sec_opt_X14',
        'sec_opt_X15',
        'sec_opt_X16',
        'sec_opt_X17',
        'sec_opt_X18',
        'sec_opt_X19',
        'sec_opt_X20',
        'sec_opt_X23',
        'sec_opt_X24',
        'sec_opt_yUK1',
        'sec_opt_yUK2',
        'sec_opt_yUK3',
        'sec_opt_Z1',

        // step3 attr
        'works_are',
        'subcontract_works_are',
        // 'employer_or_client_id',
        'employer_name_is',
        'employer_address_is',
        'pm_or_sm_id',
        'sup_id',
        'adj_id',
        'sub_adj_id',
        'affected_property_is',

        // step4 attr
        'works_information_is_in',
        'wi100',
        'wi200',
        'wi300',
        'wi400',
        'wi500',
        'wi600',
        'wi700',
        'wi800',
        'wi900',
        'wi1000',
        'wi1100',
        'wi1200',
        'wi1300',
        'wi2000',
        'site_information_is_in',
        'boundaries_are',
        'language_is',
        'law_is',
        'period_for_reply_is',
        'subcontractor_period_for_reply_is',
        'adjudicator_body_is',
        'tribunal_is',
        'risk_register_matters_are',

        'affected_property_is',

        //  step5
        'starting_date',
        'service_period_is',
        'programme_interval_is',

        // step6
        'defects_date',
        'defect_correction_period',
        'currency_is',
        'assessment_interval',
        'interest_rate_percentage',
        'interest_rate_text_1',
        'interest_rate_text_2',

        // step 7
        'weather_recording_place_is',
        'weather_recording_snow_hour',
        'weather_recording_additional',
        'weather_recording_supplier',
        'weather_data_recorded_at',
        'weather_data_available_from',
        'weather_data_assumed',

        // step 7 / 8
        'insurance_min_amount_to_emp_prop',
        'insurance_text_1',
        'insurance_min_text_2',

        // step 8
        'arbitration_proceedure_is',
        'arbitration_place_is',
        'arbitration_chooser_is',
        'completion_date',
        'first_programme_within',

        'payment_period_not_yuk2_number',
        'payment_period_not_yuk2_text',
        'payment_period_yuk2_number',
        'payment_period_yuk2_text',

        'employer_insurance_plant_materials',

        'ynz1_payment_period',

        'method_of_measurement_is',
        'method_of_measurement_amendments',
        'max_prepare_forcast_week_interval',

        // step 9

        'share_range_less_than',
        'less_than_share_percentage',
        'share_range_from_1',
        'share_range_to_1',
        'from_to_share_percentage_1',
        'share_range_from_2',
        'share_range_to_2',
        'from_to_share_percentage_2',
        'share_range_greater_than',
        'greater_than_share_percentage',
        'share_assesed_on',

        'exchange_rates_text',
        'exchange_rates_date',

        'base_date',
        'indices_prepared_by',

        'x3_exchange_rates_text',
        'x3_exchange_rates_date',

        'bonus_remainder_number',
        'delay_damages_remainder_number',

        'x6_bonus_number',
        'x7_delay_damages_number',
        'x12_client_is',
        'x12_client_objective_is',
        'x12_partnering_information_in',
        'x13_performance_bond',
        'x14_advanced_payment',
        'x14_instalments_weeks',
        'x14_instalments_amount_or_percentage',
        'x14_bond',

        'x16_retention_free_amount',
        'x16_retention_percent',

        'x17_end_liability_number',
        'x17_slt',

        'x19_end_task_order_programme_days_number',

        'x18_indirect_loss',
        'x18_loss_damage1',
        'x18_loss_damage2',
        'x18_loss_damage3',
        'x20_incentive_schedule',
        'x20_kpi_number',

        'yuk1_pay_any_charge',

        'add_cond_z1',
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
