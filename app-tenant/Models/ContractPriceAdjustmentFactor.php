<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContractPriceAdjustmentFactor extends BaseModel
{
    use HasFactory;

    protected $table = 'contract_price_adjustment_factors';
    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'contract_id',
        'proportion',
        'factor',
        'is_non_adjustable'
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
