<?php

namespace App\View\Components\Dashboard\Admin\Layout\Includes\Slider;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MenuItem extends Component
{
    public function __construct(
        public $active     = '',
        public $trans      = '',
        public $route      = '',
        public $svg        = '',
        public $font       = '',
        public $permission = '',
    ) {}

    public function render(): View | Closure | string
    {
        return view('components.dashboard.admin.layout.includes.slider.menu-item');
        
    }//end of render

}//end of Component