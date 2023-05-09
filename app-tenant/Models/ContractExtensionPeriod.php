<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContractExtensionPeriod extends BaseModel
{
    use HasFactory;

    protected $table = 'contract_extension_periods';
    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'contract_id',
        'period',
        'notice_date',
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
