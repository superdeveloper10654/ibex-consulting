<?php

namespace AppTenant\View\Components\Layouts;

use AppTenant\Models\Activity;
use Illuminate\View\Component;

class RightSidebar extends Component
{
    /** @var array<Activity> */
    public $activities;

    /** @var boolean has more activities to load */
    public $has_more_activities;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $activities_count = 25;

        if (tenant()) {
            $this->activities = Activity::with('profile')
                                ->visibleForCurrentUser()
                                ->latest()
                                ->take($activities_count)
                                ->get();

            $this->has_more_activities = $this->activities->count() == $activities_count;
        } else {
            $this->activities = collect();
            $this->has_more_activities = false;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return t_view('components.layouts.right-sidebar');
    }
}
