<?php

namespace App\Http\Controllers\Dashboard\Admin\Managements;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Admin\Managements\Role\RoleRequest;
use App\Http\Requests\Dashboard\Admin\Managements\Role\DeleteRequest;
use App\Services\DatatableServices;
use App\Models\Admin;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;

class RoleController extends Controller
{
    public function index(): View
    {
        abort_if(!permissionAdmin('read-roles'), 403);

        $datatables = (new DatatableServices())->header(
            [
                'route' => route('dashboard.admin.managements.roles.data'),
                'header'  => [
                    'admin.global.name',
                    'admin.models.admin',
                    'admin.models.admins',
                ],
                'columns' => [
                    'name'    => 'name',
                    'admin'   => 'admin',
                    'admins'  => 'admins',
                ]
            ]
        );

        $breadcrumb = [['trans' => 'admin.models.roles']];

        return view('dashboard.admin.managements.roles.index', compact('datatables', 'breadcrumb'));

    }//end of index

    public function data(): object
    {
        $permissions = [
            'status' => 'status-roles',
            'update' => 'update-roles',
            'delete' => 'delete-roles',
        ];

        $role = Role::roleNot();

        return dataTables()->of($role)
            ->addColumn('record_select', 'dashboard.admin.dataTables.record_select')
            ->addColumn('created_at', fn (Role $role) => $role?->created_at?->format('Y-m-d'))
            ->addColumn('admin', fn (Role $role) => $role?->admin?->name)
            ->addColumn('admins', fn (Role $role) => Admin::role($role->name)->count())
            ->addColumn('admins_count', fn (Role $role) => $role?->admins?->count())
            ->addColumn('actions', function(Role $role) use($permissions) {
                $routeEdit   = route('dashboard.admin.managements.roles.edit', $role->id);
                $routeDelete = route('dashboard.admin.managements.roles.destroy', $role->id);
                return view('dashboard.admin.dataTables.actions', compact('permissions', 'routeEdit', 'routeDelete'));
            })
            ->rawColumns(['record_select', 'actions'])
            ->addIndexColumn()
            ->toJson();

    }//end of data

    public function create(): View
    {
        abort_if(!permissionAdmin('create-roles'), 403);

        $permissions = collect(Permission::select('name', 'group_name')->get())->groupBy('group_name');

        $breadcrumb = [
            [
                'route' => 'dashboard.admin.managements.roles.index',
                'trans' => 'admin.models.roles',
            ],
            [
                'route' => '#',
                'trans' => 'admin.global.create',
            ]
        ];

        return view('dashboard.admin.managements.roles.create', compact('permissions', 'breadcrumb'));
        
    }//end of create

    //RedirectResponse
    public function store(RoleRequest $request): RedirectResponse
    {
        $validated = request()->except(['permissions']);

        $role = \Spatie\Permission\Models\Role::create($validated);
        $role->syncPermissions($request->permissions ?? []);

        session()->flash('success', __('admin.messages.added_successfully'));
        return redirect()->route('dashboard.admin.managements.roles.index');

    }//end of store

    public function edit(\Spatie\Permission\Models\Role $role): View
    {
        abort_if(!permissionAdmin('update-roles'), 404);
        
        $permissions = collect(Permission::select('name', 'group_name')->get())->groupBy('group_name');

        $breadcrumb = [
            [
                'route' => 'dashboard.admin.managements.roles.index',
                'trans' => 'admin.models.roles',
            ],
            [
                'route' => '#',
                'trans' => 'admin.global.edit',
            ]
        ];


        return view('dashboard.admin.managements.roles.edit', compact('role', 'permissions', 'breadcrumb'));

    }//end of edit

    public function update(RoleRequest $request, \Spatie\Permission\Models\Role $role): RedirectResponse
    {
        $validated = request()->except(['permissions']);

        $role->update($validated);
        $role->syncPermissions($request->permissions ?? []);

        session()->flash('success', __('admin.messages.updated_successfully'));
        return redirect()->route('dashboard.admin.managements.roles.index');
        
    }//end of update

    public function destroy(Role $role): Application | Response | ResponseFactory
    {
        if(!$role->default) {

            $role->flag ? Storage::disk('public')->delete($role->flag) : '';
            $role->delete();
        }

        session()->flash('success', __('admin.messages.deleted_successfully'));
        return response(__('admin.messages.deleted_successfully'));

    }//end of delete

    public function bulkDelete(DeleteRequest $request): Application | Response | ResponseFactory
    {
        $images = Role::where('default', 0)->find(request()->ids ?? [])->pluck('flag')->toArray();
        Storage::disk('public')->delete($images) ?? '';
        Role::where('default', 0)->destroy(request()->ids ?? []);

        session()->flash('success', __('admin.messages.deleted_successfully'));
        return response(__('admin.messages.deleted_successfully'));

    }//end of bulkDelete

}//end of controller