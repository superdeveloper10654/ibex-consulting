<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdditionalEmployerRisk extends BaseModel
{
    use HasFactory;

    protected $table = 'additional_employer_risks';
    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'contract_id',
        'risk',
        'provider'
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
