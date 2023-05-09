<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContractSharedServiceDefinedCost extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'contract_shared_service_defined_costs';
    protected $guarded = [
        'id',
    ];
    protected $fillable = [
        'id',
        'contract_id',
        'category_of_person',
        'shared_service',
        'rate',
    ];

    public function contractData()
    {
        return $this->belongsTo('AppTenant\Models\Contract', 'contract_id');
    }
}
