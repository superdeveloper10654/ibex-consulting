<?php

namespace AppTenant\Models\Statical;

use AppTenant\Models\Status\BaseStatus;
use Illuminate\Support\Str;
use ReflectionClass;

/**
 * Here specified default media collections used for uploads. Every media collection considered as folder in Files Manager
 * Collection should have the same name as model
 */
class MediaCollection extends BaseStatus
{
  
    /** @var string root folder collection */
    const COLLECTION_ROOT = 'root';

    /** @var string compensation events collection */
    const COLLECTION_COMPENSATION_EVENTS = 'CompensationEvent';

    /** @var string contracts collection */
    const COLLECTION_CONTRACTS = 'Contract';

    /** @var string instructions collection */
    const COLLECTION_INSTRUCTIONS = 'Instruction';

    /** @var string measures collection */
    const COLLECTION_MEASURES = 'Measure';

    /** @var string mitigations collection */
    const COLLECTION_MITIGATIONS = 'Mitigation';

    /** @var string early warnings collection */
    const COLLECTION_EARLY_WARNINGS = 'EarlyWarning';

    /** @var string payments collection */
    const COLLECTION_PAYMENTS = 'Payment';

    /** @var string programmes collection */
    const COLLECTION_PROGRAMMES = 'Programme';

    /** @var string quotations collection */
    const COLLECTION_QUOTATIONS = 'Quotation';

    /** @var string risk management collection. Note: files for this collection identified using contract id */
    const COLLECTION_RISK_MANAGEMENT = 'RiskManagement';

    /** @var string applications collection */
    const COLLECTION_APPLICATIONS = 'Application';

    /** @var string assessments collection */
    const COLLECTION_ASSESSMENTS = 'Assessment';
    
    /** @var string Daily Work Records */
    const COLLECTION_DAILY_WORK_RECORD = 'DailyWorkRecord';
    /**
     * Return collections names
     * 
     * @return array<string>
     */
    public static function getAll()
    {
        $ref_class = new ReflectionClass(static::class);
        $constants = $ref_class->getConstants();
        $res = [];

        foreach ($constants as $key => $constant) {
            if (Str::startsWith($key, 'COLLECTION_')) {
                $res[] = $constant;
            }
        }

        return $res;
    }
}