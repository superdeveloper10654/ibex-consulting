<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContractDefectCorrectionExceptPeriod extends BaseModel
{
    use HasFactory;

    protected $table = 'contract_defect_correction_except_periods';
    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'contract_id',
        'period_for',
        'period_is',
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
