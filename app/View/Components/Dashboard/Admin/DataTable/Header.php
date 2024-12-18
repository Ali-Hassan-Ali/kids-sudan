<?php

namespace App\View\Components\Admin\DataTable;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use JetBrains\PhpStorm\NoReturn;

class Header extends Component
{
    public function __construct(
        public array $columns = [],
    ){}

    public function render(): View | Closure | string
    {
        return view('components.dashboard.admin.data-table.header');
        
   }//end of render

}//end of Component