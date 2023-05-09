<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContractLowPerformanceDamageAmount extends BaseModel
{
    use HasFactory;

    protected $table = 'contract_low_performance_damage_amounts';
    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'contract_id',
        'performance_level',
        'amount',
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
