<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyWorkRecord extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'daily_work_records';

    protected $fillable = [
        'contract_id',
        'client_profile_id',
        'reference_no',
        'crew_name',
        'date',
        'site_name',
        'supervisor_profile_id',
        'foreman',
        'contract_id'
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
     * Client profile relation
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client_profile()
    {
        return $this->belongsTo(Profile::class, 'client_profile_id', 'id');
    }

    /**
     * Supervisor profile relation
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supervisor_profile()
    {
        return $this->belongsTo(Profile::class, 'supervisor_profile_id', 'id');
    }
}
