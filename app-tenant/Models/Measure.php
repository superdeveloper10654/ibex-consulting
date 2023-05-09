<?php

namespace AppTenant\Models;

use AppTenant\Models\Status\MeasureStatus;
use AppTenant\Models\Trait\HasStatus;
use BeyondCode\Comments\Traits\HasComments;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Measure extends BaseModel
{
    use HasFactory, HasComments, HasStatus, SoftDeletes;

    /** @var string activity icon */
    public static $activity_icon = '<i class="mdi mdi-bank"></i>';

    protected $fillable = [
        'contract_id',
        'profile_id',
        'site_name',
        'quantified_items', 
        'linear_items',
        'description', 
        'status', 
    ];

    protected $casts = [
        'quantified_items'  => 'array',
        'linear_items'      => 'array',
    ];

    /**
     * Applications relation
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function applications()
    {
        return $this->hasMany(Application::class, 'measure_id');
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
     * Formats quantified_items array
     * 
     * @param string $values
     * 
     * @return array<object>
     */
    public function getQuantifiedItemsAttribute($values)
    {
        $values = json_decode($values);

        foreach ($values as $i => $value) {
            $values[$i]->rate_card = isset($value->rate_card_id) ? RateCard::find($value->rate_card_id) : '';
            $values[$i]->lat = (float) $values[$i]->lat;
            $values[$i]->lng = (float) $values[$i]->lng;
        }

        return $values;
    }

    /**
     * Formats linear_items array
     * 
     * @param string $values
     * 
     * @return array<object>
     */
    public function getLinearItemsAttribute($values)
    {
        $values = (array) json_decode($values);

        foreach ($values as $i => $value) {
            $values[$i]->rate_card = isset($value->rate_card_id) ? RateCard::find($value->rate_card_id) : '';
            $values[$i]->coords = array_map(function($item) {
                $item->lat = (float) $item->lat;
                $item->lng = (float) $item->lng;
    
                return $item;
            }, $values[$i]->coords);
        }

        return $values;
    }
}
