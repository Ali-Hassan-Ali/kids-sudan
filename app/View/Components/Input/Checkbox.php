<?php

namespace App\View\Components\Input;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Checkbox extends Component
{
    public function __construct(
        public $id       = '',
        public $col      = 'col-md',
        public $index    = '',
        public $name     = '',
        public $label    = '',
        public $value    = true,
        public $required = false,
        public $disabled = false,
        public $hidden   = false,
        public $readonly = false,
        public $invalid  = '',
        public $old      = '',
    ){
        $this->id      = $id ?? $this->convertToDotNotation($invalid, $name, $index);
        $this->invalid = $this->invalidCheck($invalid, $name, $index);
        $this->old     = $this->invalidCheck($invalid, $name, $index);
    }
    
    public function render(): View | Closure | string
    {
        return view('components.input.checkbox');

    }//end of render

    public function containsBrackets(string $string) 
    {
        return strpos($string, '[') !== false && strpos($string, ']') !== false;

    }//end of render

    public function invalidCheck(string $invalid, string $name, string | int | bool $index = false)
    {
        if ($this->containsBrackets($name)) {

            $name = str_replace(['[', ']'], ['.',''], $name) . $index;
            $name = rtrim($name, '.');
        } 

        return $name;

    }//end of fun

    public function convertToDotNotation(string $invalid, string $name, $index = false)
    {
        if ($this->containsBrackets($name)) {

            $name = str_replace(['[', ']'], ['-',''], $name) . $index;
            $name = rtrim($name, '-');
        } 

        return $name;

    }//end of fun

}//end of class