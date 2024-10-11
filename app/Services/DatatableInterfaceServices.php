<?php

namespace App\Services;

Interface DatatableInterfaceServices
{
    public function header(array $headers): self;
    
    public function sortable(string $route): self;

    public function route(string $route): self;
    
    public function columns(array $columns): self;

    public function run();
    
}//end of clas