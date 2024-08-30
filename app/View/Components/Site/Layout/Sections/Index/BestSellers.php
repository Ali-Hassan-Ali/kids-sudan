<?php

namespace App\View\Components\Site\Layout\Sections\Index;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Card;

class BestSellers extends Component
{
    public function __construct(
        public $cards = [],
    ){
        $this->cards = Card::all();

    }//end of fun

    public function render(): View | Closure | string
    {
        return view('components.site.layout.sections.index.best-sellers');

    }//end of render

}//end of class