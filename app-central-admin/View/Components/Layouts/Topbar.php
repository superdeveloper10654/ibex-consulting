<?php

namespace App\View\Components\Layouts;

use Illuminate\View\Component;

class Topbar extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {       
       
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return ca_view('components.layouts.topbar');
    }
}
