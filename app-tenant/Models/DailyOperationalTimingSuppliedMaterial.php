<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyOperationalTimingSuppliedMaterial extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'daily_operational_timing_supplied_materials';

    protected $fillable = [
        'daily_work_record_id',
        'material_id',
        'started',
        'completed',
        'comments'
    ];
    public function material()
    {
        return $this->belongsTo('AppTenant\Models\Material', 'material_id');
    }
}
