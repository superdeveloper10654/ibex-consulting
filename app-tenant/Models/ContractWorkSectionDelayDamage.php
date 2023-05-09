<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContractWorkSectionDelayDamage extends BaseModel
{
    use HasFactory;

    protected $table = 'contract_work_section_delay_damages';
    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'contract_id',
        'description',
        'amount_per_day',
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
