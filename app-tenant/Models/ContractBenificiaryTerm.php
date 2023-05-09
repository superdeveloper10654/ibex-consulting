<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContractBenificiaryTerm extends BaseModel
{
    use HasFactory;

    protected $table = 'contract_benificiary_terms';
    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'contract_id',
        'term',
        'benificiary',
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
