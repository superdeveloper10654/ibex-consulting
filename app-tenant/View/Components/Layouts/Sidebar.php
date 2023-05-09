<?php

namespace AppTenant\View\Components\Layouts;

use AppTenant\Models\Activity;
use AppTenant\Models\Contract;
use Illuminate\View\Component;

class Sidebar extends Component
{
    /** @var array<Activity> */
    public $has_contracts;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->has_contracts = !empty(Contract::first());
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return  t_view('components.layouts.sidebar');
    }
}
