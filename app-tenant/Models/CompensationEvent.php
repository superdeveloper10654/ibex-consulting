<?php

namespace AppTenant\Models;

use AppTenant\Models\Status\CompensationEventStatus;
use AppTenant\Models\Trait\HasStatus;
use BeyondCode\Comments\Traits\HasComments;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompensationEvent extends BaseModel
{
    use HasComments, HasFactory, HasStatus, SoftDeletes;

    /** @var string activity icon */
    public static $activity_icon = '<i class="mdi mdi-scale-balance"></i>';

    protected $fillable = [
        'programme_id',
        'title',
        'description',
        'early_warning_notified',
        'early_warning_id',
        'status',
        'created_by',
    ];

    /**
     * Author relation
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(Profile::class, 'created_by');
    }

    /**
     * Contract relation
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contract()
    {
        return $this->programme->contract();
    }

    /**
     * Early Warning relation
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function early_warning()
    {
        return $this->belongsTo(EarlyWarning::class);
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
}
