<?php

namespace AppTenant\Models;

use AppTenant\Models\Trait\HasStatus;
use BeyondCode\Comments\Traits\HasComments;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quotation extends BaseModel
{
    use HasFactory, HasComments, HasStatus, SoftDeletes;

    /** @var string activity icon */
    public static $activity_icon = '<i class="mdi mdi-comment-quote-outline"></i>';

    protected $fillable = [
        'title',
        'description',
        'programme_id',
        'assessment_id',
        'instruction_id',
        'contract_completion_date_effect',
        'contract_key_date_1_effect',
        'contract_key_date_2_effect',
        'contract_key_date_3_effect',
        'price_effect',
        'status',
        'created_by',
    ];

    /**
     * Assessment relation
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function assessment()
    {
        return $this->hasOne(Assessment::class);
    }

    /**
     * Created by relation
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
     * Instruction relation
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function instruction()
    {
        return $this->hasOne(Instruction::class);
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
