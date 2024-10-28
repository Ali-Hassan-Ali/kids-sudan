<?php

namespace App\Http\Controllers\Dashboard\Admin\Managements;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Admin\Managements\Role\RoleRequest;
use App\Http\Requests\Dashboard\Admin\Managements\Role\DeleteRequest;
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

        $datatables = datatableServices()
                        ->header([
                            'admin.global.name',
                            'admin.models.admin',
                            'admin.models.admins',
                            'admin.models.permissions',
                        ])
                        ->checkbox(['status' => 'dashboard.admin.managements.roles.status'])
                        ->route('dashboard.admin.managements.roles.data')
                        ->columns(['name', 'admin', 'admins', 'permissions'])
                        ->run();

        $breadcrumb = [['trans' => 'admin.models.managements'],['trans' => 'admin.models.roles']];

        return view('dashboard.admin.managements.roles.index', compact('datatables', 'breadcrumb'));

    }//end of index

    public function data(): object
    {
        $permissions = [
            'status' => permissionAdmin('status-roles'),
            'update' => permissionAdmin('update-roles'),
            'delete' => permissionAdmin('delete-roles'),
        ];

        $role = Role::adminJoin()->whereNotIn('roles.name', ['super_admin'])->with('permissions', 'admins', 'adminsRoleCount');

        return dataTables()->of($role)
                ->addColumn('record_select', 'dashboard.admin.dataTables.record_select')
                ->addColumn('admin', fn (Role $role) => $role?->admin_name)
                ->addColumn('admins', fn (Role $role) => $role->adminsRoleCount?->count())
                ->addColumn('permissions', fn (Role $role) => $role->permissions?->count())
                ->addColumn('admins_count', fn (Role $role) => $role?->admins_count)
                ->addColumn('actions', fn(Role $role) => datatableAction($role, $permissions)->buttons()->build())
                ->rawColumns(['record_select', 'actions'])
                ->addIndexColumn()
                ->toJson();

    }//end of data

    public function create(): View
    {
        abort_if(!permissionAdmin('create-roles'), 403);

        $permissions = collect(Permission::select('name', 'group_name')->get())->groupBy('group_name');

        $breadcrumb = [
            ['trans' => 'admin.models.managements'],
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
        $validated = $request->safe()->except(['permissions']);

        $role = \Spatie\Permission\Models\Role::create($validated);
        $role->syncPermissions($request->permissions ?? []);

        session()->flash('success', __('admin.messages.added_successfully'));
        return to_route('dashboard.admin.managements.roles.index');

    }//end of store

    public function edit(\Spatie\Permission\Models\Role $role): View
    {
        abort_if(!permissionAdmin('update-roles'), 404);
        
        $permissions = collect(Permission::select('name', 'group_name')->get())->groupBy('group_name');

        $breadcrumb = [
            ['trans' => 'admin.models.managements'],
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
        $validated = $request->safe()->except(['permissions']);

        $role->update($validated);
        $role->syncPermissions($request->permissions ?? []);

        session()->flash('success', __('admin.messages.updated_successfully'));
        return to_route('dashboard.admin.managements.roles.index');
        
    }//end of update

    public function destroy(Role $role): Application | Response | ResponseFactory
    {
        if(!$role->id == 1) $role->delete();

        session()->flash('success', __('admin.messages.deleted_successfully'));
        return response(__('admin.messages.deleted_successfully'));

    }//end of delete

    public function bulkDelete(DeleteRequest $request): Application | Response | ResponseFactory
    {
        Role::whereNot('name', 'super_admin')->destroy(request()->ids ?? []);

        session()->flash('success', __('admin.messages.deleted_successfully'));
        return response(__('admin.messages.deleted_successfully'));

    }//end of bulkDelete

}//end of controller