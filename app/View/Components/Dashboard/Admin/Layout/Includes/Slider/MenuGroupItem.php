<?php

namespace App\View\Components\Dashboard\Admin\Layout\Includes\Slider;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MenuGroupItem extends Component
{
    public function __construct(
        public $show       = '',
        public $trans      = '',
        public $route      = '',
        public $svg        = '',
        public $font       = '',
        public $permission = '',
    ) {}

    public function render(): View | Closure | string
    {
        return view('components.dashboard.admin.layout.includes.slider.menu-group-item');

    }//end of render

}//end of Component