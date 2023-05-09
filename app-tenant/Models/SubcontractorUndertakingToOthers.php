<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubcontractorUndertakingToOthers extends BaseModel
{
    use HasFactory;

    protected $table = 'subcontractor_undertakings_to_others';
    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'contract_id',
        'work',
        'provided_to',
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
