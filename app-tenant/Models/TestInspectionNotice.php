<?php

namespace AppTenant\Models;

use BeyondCode\Comments\Traits\HasComments;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestInspectionNotice extends BaseModel
{
    use HasFactory, HasComments, SoftDeletes;

    /** @var string activity icon */
    // public static $activity_icon = '<i class="mdi mdi-bank"></i>';

    // protected $fillable = [
    //     'works_id',
    //     'period_from', 
    //     'perion_to',
    //     'title',
    //     'description', 
    //     'items',
    //     'net',
    //     'period_from', 
    //     'period_to',
    //     'status', 
    // ];

    // protected $casts = [
    //     'period_from'   => 'datetime',
    //     'period_to'     => 'datetime',
    //     'items'         => 'array',
    // ];

    /**
     * Works relation
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    // public function works()
    // {
    //     return $this->belongsTo(Works::class);
    // }

    /**
     * Status object 
     * 
     * @return object<id,value>
     */
    // public function status()
    // {
    //     return ApplicationStatus::get($this->status);
    // }

    /**
     * Formats items array
     * 
     * @param string $values
     * @return array<object>
     */
    // public function getItemsAttribute($values)
    // {
    //     $values = (array) json_decode($values);

    //     foreach ($values as $i => $value) {
    //         $values[$i]->rate_card = isset($value->rate_card_id) ? RateCard::find($value->rate_card_id) : '';
    //     }

    //     return $values;
    // }
}
