<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContractPayItemActivity extends BaseModel
{
    use HasFactory;

    protected $table = 'contract_pay_item_activities';
    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'contract_id',
        'item_or_activity',
        'other_currency',
        'total_max_payment'
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
