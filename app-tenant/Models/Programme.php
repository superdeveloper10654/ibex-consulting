<?php

namespace AppTenant\Models;

use AppTenant\Models\Trait\HasStatus;
use BeyondCode\Comments\Traits\HasComments;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Programme extends BaseModel
{
    use HasComments, HasFactory, HasStatus, SoftDeletes;
    
     protected $fillable = [
        'accepted_at',
        'contract_id',
        'created_by',
        'name',
        'sharing_identifier',
        'status',
    ];

    protected $casts = [
        'accepted_at'   => 'datetime',
    ];

    /**
     * Contract relation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    /**
     * Author relation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(Profile::class, 'created_by');
    }

    /**
     * Author relation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author_profile()
    {
        return $this->belongsTo(Profile::class, 'created_by');
    }

    /**
     * Get programme by specific contractor profile id
     * 
     * @param Builder $q
     * @param int|string $contractor_id
     * @return  
     */
    public function scopeWhereСontractor(Builder $q, $profile_id_or_operator, $maybe_profile_id = null)
    {
        if (!$maybe_profile_id) {
            $maybe_profile_id = $profile_id_or_operator;
            $profile_id_or_operator = '=';
        }

        $q->whereHas('contract', function(Builder $q) use($profile_id_or_operator, $maybe_profile_id) {
            $q->whereHas('contractor_profile', function(Builder $q) use($profile_id_or_operator, $maybe_profile_id) {
                $q->where('id', $profile_id_or_operator, $maybe_profile_id);
            });
        });
    }

    /**
     * Get programme by specific subcontractor profile id
     * 
     * @param Builder $q
     * @param int|string $contractor_id
     * @return  
     */
    public function scopeWhereSubcontractor(Builder $q, $profile_id_or_operator, $maybe_profile_id = null)
    {
        if (!$maybe_profile_id) {
            $maybe_profile_id = $profile_id_or_operator;
            $profile_id_or_operator = '=';
        }

        $q->whereHas('contract', function(Builder $q) use($profile_id_or_operator, $maybe_profile_id) {
            $q->whereHas('subcontractor_profile', function(Builder $q) use($profile_id_or_operator, $maybe_profile_id) {
                $q->where('id', $profile_id_or_operator, $maybe_profile_id);
            });
        });
    }
}
