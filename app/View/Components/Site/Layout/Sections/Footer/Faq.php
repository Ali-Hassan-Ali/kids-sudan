<?php

namespace App\View\Components\Site\Layout\Sections\Footer;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Faq extends Component
{
    public function __construct(
        public $faqs = [],
    ){
        $this->faqs = json_decode(getSetting('faq'), true)['title'];
    }

    public function render(): View | Closure | string
    {
        return view('components.site.layout.sections.footer.faq');

    }//end of render

}//end of class