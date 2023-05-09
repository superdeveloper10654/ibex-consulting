<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quote extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'contract_id',
        'profile_id',
        'title',
        'narrative', 
        'location',
        'latitude', 
        'longitude',
        'start', 
        'finish',
        'duration', 
        'pattern',
        'contractor',
        'status'
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
}
