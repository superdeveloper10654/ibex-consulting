<?php

namespace AppTenant\Services;

use AppTenant\Models\Statical\Department;
use AppTenant\Models\Statical\Role;
use Exception;

/**
 * Service containing system permissions.
 * Use Spatie Permissions for checking/middleware + standard role field in database profiles table.
 * 
 * To use new permission add it to array '$all'.
 * 
 * Links:
 *  - https://spatie.be/docs/laravel-permission/v5/introduction
 * 
 * Requirements:
 *  permission prefix for resource (for example compensation-events) should be the same as:
 *   - route prefix (eg. t_route('compensation-events.create'));
 *   - snake-cased model name related to the resource in the singular (CompensationEvent);
 */
class Permission
{
    /** @var string Permission for all actions */
    const PERMISSION_ALL = 'all';

    /** @var array all of all the permissions in system
     * Example for common CRUD: [
     *  'operations.create',
     *  'operations.read',
     *  'operations.update',
     *  'operations.delete',
     * ]
    */
    protected static $all = [
        'applications.create',
        'applications.read',
        'applications.update',
        'applications.update-status',

        'assessments.create',
        'assessments.read',
        'assessments.update',
        'assessments.update-status',

        'compensation-events.create',
        'compensation-events.read',
        'compensation-events.update',
        'compensation-events.delete',

        'compensation-events-notification.read',
        'compensation-events-notification.create',

        'contracts.read',
        'contracts.create',
        'contracts.update',

        'dashboard.browse',

        'early-warnings.read',
        'early-warnings.create',
        'early-warnings.update',
        'early-warnings.delete',
        'early-warnings.close',
        'early-warnings.escalate',
        'early-warnings.notify',

        'instructions.create',
        'instructions.read',
        'instructions.update',

        'manage-billing',

        'measures.create',
        'measures.read',
        'measures.update',
        'measures.delete',
        'measures.ajax',

        'mitigations.create',
        'mitigations.read',
        'mitigations.update',
        'mitigations.delete',

        'notification-settings.browse',
        'notification-settings.store',
        'notification-settings.ajax',
        'notification-settings.edit',
        'notification-settings.update',

        'measures.delete',

        'operations.create',
        'operations.read',
        'operations.update',
        'operations.delete',

        'programmes.read',
        'programmes.create',
        'programmes.update',
        'programmes.delete',
        'programmes.accept-reject',

        'risk-management.read',
        'risk-management.create',
        'risk-management.update',
        'risk-management.delete',

        'payments.read',
        'payments.create',
        'payments.update',
        'payment-certificates.browse',

        'profiles.read',
        'profiles.create',
        'profiles.update',
        'profiles.delete',

        'quality-and-defects.browse', // Quality Control

        'quotations.create',
        'quotations.read',
        'quotations.update',
        'quotations.delete',
        'quotations.accept-reject',

        'rate-cards.ajax',
        'rate-cards.create',
        'rate-cards.read',
        'rate-cards.update',
        'rate-cards.delete',

        'rate-card-pins.read',
        'rate-card-pins.create',
        'rate-card-pins.update',
        'rate-card-pins.delete',

        'resources.create',
        'resources.read',
        'resources.update',
        'resources.delete',

        'settings-manage',

        'snags-and-defects.browse',
        'snags-and-defects.add-comment',

        'tests-and-inspections.browse',
        'tests-and-inspections.add-comment',

        'uploads.browse',
        'uploads.files-ajax',
        'uploads.file-rename',
        'uploads.store',
        'uploads.create-folder',
        'uploads.remove-folder',
        'uploads.rename-folder',
        'uploads.remove',
        'uploads.download',

        'users.read',
        'users.create',
        'users.update',
        'users.delete',

        'work-records.browse',
        'work-records.create',
        'work-records.store',
        'work-records.show', // added by RB 30.06.22
        'work-records.edit',
        'work-records.update',

        'workflow.browse',
        'workflow.create',
        'workflow.edit',
        'workflow.store',
        'workflow.show',
        'workflow.delete',

        // system management routes
    ];

