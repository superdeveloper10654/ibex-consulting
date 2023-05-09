<?php

namespace AppTenant\Models;

use AppTenant\Models\Trait\HasStatus;
use BeyondCode\Comments\Traits\HasComments;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mitigation extends BaseModel
{
    use HasFactory, HasComments, HasStatus, SoftDeletes;

    /** @var string activity icon */
    public static $activity_icon = '<i class="mdi mdi-minus-circle-outline"></i>';

    protected $fillable = [
        'name',
        'description',
        'status',
        'early_warning_id',
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
     * Early Warning relation
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function early_warning()
    {
        return $this->belongsTo(EarlyWarning::class);
    }
}
