<?php

namespace AppTenant\Models;

use AppTenant\Models\Status\QuotationStatus;
use BeyondCode\Comments\Traits\HasComments;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends BaseModel
{
    use HasComments, HasFactory, SoftDeletes;

    /** @var string activity icon */
    public static $activity_icon = '<i class="mdi mdi-bank"></i>';

    protected $fillable = [
        'contract_type',
        'order_ref',
        'contract_name',
        'kml_filepath',
        'latitude',
        'longitude',
        'created_by',
        'profile_id',
        'subcontractor_profile_id',
    ];

    /**
     * Profile relation (Contractor)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contractor_profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }

    /**
     * Profile relation (Subcontractor)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subcontractor_profile()
    {
        return $this->belongsTo(Profile::class, 'subcontractor_profile_id');
    }

    /**
     * Measures relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function measures()
    {
        return $this->hasMany(Measure::class, 'contract_id');
    }

    public function img_url()
    {
        return asset('/assets/images/companies/img-5.png');
    }
    public function applicationOne()
    {
        return $this->hasOne('AppTenant\Models\ContractApplication');
    }
    public function applicationTwo()
    {
        return $this->hasOne('AppTenant\Models\PartTwoContractData');
    }
    public function boqSchedules()
    {
        return $this->hasMany(BoqSchedule::class);
    }
    public function activitySchedules()
    {
        return $this->hasMany(ActivitySchedule::class);
    }
    public function priceLists()
    {
        return $this->hasMany(PriceList::class);
    }

    public function exceptReplyPeriods()
    {
        return $this->hasMany(ExceptReplyPeriod::class);
    }

    public function additionalEmployerRisks()
    {
        return $this->hasMany(AdditionalEmployerRisk::class);
    }

    public function insurances()
    {
        return $this->hasMany(ContractInsurance::class);
    }

    public function contractWorkConditions()
    {
        return $this->hasMany(ContractWorkCondition::class);
    }

    public function contractAccessDates()
    {
        return $this->hasMany(ContractAccessDate::class);
    }

    public function contractDefectCorrectionExceptPeriod()
    {
        return $this->hasMany(ContractDefectCorrectionExceptPeriod::class);
    }

    public function contractPriceAdjustmentFactors()
    {
        return $this->hasMany(ContractPriceAdjustmentFactor::class);
    }

    public function contractPayItemActivities()
    {
        return $this->hasMany(ContractPayItemActivity::class);
    }

    public function contractWorkSectionCompletionDates()
    {
        return $this->hasMany(ContractWorkSectionCompletionDate::class);
    }

    public function contractWorkSectionBonuses()
    {
        return $this->hasMany(ContractWorkSectionBonus::class);
    }

    public function contractWorkSectionDelayDamages()
    {
        return $this->hasMany(ContractWorkSectionDelayDamage::class);
    }

    public function contractUndertakingToOthers()
    {
        return $this->hasMany(ContractUndertakingToOthers::class);
    }

    public function contractUndertakingToClients()
    {
        return $this->hasMany(ContractUndertakingToClient::class);
    }

    public function subcontractorUndertakingToOthers()
    {
        return $this->hasMany(SubcontractorUndertakingToOthers::class);
    }

    public function contractLowPerformanceDamageAmounts()
    {
        return $this->hasMany(ContractLowPerformanceDamageAmount::class);
    }

    public function contractExtensionPeriods()
    {
        return $this->hasMany(ContractExtensionPeriod::class);
    }

    public function contractExtensionCriteria()
    {
        return $this->hasMany(ContractExtensionCriteria::class);
    }

    public function contractAccountingPeriods()
    {
        return $this->hasMany(ContractAccountingPeriod::class);
    }

    public function contractBenificiaryTerms()
    {
        return $this->hasMany(ContractBenificiaryTerm::class);
    }

    public function NEC4Contract()
    {
        return $this->hasOne(NEC4Contract::class);
    }

    public function seniorRepresentatives()
    {
        return $this->belongsToMany(Profile::class, 'contract_senior_representatives', 'contract_id', 'profile_id')->withTimestamps();
    }

    public function partTwoSeniorRepresentatives()
    {
        return $this->belongsToMany(Profile::class, 'contract_part_two_senior_representatives', 'contract_id', 'profile_id')->withTimestamps();
    }

    public function contractKeyPeoples()
    {
        return $this->hasMany(ContractKeyPeople::class);
    }

    public function partTwoNEC4Contract()
    {
        return $this->hasOne(PartTwoNec4ContractData::class);
    }

    public function contractSizeBaseEquipments()
    {
        return $this->hasMany(ContractSizeBaseEquipment::class);
    }

    public function contractTimeBaseEquipments()
    {
        return $this->hasMany(ContractTimeBaseEquipment::class);
    }

    public function contractDefinedCosts()
    {
        return $this->hasMany(ContractDefinedCost::class);
    }


    public function contractSharedServiceDefinedCosts()
    {
        return $this->hasMany(ContractSharedServiceDefinedCost::class);
    }
    /**
     * Early Warning relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function quotations()
    {
        return $this->hasManyThrough(Quotation::class, Programme::class)->notDrafted();
    }

    /**
     * Placeholder for PM
     * 
     * @return object|false
     */
    public function project_manager()
    {
        if (!isPaidSubscription()) {
            return (object) [
                'name'  => 'Peter Manning',
            ];
        }

        return false;
    }

    /**
     * Placeholder for Supervisor
     * 
     * @return object|false
     */
    public function supervisor()
    {
        if (!isPaidSubscription()) {
            return (object) [
                'name'  => 'Steve Slater',
            ];
        }

        return false;
    }


    /**
     * Show contract date with effects (eg. Quotations date effects)
     * @return Carbon
     */
    public function getCompletionDateActualAttribute()
    {
        if (!isset($cached_attrs['dates_actual']['completion'])) {
            $cached_attrs['dates_actual'] = $this->getDatesActual();
        }

        return $cached_attrs['dates_actual']['completion_date'];
    }

    /**
     * Show contract key date 1 with effects (eg. Quotations date effects)
     * @return Carbon
     */
    public function getKeyDate1ActualAttribute()
    {
        if (!isset($cached_attrs['dates_actual']['key_date_1'])) {
            $cached_attrs['dates_actual'] = $this->getDatesActual();
        }

        return $cached_attrs['dates_actual']['key_date_1'];
    }

    /**
     * Show contract key date 2 with effects (eg. Quotations date effects)
     * @return Carbon
     */
    public function getKeyDate2ActualAttribute()
    {
        if (!isset($cached_attrs['dates_actual']['key_date_3'])) {
            $cached_attrs['dates_actual'] = $this->getDatesActual();
        }

        return $cached_attrs['dates_actual']['key_date_3'];
    }

    /**
     * Show contract key date 3 with effects (eg. Quotations date effects)
     * @return Carbon
     */
    public function getKeyDate3ActualAttribute()
    {
        if (!isset($cached_attrs['dates_actual']['key_date_3'])) {
            $cached_attrs['dates_actual'] = $this->getDatesActual();
        }

        return $cached_attrs['dates_actual']['key_date_3'];
    }

    /**
     * Get array of contract dates with all the changes/effects accepted (eg. Quotations)
     *
     * @return array
     */
    protected function getDatesActual()
    {
        if (!$this->applicationOne) {
            return null;
        }

        $res = [
            'completion_date'   => $this->applicationOne->completion_date,
            'key_date_1'        => $this->applicationOne->key_date_1,
            'key_date_2'        => $this->applicationOne->key_date_2,
            'key_date_3'        => $this->applicationOne->key_date_3,
        ];

        $quotations = $this->quotations->where('status', QuotationStatus::ACCEPTED_ID);

        if (empty($quotations)) {
            return $res;
        }

        $effects = [
            'completion_date'   => 0,
            'key_date_1'        => 0,
            'key_date_2'        => 0,
            'key_date_3'        => 0,
        ];

        foreach ($quotations as $quotation) {
            $effects['completion_date'] += $quotation->contract_completion_date_effect;
            $effects['key_date_1'] += $quotation->contract_key_date_1_effect;
            $effects['key_date_2'] += $quotation->contract_key_date_2_effect;
            $effects['key_date_3'] += $quotation->contract_key_date_3_effect;
        }

        foreach ($res as $key => $date) {
            if (!empty($date)) {
                $date = new Carbon($date);
                $effects[$key] > 0 ? $date->addDays($effects[$key]) : $date->subDays($effects[$key]);
                $res[$key] = $date;
            }
        }

        return $res;
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
