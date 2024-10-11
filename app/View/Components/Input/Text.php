<?php

namespace App\View\Components\Input;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Text extends Component
{
    public function __construct(
        public $id       = '',
        public $index    = '',
        public $col      = 'col-md',
        public $name     = '',
        public $type     = 'text',
        public $value    = '',
        public $label    = '',
        public $required = false,
        public $disabled = false,
        public $hidden   = false,
        public $readonly = false,
        public $invalid  = '',
        public $old      = '',
    ) {
        $this->id      = $this->id ? $id : $this->convertToDotNotation($name, $index);
        $this->invalid = $this->invalidCheck($name, $index);
        $this->old     = $this->invalidCheck($name, $index);
    }

    public function render(): View | Closure | string
    {
        return view('components.input.text');

    }//end of render

    public function containsBrackets(string $string) 
    {
        return strpos($string, '[') !== false && strpos($string, ']') !== false;

    }//end of render

    public function invalidCheck(string $name, string | int | bool $index = false)
    {
        if ($this->containsBrackets($name)) {

            $name = str_replace(['[', ']'], ['.',''], $name) . $index;
            $name = rtrim($name, '.');
        } 

        return $name;

    }//end of fun

    public function convertToDotNotation(string $name, $index = false)
    {
        $name = str_replace(['[', ']'], ['-',''], $name) . $index;
        $name = str_replace('_', '-', $name) . $index;
        $name = rtrim($name, '-');

        return $name;

    }//end of fun

}//end of class