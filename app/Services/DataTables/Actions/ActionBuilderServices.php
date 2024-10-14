<?php

namespace App\Services\DataTables\Actions;

use Illuminate\Support\Facades\Route;

class ActionBuilderServices implements ActionBuilderInterfaceServices
{
    protected $model          = [];
    protected $buttons        = [];
    protected $excepteButtons = [];
    protected $baseRoute      = '';
    protected $permissions    = [];

    public function __construct(object $model, array $permissions)
    {
        $this->model       = $model;
        $this->permissions = $permissions;
        $this->baseRoute   = 'dashboard.admin.' . request()->segment(3) . '.' . request()->segment(4);
    }

    /**
     * Set the buttons for actions.
     */ 
    public function buttons(array $buttons = ['update', 'delete']): self
    {
        $this->buttons = collect($buttons)->unique()->toArray();

        return $this;
    }

    /**
     * Set the base route for actions.
     */
    public function excepteButtons(array $excluded = []): self
    {
        $this->excepteButtons = collect($excluded)->filter(fn($value, $key) => $value == true)->keys()->toArray();

        return $this;
    }

    /**
     * Set the base route for actions.
     */
    public function baseRoute(string $baseRoute = 'dashboard.admin.'): self
    {
        $this->baseRoute = $baseRoute ?? $this->baseRoute;

        return $this;

    }//end of baseRoute

    public function build()
    {
        $buttons = collect($this->buttons)->filter(fn($button) => in_array($button, $this->excepteButtons) ? '' : $button);

        return view('dashboard.admin.dataTables.actions', 
            [
                'buttons'     => $buttons,
                'model'       => $this->model,
                'permissions' => $this->permissions,
                'baseRoute'   => $this->baseRoute,
            ])->render();

    }//end of build

}//end of class