<?php

namespace App\View\Components\Site\Layout\Sections\Products\Cart;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Card;
use App\Helpers\Cart;

class CartMenu extends Component
{
    public function __construct(
        public $carts = [],
        public $total = [],
        public $count = [],
    ){
        $this->carts = Cart::all();
        $this->total = Cart::subtotal();
        $this->count = Cart::count();
    }

    public function render(): View | Closure | string
    {
        return view('components.site.layout.sections.products.cart.cart-menu');

    }//end of render

}//end of class