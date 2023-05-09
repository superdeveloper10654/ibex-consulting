<?php

namespace AppTenant\Models;

use AppTenant\Models\Status\EarlyWarningStatus;
use AppTenant\Models\Trait\HasStatus;
use BeyondCode\Comments\Traits\HasComments;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EarlyWarning extends BaseModel
{
    use HasFactory, HasComments, HasStatus;

    /** @var string activity icon */
    public static $activity_icon = '<i class="mdi mdi-alert-outline text-danger"></i>';

    protected $fillable = [
        'profile_id',
        'contract_id',
        'programme_id',
        'title',
        'description', 
        'effect1',
        'effect2', 
        'effect3',
        'effect4', 
        'risk_score', 
        'status',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Profile relation
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author_profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id');
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
     * Programme relation
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function programme()
    {
        return $this->belongsTo(Programme::class);
    }

    /**
     * Mitigation relation
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function mitigation()
    {
        return $this->hasOne(Mitigation::class)->notDrafted();
    }

    /**
     * Compensation event relation
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function compensation_event()
    {
        return $this->hasOne(CompensationEvent::class)->notDrafted();
    }

    /**
     * Return risk score color by score value. If no value passed - return array of score => color
     * 
     * @param int $score
     * @return string
     */
    public static function riskScoreColor($score = null)
    {
        $colors = ['5' => '#7EAA55', '10' => '#F6C142', '15' => '#FF9900', '20' => '#EB3323', '25' => '#B60B10', '4' => '#7EAA55', '8' => '#F6C142', '12' => '#FF9900', '16' => '#EB3323', '3' => '#7EAA55', '6' => '#F6C142', '9' => '#F6C142', '2' => '#7EAA55', '1' => '#AECB94',];

        return $score !== null ? $colors[$score] : $colors;
    }

    /**
     * Return risk score color by score value
     * 
     * @return string
     */
    public function getRiskScoreColorAttribute()
    {
        return static::riskScoreColor($this->risk_score);
    }
}
