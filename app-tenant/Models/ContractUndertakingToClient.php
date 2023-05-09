<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContractUndertakingToClient extends BaseModel
{
    use HasFactory;

    protected $table = 'contract_undertakings_to_clients';
    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'contract_id',
        'work',
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
