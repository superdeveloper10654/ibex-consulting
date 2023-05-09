<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'contract_id',
        'profile_id',
        'title',
        'measured_items', 
        'deducted_items',
        'description', 
        'net',
        'period_from', 
        'period_to',
        'status',
    ];

    protected $casts = [
        'measured_items'    => 'array',
        'deducted_items'    => 'array',
        'period_from'       => 'datetime',
        'period_to'         => 'datetime',
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
