<?php

namespace AppTenant\View\Components\Layouts;

use AppTenant\Models\Activity;
use AppTenant\Models\Notification;
use Illuminate\View\Component;

class Topbar extends Component
{
    /** @var array<Notification> */
    public $notifications;

    /** @var int */
    public $activities_count = 0;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {       
        if (tenant()) {
            $notifications = Notification::with('profile')
                                ->leftJoin('profiles_notified', 'profiles_notified.notification_id', '=', 'notifications.id')
                                ->select([
                                    '*',
                                    'profiles_notified.profile_id as notified_profile_id',
                                    'notifications.profile_id as profile_id',
                                    'notifications.created_at as created_at'
                                ])
                                ->whereNull('profiles_notified.notification_id')
                                ->where(function($q) {
                                    if (!t_profile()->isSuperAdmin() && !t_profile()->isAdmin()) {
                                        $q->whereNull('allowed_roles')
                                            ->orWhereJsonContains('allowed_roles', t_profile()->role);
                                    }
                                })
                                ->where(function($q) {
                                    if (!t_profile()->isSuperAdmin() && !t_profile()->isAdmin()) {
                                        $q->whereNull('allowed_department')
                                            ->orWhere('allowed_department', t_profile()->department);
                                    }
                                })
                                ->orderBy('id', 'DESC')
                                ->get();

            $this->notifications = $notifications;
            $this->activities_count = Activity::visibleForCurrentUser()->count();
        } else {
            $this->notifications = collect();
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return  t_view('components.layouts.topbar');
    }
}
