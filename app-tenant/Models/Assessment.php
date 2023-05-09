<?php

namespace AppTenant\Models;

use AppTenant\Models\Status\AssessmentStatus;
use AppTenant\Models\Trait\HasStatus;
use BeyondCode\Comments\Traits\HasComments;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assessment extends BaseModel
{
    use HasFactory, HasComments, HasStatus, SoftDeletes;

    /** @var string activity icon */
    public static $activity_icon = '<i class="mdi mdi-bank"></i>';

    protected $fillable = [
        'contract_id',
        'application_id',
        'profile_id',
        'title',
        'description',
        'items',
        'net',
        'period_from',
        'period_to',
        'status',
        'certified_by',
        'certified_at',
    ];

    protected $casts = [
        'items'         => 'array',
        'certified_at'  => 'datetime',
        'period_from'   => 'datetime',
        'period_to'     => 'datetime',
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
     * Profile from which assessment was certified relation
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function certified_by()
    {
        return $this->belongsTo(Profile::class, 'certified_by');
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
     * Quotation relation
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function quotation()
    {
        return $this->hasOne(Quotation::class);
    }

    /**
     * Change status to Certified
     * @param integer $certified_by
     */
    public function certify($certified_by)
    {
        $this->certified_by = $certified_by;
        $this->certified_at = date('Y-m-d H:i:s');
        $this->status = AssessmentStatus::CERTIFIED_ID;

        return $this->update();
    }

    /**
     * Formats items array
     * 
     * @param string $values
     * 
     * @return array<object>
     */
    public function getItemsAttribute($values)
    {
        $values = json_decode($values);

        foreach ($values as $i => $value) {
            $values[$i]->rate_card = isset($value->rate_card_id) ? RateCard::find($value->rate_card_id) : '';
        }

        return $values;
    }

    /**
     * cert_date param
     * 
     * @return string
     */
    public function getCertDateAttribute()
    {
        return date('Y-m-d H:i:s', strtotime("+14 days", strtotime($this->created_at)));
    }

    /**
     * due_date param
     * 
     * @return string
     */
    public function getDueDateAttribute()
    {
        return date('Y-m-d H:i:s', strtotime("+14 days", strtotime($this->created_at)));
    }
}