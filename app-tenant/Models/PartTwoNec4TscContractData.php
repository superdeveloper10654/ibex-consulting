<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PartTwoNec4TscContractData extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'part_two_nec4_tsc_contract_datas';

    protected $fillable = [
        'id',
        'contract_id',
        'contractor_electronic_address_is',
        'fee_percentage',
        'service_areas_are',
        'senior_representative_name_1',
        'senior_representative_address_1',
        'senior_representative_electronic_address_1',
        'senior_representative_name_2',
        'senior_representative_address_2',
        'senior_representative_electronic_address_2',
        'x10_info_execution_plan',
        'sorter_schedule_shared_service_1',
        'sorter_schedule_shared_service_2',
        'sorter_schedule_shared_service_3',
        'sorter_schedule_shared_service_4',
        'sorter_schedule_shared_service_person_category_1',
        'sorter_schedule_shared_service_person_category_2',
        'sorter_schedule_shared_service_person_category_3',
        'sorter_schedule_shared_service_person_category_4',
        'sorter_schedule_shared_service_rate_1',
        'sorter_schedule_shared_service_rate_2',
        'sorter_schedule_shared_service_rate_3',
        'sorter_schedule_shared_service_rate_4',
        'schedule_equipment_1',
        'schedule_equipment_2',
        'schedule_equipment_3',
        'schedule_equipment_4',
        'schedule_equipment_charge_1',
        'schedule_equipment_charge_2',
        'schedule_equipment_charge_3',
        'schedule_equipment_charge_4',
        'schedule_equipment_time_period_1',
        'schedule_equipment_time_period_2',
        'schedule_equipment_time_period_3',
        'schedule_equipment_time_period_4',
        'special_equipment_text_1',
        'special_equipment_text_2',
        'special_equipment_text_3',
        'special_equipment_text_4',
        'special_equipment_rate_1',
        'special_equipment_rate_2',
        'special_equipment_rate_3',
        'special_equipment_rate_4',
        'schedule_defined_cost_design_text_1',
        'schedule_defined_cost_design_text_2',
        'schedule_defined_cost_design_text_3',
        'schedule_defined_cost_design_text_4',
        'schedule_defined_cost_design_rate_1',
        'schedule_defined_cost_design_rate_2',
        'schedule_defined_cost_design_rate_3',
        'schedule_defined_cost_design_rate_4',
        'schedule_shared_service_1',
        'schedule_shared_service_2',
        'schedule_shared_service_3',
        'schedule_shared_service_4',
        'schedule_shared_service_person_category_1',
        'schedule_shared_service_person_category_2',
        'schedule_shared_service_person_category_3',
        'schedule_shared_service_person_category_4',
        'schedule_shared_service_rate_1',
        'schedule_shared_service_rate_2',
        'schedule_shared_service_rate_3',
        'schedule_shared_service_rate_4',
        'people_rate_person_1',
        'people_rate_person_2',
        'people_rate_person_3',
        'people_rate_person_4',
        'people_rate_unit_1',
        'people_rate_unit_2',
        'people_rate_unit_3',
        'people_rate_unit_4',
        'people_rate_1',
        'people_rate_2',
        'people_rate_3',
        'people_rate_4',

    ];

    public function contractData()
    {
        return $this->belongsTo('AppTenant\Models\Contract', 'contract_id');
    }
}
