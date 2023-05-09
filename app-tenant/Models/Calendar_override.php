<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Calendar_override extends BaseModel
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'programme_id',
        'calendar_id',
        'start_date',
        'end_date'
    ];
}
