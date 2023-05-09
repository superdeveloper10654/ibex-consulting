<?php

namespace AppTenant\Models;

use AppTenant\Models\Status\InstructionStatus;
use AppTenant\Models\Trait\HasStatus;
use BeyondCode\Comments\Traits\HasComments;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Instruction extends BaseModel
{
    use HasFactory, HasComments, HasStatus, SoftDeletes;

    /** @var string activity icon */
    public static $activity_icon = '<i class="bx bx-pen text-muted"></i>';

    protected $fillable = [
        'contract_id',
        'profile_id',
        'title',
        'description', 
        'location',
        'longitude', 
        'latitude',
        'start', 
        'finish',
        'duration', 
        'pattern',
        'status',
    ];

    protected $casts = [
        'start'     => 'datetime',
        'finish'    => 'datetime',
    ];

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
     * Quotation relation
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function quotation()
    {
        return $this->hasOne(Quotation::class);
    }
}
