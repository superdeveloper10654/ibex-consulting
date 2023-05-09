<?php

namespace AppTenant\Models;

use BeyondCode\Comments\Traits\HasComments;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiskManagement extends BaseModel
{
    use HasFactory, HasComments, SoftDeletes;

    /** @var string activity icon */
    public static $activity_icon = '<i class="mdi mdi-alert-outline text-danger"></i>';
    protected static $permission_prefix = 'risk-management';
    protected static $route_prefix = 'risk-management';

    protected $table = 'riskmanagement';
    protected $fillable = [
        'probability',
        'risk_type',
        'from',
        'to',
        'score',
        'impact',
        'color',
        'severity',
        'profile_id',
        'contract_id',
    ];

    /**
     * Author relation
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }

    /**
     * Temporary
     * @todo: implement statuses
     */
    public function isDraft()
    {
        return false;
    }
}
