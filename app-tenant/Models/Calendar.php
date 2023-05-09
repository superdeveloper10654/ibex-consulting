<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Calendar extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'start_hour',
        'start_minute',
        'end_hour',
        'end_minute',
        'working_day_monday',
        'working_day_tuesday',
        'working_day_wednesday',
        'working_day_thursday',
        'working_day_friday',
        'working_day_saturday',
        'working_day_sunday',
        'is_default_task_calendar',
        'type',
    ];
}
