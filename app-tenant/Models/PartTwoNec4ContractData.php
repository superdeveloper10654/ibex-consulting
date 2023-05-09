<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PartTwoNec4ContractData extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'part_two_nec4_contract_datas';
    protected $guarded = [
        'id',
    ];
    protected $fillable = [
        'id',
        'contract_id',

        'activity_schedule_is',
        'x10_info_execution_plan',

    ];

    public function contractData()
    {
        return $this->belongsTo('AppTenant\Models\Contract', 'contract_id');
    }
}
