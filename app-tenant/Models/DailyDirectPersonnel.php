<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyDirectPersonnel extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'daily_direct_personnels';

    protected $fillable = [
        'daily_work_record_id',
        'direct_personnel_id',
        'worked_hours'
    ];

    public function directPersonnel()
    {
        return $this->belongsTo('AppTenant\Models\DirectPersonnel', 'direct_personnel_id');
    }
}
