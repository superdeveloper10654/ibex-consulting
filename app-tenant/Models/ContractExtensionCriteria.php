<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContractExtensionCriteria extends BaseModel
{
    use HasFactory;

    protected $table = 'contract_extension_criteria';
    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'contract_id',
        'criteria',
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
