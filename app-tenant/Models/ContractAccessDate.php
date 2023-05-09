<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContractAccessDate extends BaseModel
{
    use HasFactory;

    protected $table = 'contract_access_dates';
    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'contract_id',
        'part_of_the_site',
        'date',
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
