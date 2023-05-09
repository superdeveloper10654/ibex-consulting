<?php

namespace AppTenant\Models;

use AppTenant\Models\Status\ApplicationStatus;
use AppTenant\Models\Trait\HasStatus;
use BeyondCode\Comments\Traits\HasComments;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends BaseModel
{
    use HasFactory, HasComments, HasStatus, SoftDeletes;

    /** @var string activity icon */
    public static $activity_icon = '<i class="mdi mdi-bank"></i>';

    protected $fillable = [
        'profile_id',
        'period_from',
        'perion_to',
        'title',
        'description',
        'items',
        'net',
        'period_from',
        'period_to',
        'status',
        'contract_id',
        'measure_id',
    ];

    protected $casts = [
        'period_from'   => 'datetime',
        'period_to'     => 'datetime',
        'items'         => 'array',
    ];

    /**
     * Assessment relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assessment()
    {
        return $this->hasOne(Assessment::class);
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
     * Measure relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function measure()
    {
        return $this->belongsTo(Measure::class);
    }

    /**
     * Change status to Certified
     * @param integer $certified_by
     */
    public function certify($certified_by)
    {
        $this->certified_by = $certified_by;
        $this->certified_at = date('Y-m-d H:i:s');
        $this->status = ApplicationStatus::CERTIFIED_ID;

        return $this->update();
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
        $values = (array) json_decode($values);

        foreach ($values as $i => $value) {
            $values[$i]->rate_card = isset($value->rate_card_id) ? RateCard::find($value->rate_card_id) : '';
        }

        return $values;
    }
}
