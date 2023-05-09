<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailySubContractPersonnel extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'daily_subcontract_personnels';

    protected $fillable = [
        'daily_work_record_id',
        'subcontract_personnel_id',
        'worked_hours', 
        'comments'
    ];
    public function subContractPersonnel()
    {
        return $this->belongsTo('AppTenant\Models\SubcontractPersonnel', 'subcontract_personnel_id');
    }
}
