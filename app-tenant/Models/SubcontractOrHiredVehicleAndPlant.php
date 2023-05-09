<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubcontractOrHiredVehicleAndPlant extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'subcontract_or_hired_vehicles_and_plants';

    protected $fillable = [
        'vehicle_or_plant_name',
        'supplier_name',
        'ref_no',
    ];
}
