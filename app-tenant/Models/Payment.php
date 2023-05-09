<?php

namespace AppTenant\Models;

use AppTenant\Models\Trait\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends BaseModel
{
    use HasFactory, HasStatus, SoftDeletes;

    /** @var string activity icon */
    public static $activity_icon = '<i class="mdi mdi-bank"></i>';

    protected $fillable = [
        'contract_id',
        'assessment_id',
        'description',
        'from_date',
        'due_date',
        'items',
        'cuml_net',
        'status',
    ];

    protected $casts = [
        'due_date'  => 'datetime',
        'items'     => 'array',
    ];

    /**
     * Assessment relation
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
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
     * Profile relation
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    /**
     * Formats items array
     * 
     * @param string $values
     * 
     * @return array<object>
     */
    public function getItemsAttribute($values)
    {
        $values = json_decode($values);

        foreach ($values as $i => $value) {
            $values[$i]->rate_card = isset($value->rate_card_id) ? RateCard::find($value->rate_card_id) : '';
        }

        return $values;
    }
}
