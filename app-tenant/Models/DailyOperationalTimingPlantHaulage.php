<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyOperationalTimingPlantHaulage extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'daily_operational_timing_plant_haulages';

    protected $fillable = [
        'daily_work_record_id',
        'plant_haulage',
        'started',
        'completed',
        'comments'
    ];
}
