<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailySubContractOrHiredVehiclesAndPlant extends BaseModel
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'daily_sub_contract_or_hired_vehicles_and_plants';

    protected $fillable = [
        'daily_work_record_id',
        'subcontract_or_hired_vehicles_and_plant_id',
        'comments'
    ];
    public function subcontractOrHiredVehicleAndPlant()
    {
        return $this->belongsTo('AppTenant\Models\SubcontractOrHiredVehicleAndPlant', 'subcontract_or_hired_vehicles_and_plant_id');
    }
}
