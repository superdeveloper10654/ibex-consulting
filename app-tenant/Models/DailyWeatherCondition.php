<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyWeatherCondition extends BaseModel
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'daily_weather_conditions';

    protected $fillable = [
        'daily_work_record_id',
        'time',
        'observation',
        'air',
        'ground',
        'wind'
    ];
}
