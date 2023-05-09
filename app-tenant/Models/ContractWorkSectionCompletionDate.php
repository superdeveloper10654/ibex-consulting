<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContractWorkSectionCompletionDate extends BaseModel
{
    use HasFactory;

    protected $table = 'contract_work_section_completion_dates';
    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'contract_id',
        'description',
        'completion_date',
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
