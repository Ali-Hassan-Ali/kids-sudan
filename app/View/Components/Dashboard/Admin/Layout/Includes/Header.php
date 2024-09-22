<?php

namespace App\View\Components\Dashboard\Admin\Layout\Includes;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Header extends Component
{
    public function __construct() {}

    public function render(): View | Closure | string
    {
        return view('components.dashboard.admin.layout.includes.header');

    }//end of render

}//end of Component