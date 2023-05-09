<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContractAccountingPeriod extends BaseModel
{
    use HasFactory;

    protected $table = 'contract_accounting_periods';
    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'contract_id',
        'period',
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
