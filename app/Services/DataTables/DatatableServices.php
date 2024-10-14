<?php

namespace App\Services\DataTables;

use ArrayAccess;
use JsonSerializable;

class DatatableServices implements DatatableInterfaceServices, ArrayAccess, JsonSerializable
{
    protected $header   = [];
    protected $route    = '';
    protected $sortable = '';
    protected $columns  = [];
    protected $checkbox = [];

    public function header(array $headers): self
    {
        $this->header = $headers;
        return $this;
    }

    public function sortable(string | bool $sortable = false): self
    {
        $this->sortable = $sortable ? route($sortable) : '';
        return $this;
    }

    public function route(string $route): self
    {
        $this->route = route($route);
        return $this;
    }

    public function checkbox(array $checkbox): self
    {
        $items = collect([]);
        collect($checkbox)->each(fn ($item, $key) => $items->put($key, route($item)));
        $this->checkbox = $items;
        return $this;
    }

    public function columns(array $columns): self
    {
        $items = collect([]);
        collect($columns)->each(fn ($item, $key) => $items->put($item, $item));
        $this->columns = $items;
        return $this;
    }

    public function run()
    {
        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'headers'       => $this->headers,
            'route'         => $this->route,
            'sortableRoute' => $this->sortableRoute,
            'columns'       => $this->columns,
            'checkbox'      => $this->checkbox,
        ];
    }

    public function __get($name)
    {
        return property_exists($this, $name) ? $this->$name : null;
    }

    public function offsetExists($offset): bool
    {
        return isset($this->$offset);
    }

    public function offsetGet($offset): mixed
    {
        return $this->$offset ?? null;
    }

    public function offsetSet($offset, $value): void
    {
        $this->$offset = $value;
    }

    public function offsetUnset($offset): void
    {
        unset($this->$offset);
    }
} // end of class
