<?php

namespace App\Services\DataTables\Actions;

use Illuminate\Support\Facades\Route;

class ActionBuilderServices implements ActionBuilderInterfaceServices
{
    protected $model          = [];
    protected $buttons        = [];
    protected $excepteButtons = [];
    protected $bassRoute      = '';
    protected $permissions    = [];

    public function __construct(object $model, array $permissions)
    {
        $this->model       = $model;
        $this->permissions = $permissions;
    }

    /**
     * Set the buttons for actions.
     */
    public function buttons(array $buttons = ['update', 'delete']): self
    {
        $items = collect([]);
        collect($buttons)->each(fn ($item, $key) => $items->put($item, $item));
        $this->buttons = $items->toArray();
        return $this;
    }

    /**
     * Set the base route for actions.
     */
    public function excepteButtons(array $excepted = []): self
    {
        $exceptedItem = collect([]);
        collect($excepted)->each(fn ($key, $item) => $key == true ? $exceptedItem->push($item) : false);

        $items = collect([]);
        collect($this->buttons)->each(fn ($key, $item) => in_array($item, $exceptedItem->toArray()) ? '' : $items->put($item, $item));
        $this->buttons = $items->toArray();

        return $this;
    }

    /**
     * Set the base route for actions.
     */
    public function bassRoute(string $bassRoute = 'dashboard.admin.'): self
    {
        $this->bassRoute = $bassRoute . request()->segment(3);
        return $this;

    }//end of bassRoute

    public function build()
    {
        return view('dashboard.admin.dataTables.actions', 
            [
                'buttons'     => $this->buttons,
                'model'       => $this->model,
                'permissions' => $this->permissions,
                'bassRoute'   => 'dashboard.admin.' . request()->segment(3) . '.' . request()->segment(4),
            ])->render();

    }//end of build

}//end of class