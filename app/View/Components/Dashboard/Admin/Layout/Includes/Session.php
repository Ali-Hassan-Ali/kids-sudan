<?php

namespace App\View\Components\Dashboard\Admin\Layout\Includes;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Session extends Component
{
    public function __construct() {}

    public function render(): View | Closure | string
    {
        return view('components.dashboard.admin.layout.includes.session');

    }//end of render

}//end of Component