<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContractWorkCondition extends BaseModel
{
    use HasFactory;

    protected $table = 'contract_work_conditions';
    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'contract_id',
        'condition',
        'key_date',
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
