<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PartTwoContractData extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'part_two_contract_datas';
    protected $guarded = [
        'id',
    ];


    protected $fillable = [
        'id',
        'contract_id',

        'profile_id',
        'direct_fee',
        'subcontracted_fee',
        'contract_working_areas',
        'completion_date_works',
        'risk_register',
        'contractor_wi1',
        'contractor_ident_plan',
        'total_prices',
        'named_suppliers',
        'project_bank',

        'percent_work_area_oh',
        'manufacture_fab_oh',
        'design_oh_percent',
        'design_expenses_cats',
        'equipment_publisher',
        'equipment_adj',
        'contractor_ident_prog',
        'contractor_wi2',
        'people_oh_percent',

    ];

    public function contractData()
    {
        return $this->belongsTo('AppTenant\Models\Contract', 'contract_id');
    }
}