    /**
     * List of conditions. In case if one permission listed in 'permissions' of multiple elements - prioterized element should be listed on top.
     * If need to apply multiple conditions (one of the condition should be true) - add new element to conditions (element of access_for array).
     */
    protected static $list = [
        // Super admin
        [
            'access_for'    => [
                [
                    'role'          => Role::SUPER_ADMIN_ID,
                ]
            ],
            'permissions'   => self::PERMISSION_ALL,
        ],

        // Admin
        [
            'access_for'    => [
                [
                    'role'          => Role::ADMIN_ID,
                ]
            ],
            'permissions'   => [
                'applications.create',
                'applications.read',
                'applications.update',
                'applications.update-status',

                'assessments.create',
                'assessments.read',
                'assessments.update',
                'assessments.update-status',
                
                'programmes.read',
                'programmes.create',
                'programmes.update',
                'programmes.delete',
                'programmes.accept-reject',

                'compensation-events.create',
                'compensation-events.read',
                'compensation-events.update',
                'compensation-events.delete',

                'compensation-events-notification.read',
                'compensation-events-notification.create',


                'contracts.read',
                'contracts.create',
                'contracts.update',

                'early-warnings.create',
                'early-warnings.read',
                'early-warnings.update',
                'early-warnings.delete',
                'early-warnings.close',
                'early-warnings.escalate',
                'early-warnings.notify',

                'instructions.create',
                'instructions.read',
                'instructions.update',

                'manage-billing',

                'measures.create',
                'measures.read',
                'measures.update',
                'measures.delete',
                'measures.ajax',

                'mitigations.create',
                'mitigations.read',
                'mitigations.update',
                'mitigations.delete',

                'operations.create',
                'operations.read',
                'operations.update',
                'operations.delete',

                'risk-management.read',
                'risk-management.create',
                'risk-management.update',
                'risk-management.delete',

                'payments.read',
                'payments.create',
                'payments.read',
                'payments.update',

                'profiles.read',
                'profiles.create',
                'profiles.read',
                'profiles.update',
                'profiles.delete',

                'quotations.create',
                'quotations.read',
                'quotations.update',
                'quotations.delete',
                'quotations.accept-reject',

                'rate-cards.ajax',
                'rate-cards.create',
                'rate-cards.read',
                'rate-cards.update',
                'rate-cards.delete',

                'rate-card-pins.read',
                'rate-card-pins.create',
                'rate-card-pins.update',
                'rate-card-pins.delete',

                'resources.create',
                'resources.read',
                'resources.update',
                'resources.delete',

                'settings-manage',

                'uploads.browse',
                'uploads.files-ajax',
                'uploads.file-rename',
                'uploads.store',
                'uploads.create-folder',
                'uploads.remove-folder',
                'uploads.rename-folder',
                'uploads.remove',
                'uploads.download',

                'workflow.create',
                'workflow.edit',
                'workflow.store',
                'workflow.delete',
                'workflow.show',

                'notification-settings.browse',
                'notification-settings.store',
                'notification-settings.ajax',
                'notification-settings.edit',
                'notification-settings.update',
            ]
        ],      
      
        // Admin, Contractor Commercial, Supervisor Operational
        [
            'access_for'    => [
                [
                    'role'          => Role::ADMIN_ID,
                ],
                [
                    'role'          => Role::SUPERVISOR_ID,
                    'department'    => Department::OPERATIONAL_ID,
                ],
                [
                    'role'          => Role::CONTRACTOR_ID,
                    'department'    => Department::COMMERCIAL_ID,
                ],
            ],
            'permissions'   => [
                'contracts.read',
                
                'programmes.read',

                'compensation-events.read',

                'dashboard.browse',

                'instructions.read',

                'measures.read',

                'operations.read',

                'payments.read',

                'profiles.read',

                'quality-and-defects.browse',

                'quotations.read',

                'rate-cards.read',

                'rate-card-pins.read',

                'snags-and-defects.browse',
                'snags-and-defects.add-comment',

                'tests-and-inspections.browse',
                'tests-and-inspections.add-comment',
                'risk-management.read',

                'uploads.browse',
                'uploads.files-ajax',
                'uploads.file-rename',
                'uploads.store',
                'uploads.create-folder',
                'uploads.rename-folder',
                'uploads.download',

                'workflow.browse',
                'workflow.show',
                
                'work-records.browse',
                'work-records.show',
            ]
        ],

        // Contractor Commercial Department
        [
            'access_for'    => [
                [
                    'role'          => Role::CONTRACTOR_ID,
                    'department'    => Department::COMMERCIAL_ID,
                ],
            ],
            'permissions'   => [
                'mitigations.create',
                'mitigations.read',
                'mitigations.update',
                'compensation-events-notification.read',
                'compensation-events-notification.create',

            ],
        ],

        // Supervisor
        [
            'access_for'    => [
                [
                    'role'          => Role::SUPERVISOR_ID,
                    'department'    => Department::OPERATIONAL_ID,
                ],
            ],
            'permissions'   => [
                'resources.read',
            ],
        ],

        // PM
        [
            'access_for'    => [
                [
                    'role'          => Role::PROJECT_MANAGER_ID,
                    'department'    => Department::COMMERCIAL_ID,
                ],
            ],
            'permissions'   => [
                'applications.read',
                'assessments.create',
                'assessments.read',
                'assessments.update',
                'assessments.update-status',
                
                'programmes.read',
                
                'compensation-events.read',
                'compensation-events-notification.read',
                
                'contracts.read',
                
                'dashboard.browse',
                
                'early-warnings.read',
                'early-warnings.create',
                'early-warnings.close',
                'early-warnings.escalate',
                'early-warnings.notify',
                
                'instructions.create',
                'instructions.read',
                'instructions.update',
                
                'measures.create',
                'measures.read',
                'measures.update',
                'measures.delete',
                'measures.ajax',
                
                'mitigations.create',
                'mitigations.read',
                'mitigations.update',
                'mitigations.delete',
                
                'notification-settings.browse',
                'notification-settings.store',
                'notification-settings.ajax',
                'notification-settings.edit',
                'notification-settings.update',
                
                'risk-management.read',
                'risk-management.create',
                'risk-management.update',
                'risk-management.delete',
                
                'payments.read',
                'payments.create',
                'payments.update',
                'payment-certificates.browse',
                
                'profiles.read',
                
                'quality-and-defects.browse', // Quality Control
                
                'quotations.read',
                'quotations.accept-reject',
                
                'rate-cards.read',
                
                'rate-card-pins.read',
                
                'resources.read',
                
                'settings-manage',
                
                'snags-and-defects.browse',
                'snags-and-defects.add-comment',
                
                'tests-and-inspections.browse',
                'tests-and-inspections.add-comment',
                
                'uploads.browse',
                'uploads.files-ajax',
                'uploads.store',
                'uploads.download',
                
                'users.read',
                
                'work-records.browse',
                'work-records.show',
                
                'workflow.browse',
                'workflow.show',
            ],
        ],

        // Supervisor Operational
        [
            'access_for'    => [
                [
                    'role'          => Role::SUPERVISOR_ID,
                    'department'    => Department::OPERATIONAL_ID,
                ],
            ],
            'permissions'   => [
                'early-warnings.read',

                'mitigations.read',
            ],
        ],

        // Contractor
        [
            'access_for'    => [
                [
                    'role'          => Role::CONTRACTOR_ID,
                ],
            ],
            'permissions'   => [
                'early-warnings.create',
                'early-warnings.read',
                'early-warnings.close',
                'early-warnings.escalate',
                'early-warnings.notify',
                'programmes.accept-reject',
                'resources.read',
                'resources.create',
                'resources.update',
            ],
        ],

        // Contractor Operational
        [
            'access_for'    => [
                [
                    'role'          => Role::CONTRACTOR_ID,
                    'department'    => Department::OPERATIONAL_ID,
                ],
            ],
            'permissions'   => [
                'programmes.read',
                'programmes.create',
                'programmes.update',

                'measures.create',
                'measures.read',
                'measures.update',
                'measures.ajax',

                'mitigations.create',
                'mitigations.read',

                'rate-cards.ajax',
                'rate-cards.create',
                'rate-cards.read',
                'rate-cards.update',

                'work-records.browse',
                'work-records.create',
                'work-records.store',
                'work-records.show',
                'work-records.edit',
                'work-records.update',
            ],
        ],

        // Contractor Commercial
        [
            'access_for'    => [
                [
                    'role'          => Role::CONTRACTOR_ID,
                    'department'    => Department::COMMERCIAL_ID,
                ],
            ],
            'permissions'   => [
                'applications.create',
                'applications.read',
                'applications.update',
                'applications.update-status',

                'assessments.read',

                'payment-certificates.browse',

                'quotations.create',
                'quotations.read',
                'quotations.update',
            ]
        ],
    ];

    /**
     * Check if the permission granted
     * 
     * @param string $permission for checking
     * @param AppTenant\Models\Profile $profile that cheking for granted permissions. Default - current user profile
     * 
     * @return bool
     * @throws \Exception
     */
    public static function granted($permission, $profile = null)
    {
        if (!in_array($permission, static::$all)) {
            throw new Exception("Permission not found: '$permission'");
        }

        $profile = $profile ? $profile : t_profile();

        if ($profile->role == Role::SUPER_ADMIN_ID) {
            return true;
        }

        // @todo: implement caching

        foreach (self::$list as $item) {
            if (!is_string($item['permissions']) && !in_array($permission, $item['permissions'])) {
                continue;
            }

            // check if user profile suits access_for
            $elems_passed = 0;

            foreach ($item['access_for'] as $cond_array) {
                $all_conds_passed = true;

                foreach ($cond_array as $cond_name => $cond_value) {
                    if ($profile->$cond_name != $cond_value) {
                        $all_conds_passed = false;
                    }
                }

                if ($all_conds_passed) {
                    $elems_passed++;
                }
            }

            if ($elems_passed >= 1) {
                return true;
            }
        }

        return false;
    }
}
