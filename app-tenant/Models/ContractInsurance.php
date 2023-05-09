<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContractInsurance extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'contract_insurances';
    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'contract_id',
        'insurance_against',
        'cover_or_indemnity',
        'deductibles',
        'is_additional',
        'provider'
    ];

    /**
     * contract relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}
