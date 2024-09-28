<?php

namespace App\Http\Controllers\Dashboard\Admin\Managements;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Admin\Managements\Admin\AdminRequest;
use App\Http\Requests\Dashboard\Admin\Managements\Admin\StatusRequest;
use App\Http\Requests\Dashboard\Admin\Managements\Admin\DeleteRequest;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;

class AdminController extends Controller
{
    public function index(): View
    {
        abort_if(!permissionAdmin('read-admins'), 403);

        $datatables = DatatableServices()
                    ->header([
                        'admin.global.name',
                        'admin.global.email',
                        'admin.global.image',
                        'menu.roles',
                        'admin.global.status'
                    ])
                    ->checkbox(['status' => 'dashboard.admin.managements.admins.status'])
                    ->route('dashboard.admin.managements.admins.data')
                    ->columns(['name', 'email', 'image', 'roles', 'status'])
                    ->run();

        $breadcrumb = [['trans' => 'admin.models.admins']];

        return view('dashboard.admin.managements.admins.index', compact('datatables', 'breadcrumb'));

    }//end of index

    public function data(): object
    {
        $permissions = [
            'status' => permissionAdmin('status-admins'),
            'update' => permissionAdmin('update-admins'),
            'delete' => permissionAdmin('delete-admins'),
        ];

        $admin = Admin::roleNot(['super_admin']);

        return dataTables()->of($admin)
            ->addColumn('record_select', 'dashboard.admin.dataTables.record_select')
            ->addColumn('created_at', fn (Admin $admin) => $admin?->created_at?->format('Y-m-d'))
            ->editColumn('image', fn(Admin $admin) => view('dashboard.admin.dataTables.image', ['models' => $admin]))
            ->addColumn('roles', fn(Admin $admin) => view('dashboard.admin.managements.admins.data_tables.roles', compact('admin')))
            ->addColumn('actions', function(Admin $admin) use($permissions) {
                $routeEdit   = route('dashboard.admin.managements.admins.edit', $admin->id);
                $routeDelete = route('dashboard.admin.managements.admins.destroy', $admin->id);
                return view('dashboard.admin.dataTables.actions', compact('permissions', 'routeEdit', 'routeDelete'));
            })
            ->addColumn('status', fn (Admin $admin) => !$admin->default ? view('dashboard.admin.dataTables.checkbox', ['models' => $admin, 'permissions' => $permissions, 'type' => 'status']) : '')
            ->rawColumns(['record_select', 'actions', 'status', 'roles'])
            ->addIndexColumn()
            ->toJson();

    }//end of data

    public function create(): View
    {
        abort_if(!permissionAdmin('create-admins'), 403);

        $roles = Role::whereNotIn('name', ['super_admin'])->pluck('name', 'name');

        $breadcrumb = [
            [
                'route' => 'dashboard.admin.managements.admins.index',
                'trans' => 'admin.models.admins',
            ],
            [
                'route' => '#',
                'trans' => 'admin.global.create',
            ]
        ];

        return view('dashboard.admin.managements.admins.create', compact('roles', 'breadcrumb'));
        
    }//end of create

    //RedirectResponse
    public function store(AdminRequest $request): RedirectResponse
    {
        $requestData = request()->except(['image', 'roles', 'password_confirmation']);

        if(request()->file('image')) {

            $requestData['image'] = request()->file('image')->store('admins', 'public');

        }

        $admin = Admin::create($requestData);

        if(request()->has('password')) $admin->update(['password' => bcrypt(request()->password)]);

        if(request()->has('roles')) $admin->assignRole(request()->roles);

        session()->flash('success', __('admin.messages.added_successfully'));
        return redirect()->route('dashboard.admin.managements.admins.index');

    }//end of store

    public function edit(Admin $admin): View
    {
        abort_if(!permissionAdmin('update-admins'), 403);

        $breadcrumb = [
            [
                'route' => 'dashboard.admin.managements.admins.index',
                'trans' => 'admin.models.admins',
            ],
            [
                'route' => '#',
                'trans' => 'admin.global.edit',
            ]
        ];
        
        $roles = Role::whereNotIn('name', ['super_admin'])->pluck('name', 'name');

        return view('dashboard.admin.managements.admins.edit', compact('admin', 'roles', 'breadcrumb'));

    }//end of edit

    public function update(AdminRequest $request, Admin $admin): RedirectResponse
    {
        $requestData = request()->except(['image', 'roles', 'password', 'password_confirmation']);

        if(request()->has('image')) {

            $admin->image ? Storage::disk('public')->delete($admin->image) : '';

            $requestData['image'] = request()->file('image')->store('admins', 'public');

        }//end of has image request

        $admin->update($requestData);
        $admin->syncRoles(request()->roles ?? []);
        if(request()->has('password')) $admin->update(['password' => bcrypt(request()->password)]);

        session()->flash('success', __('admin.messages.updated_successfully'));
        return redirect()->route('dashboard.admin.managements.admins.index');
        
    }//end of update

    public function destroy(Admin $admin): Application | Response | ResponseFactory
    {
        $admin->image ? Storage::disk('public')->delete($admin->image) : '';
        $admin->delete();

        session()->flash('success', __('admin.messages.deleted_successfully'));
        return response(__('admin.global.deleted_successfully'));

    }//end of delete

    public function bulkDelete(DeleteRequest $request): Application | Response | ResponseFactory
    {
        $images = Admin::find(request()->ids ?? [])->whereNotNull('image')->pluck('image')->toArray();
        count($images) > 0 ? Storage::disk('public')->delete($images) : '';
        Admin::destroy(request()->ids ?? []);

        session()->flash('success', __('admin.messages.deleted_successfully'));
        return response(__('admin.messages.deleted_successfully'));

    }//end of bulkDelete

    public function status(StatusRequest $request): Application | Response | ResponseFactory
    {
        $admin = Admin::find($request->id);
        $admin->update(['status' => !$admin->status]);

        session()->flash('success', __('admin.messages.updated_successfully'));
        return response(__('admin.messages.updated_successfully'));
        
    }//end of status

}//end of controller