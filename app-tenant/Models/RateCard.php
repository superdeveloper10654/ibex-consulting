<?php

namespace AppTenant\Models;

use AppTenant\Models\Statical\RateCardUnit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RateCard extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'contract_id',
        'ref',
        'item_desc',
        'unit',
        'rate',
        'pin_id',
    ];

    /**
     * Rate Card Pin relation
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pin()
    {
        return $this->belongsTo(RateCardPin::class, 'pin_id');
    }

    /**
     * Contract relation
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    /**
     * Set unit id to unit string
     *
     * @param  string  $value
     * @return void
     */
    public function getUnitAttribute($value)
    {
        return RateCardUnit::get($value)->name;
    }

    protected function getUnitIdAttribute()
    {
        return $this->attributes['unit'];
    }

    /**
     * Creates html for pin icon
     *
     * @param  string  $value
     * @return string
     */
    public function getPinHtmlAttribute()
    {
        return $this->pin->html;
    }
}
