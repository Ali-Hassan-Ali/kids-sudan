<?php

namespace App\Services;

class DatatableServices implements DatatableInterfaceServices
{
    protected $headers = [];

    protected $route   = '';

    protected $columns = [];

    protected $this    = [];

    public function header(array $headers) : self
    {
        $this->headers = $headers;

        return $this;

    }//end of headers

    public function route(string $route): self
    {
        $this->route = route($route);
        return $this;

    }//end of headers

    public function checkbox(array $checkbox): self
    {
        $items = collect([]);

        collect($checkbox)->each(fn ($item, $key) => $items->put($key, route($item)));

        $this->checkbox = $items;
        return $this;

    }//end of checkbox

    public function columns(array $columns): self
    {
        $items = collect([]);

        collect($columns)->each(fn ($item) => $items->put($item, $item));

        $this->columns = $items;
        return $this;

    }//end of columns

    public function run()
    {
        return [
            'header'   => $this->headers,
            'route'    => $this->route,
            'checkbox' => $this->checkbox,
            'columns'  => $this->columns,
        ];

    }//end of run

    public function __get($name)
    {
        if ($name === 'headers') {
            
            return $this->headers;

        } elseif ($name === 'route') {

            return $this->route;

        } elseif ($name === 'columns') {

            return $this->columns;

        } elseif ($name === 'checkbox') {

            return $this->checkbox;
        }
        
        return null;

    }//end of __get

}//end of class