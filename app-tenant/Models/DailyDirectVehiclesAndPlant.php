<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyDirectVehiclesAndPlant extends BaseModel
{
    use HasFactory, SoftDeletes;
    protected $table = 'daily_direct_vehicles_and_plants';

    protected $fillable = [
        'daily_work_record_id',
        'direct_vehicles_and_plant_id',
        'comments'
    ];
    public function directVehicleAndPlant()
    {
        return $this->belongsTo('AppTenant\Models\DirectVehicleAndPlant', 'direct_vehicles_and_plant_id');
    }
}
