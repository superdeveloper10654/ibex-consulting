<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContractKeyPeople extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'contract_key_peoples';
    protected $guarded = [
        'id',
    ];
    protected $fillable = [
        'id',
        'contract_id',
        'name',
        'job',
        'qualification',
        'responsibility',
        'experience'
    ];

    public function contractData()
    {
        return $this->belongsTo('AppTenant\Models\Contract', 'contract_id');
    }
}
