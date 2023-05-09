<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContractTimeBaseEquipment extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'contract_time_base_equipments';
    protected $guarded = [
        'id',
    ];
    protected $fillable = [
        'id',
        'contract_id',
        'name',
        'time_related_charge',
        'per_time_period',
    ];

    public function contractData()
    {
        return $this->belongsTo('AppTenant\Models\Contract', 'contract_id');
    }
}
