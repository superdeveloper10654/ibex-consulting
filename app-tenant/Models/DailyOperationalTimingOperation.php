<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyOperationalTimingOperation extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'daily_operational_timing_operations';

    protected $fillable = [
        'daily_work_record_id',
        'operation_id',
        'started',
        'completed',
        'comments'
    ];
    public function operation()
    {
        return $this->belongsTo('AppTenant\Models\Operation', 'operation_id');
    }
}
