<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @deprated
 * @todo: remove
 */
class Upload extends BaseModel
{
    use HasFactory, SoftDeletes;

    public static $activity_icon = '<i class="mdi mdi-paperclip"></i>';

    protected $fillable = [
        'file_name',
        'path',
        'extension',
        'profile_id', 
        'instruction_id',
        'early_warning_id', 
        'application_id',
        'assessment_id',
    ];

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
     * Instruction relation
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function instruction()
    {
        return $this->belongsTo(Instruction::class);
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
     * Application relation
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    /**
     * Assessment relation
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }
}
