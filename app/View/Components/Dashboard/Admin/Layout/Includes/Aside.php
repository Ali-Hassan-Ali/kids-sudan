<?php

namespace App\View\Components\Dashboard\Admin\Layout\Includes;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Aside extends Component
{
    public function __construct() {}

    public function render(): View | Closure | string
    {
        return view('components.dashboard.admin.layout.includes.aside');

    }//end of render

}//end of Component