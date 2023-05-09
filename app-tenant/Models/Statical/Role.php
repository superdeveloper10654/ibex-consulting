<?php

namespace AppTenant\Models\Statical;

use AppTenant\Models\Status\BaseStatus;

class Role extends BaseStatus
{
    /** @var string SuperAdmin status string */
    const SUPER_ADMIN = 'SuperAdmin';

    /** @var int SuperAdmin status id */
    const SUPER_ADMIN_ID = 1;


    /** @var string Admin status string */
    const ADMIN = 'Admin';

    /** @var int Admin status id */
    const ADMIN_ID = 2;


    /** @var string Project Manager status string */
    const PROJECT_MANAGER = 'Project Manager';

    /** @var int Project Manager status id */
    const PROJECT_MANAGER_ID = 3;


    /** @var string Contractor status string */
    const CONTRACTOR = 'Contractor';

    /** @var int Contractor status id */
    const CONTRACTOR_ID = 4;


    /** @var string Supervisor status string */
    const SUPERVISOR = 'Supervisor';

    /** @var int Supervisor status id */
    const SUPERVISOR_ID = 5;


    /** @var string Service Manager status string */
    const SERVICE_MANAGER = 'Service Manager';

    /** @var int Service Manager status id */
    const SERVICE_MANAGER_ID = 6;


    /** @var int Adjudicator status string */
    const ADJUDICATOR = 'Adjudicator';

    /** @var int Adjudicator status id */
    const ADJUDICATOR_ID = 7;


    /** @var int Senior Representative status id */
    const SENIOR_REPRESENTATIVE = 'Senior Representative';

    /** @var int Senior Representative status id */
    const SENIOR_REPRESENTATIVE_ID = 8;


    /** @var string Subcontractor status string */
    const SUBCONTRACTOR = 'Subcontractor';

    /** @var int Subcontractor status id */
    const SUBCONTRACTOR_ID = 9;

    /**
     * Get roles only available for admin users
     * 
     * @return array of roles [key => name]
     */
    public static function getForAdminUsers()
    {
        return [
            static::CONTRACTOR_ID               => static::CONTRACTOR,
            static::SUBCONTRACTOR_ID            => static::SUBCONTRACTOR,
            static::PROJECT_MANAGER_ID          => static::PROJECT_MANAGER,
            static::SUPERVISOR_ID               => static::SUPERVISOR,
            static::SERVICE_MANAGER_ID          => static::SERVICE_MANAGER,
            static::ADJUDICATOR_ID              => static::ADJUDICATOR,
            static::SENIOR_REPRESENTATIVE_ID    => static::SENIOR_REPRESENTATIVE,
        ];
    }

    /**
     * Get roles from Client/Employer side
     * 
     * @return array of roles [key => name]
     */
    public static function getClientRoles()
    {
        return [
            static::ADMIN_ID            => static::ADMIN,
            static::PROJECT_MANAGER_ID  => static::PROJECT_MANAGER,
            static::SUPERVISOR_ID       => static::SUPERVISOR,
            static::SERVICE_MANAGER_ID  => static::SERVICE_MANAGER,
            // static::ADJUDICATOR_ID  => static::ADJUDICATOR,
            // static::SENIOR_REPRESENTATIVE_ID  => static::SENIOR_REPRESENTATIVE,
        ];
    }

    /**
     * Get role ids from Client/Employer side
     * 
     * @return array of roles [key => name]
     */
    public static function getClientRoleIds()
    {
        return array_keys(static::getClientRoles());
    }

    /**
     * Get roles from Contractor side
     * 
     * @return array of roles [key => name]
     */
    public static function getContractorRoles()
    {
        return [
            static::CONTRACTOR_ID       => static::CONTRACTOR,
            static::SUBCONTRACTOR_ID    => static::SUBCONTRACTOR
        ];
    }

    /**
     * Get role ids from Contractor side
     * 
     * @return array of roles [key => name]
     */
    public static function getContractorRoleIds()
    {
        return array_keys(static::getContractorRoles());
    }
}
