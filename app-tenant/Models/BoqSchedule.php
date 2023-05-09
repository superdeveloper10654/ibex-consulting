<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoqSchedule extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'boq_schedules';
    protected $guarded = [
        'id',
    ];
    protected $fillable = [
        'id',
        'contract_id',
        'qty',
        'item',
        'unit',
        'rate'
    ];

    public function contractData()
    {
        return $this->belongsTo('AppTenant\Models\Contract', 'contract_id');
    }
}
