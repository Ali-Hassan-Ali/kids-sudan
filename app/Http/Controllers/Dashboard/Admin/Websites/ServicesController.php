<?php

namespace App\Http\Controllers\Dashboard\Admin\Websites;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Admin\Websites\Services\ServicesRequest;
use App\Http\Requests\Dashboard\Admin\Websites\Services\DeleteRequest;
use App\Http\Requests\Dashboard\Admin\Websites\Services\StatusRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use App\Enums\Admin\WebsitsServicesImageType;
use App\Models\Service;

class ServicesController extends Controller
{
    public function index(): View
    {
        abort_if(!permissionAdmin('read-services'), 403);

        $datatables = datatableServices()
                        ->header([
                            'admin.global.title',
                            'admin.global.image',
                            'admin.global.description',
                            'admin.global.status'
                        ])
                        ->checkbox(['status' => 'dashboard.admin.websites.services.status'])
                        ->route('dashboard.admin.websites.services.data')
                        ->columns(['title', 'image', 'description', 'status'])
                        ->sortable('dashboard.admin.websites.services.sortable.store')
                        ->run();

        $imageTypes = WebsitsServicesImageType::array();

        $breadcrumb = [
            ['trans' => 'admin.models.websites'],
            ['trans' => 'admin.models.services'],
            ['trans' => 'admin.global.sortable', 'route' => 'dashboard.admin.websites.services.sortable.index']
        ];

    	return view('dashboard.admin.websites.services.index', compact('breadcrumb', 'imageTypes', 'datatables'));

    }//end of index

    public function data(): object
    {
        $permissions = [
            'status' => permissionAdmin('status-services'),
            'update' => permissionAdmin('update-services'),
            'delete' => permissionAdmin('delete-services'),
        ];

        $services = Service::query();

        return dataTables()->of($services)
                ->addColumn('record_select', 'dashboard.admin.dataTables.record_select')
                ->addColumn('created_at', fn (Service $services) => $services?->created_at?->format('Y-m-d'))
                ->editColumn('title', fn (Service $services) => $services?->title)
                ->editColumn('description', fn (Service $services) => str()->limit($services->description, 35))
                ->addColumn('image', fn (Service $services) => $services?->icon_type)
                ->addColumn('actions', function(Service $services) use($permissions) {
                    $routeEdit   = route('dashboard.admin.websites.services.edit', $services->id);
                    $routeDelete = route('dashboard.admin.websites.services.destroy', $services->id);
                    return view('dashboard.admin.dataTables.actions', compact('permissions', 'routeEdit', 'routeDelete'));
                })
                ->addColumn('status', fn (Service $services) => view('dashboard.admin.dataTables.checkbox', ['models' => $services, 'permissions' => $permissions, 'type' => 'status']))
                ->rawColumns(['record_select', 'actions', 'status', 'title', 'description'])
                ->addIndexColumn()
                ->toJson();

    }//end of data

    public function create(): View
    {
        abort_if(!permissionAdmin('create-services'), 403);

        $breadcrumb = [
            [
                'route' => 'dashboard.admin.websites.services.index',
                'trans' => 'admin.models.services',
            ],
            [
                'route' => '#',
                'trans' => 'admin.global.create',
            ]
        ];

        $imageTypes = WebsitsServicesImageType::array();

        return view('dashboard.admin.websites.services.create', compact('breadcrumb', 'imageTypes'));

    }//end of create

    public function store(ServicesRequest $request): RedirectResponse
    {
        $validated = $request->safe()->except(['icon']);

        if($request->icon_type == 'image' && request()->has('icon')) {

            $validated['icon'] = request()->file('icon')->store('services', 'public');

        } else {

            $validated['icon'] = request()->icon;
        }

        Service::create($validated);

        session()->flash('success', __('admin.messages.added_successfully'));
        return redirect()->route('dashboard.admin.websites.services.index');
        
    }//end of update

    public function edit(Service $service): View
    {
        abort_if(!permissionAdmin('update-services'), 403);

        $breadcrumb = [
            [
                'route' => 'dashboard.admin.websites.services.index',
                'trans' => 'admin.models.services',
            ],
            [
                'route' => '#',
                'trans' => 'admin.global.edit',
            ]
        ];

        $imageTypes = WebsitsServicesImageType::array();

        return view('dashboard.admin.websites.services.edit', compact('service', 'breadcrumb', 'imageTypes'));

    }//end of edit

    public function update(ServicesRequest $request, Service $service): RedirectResponse
    {
        $validated = $request->safe()->except(['icon']);

        if ($service->icon_type == 'image' && $request->icon_type == 'image') {
            
            $service->icon_type == 'image' ? Storage::disk('public')->delete($service->icon) : '';
        }

        if ($request->icon_type == 'image') {
            
            if(request()->has('icon')) {

                $service->icon_type == 'image' ? Storage::disk('public')->delete($service->icon) : '';

                $validated['icon'] = request()->file('icon')->store('services', 'public');
            }

        } else {

            $service->update($validated);
        }

        session()->flash('success', __('admin.messages.updated_successfully'));
        return redirect()->route('dashboard.admin.websites.services.index');
        
    }//end of update

    public function destroy(Service $service): Application | Response | ResponseFactory
    {
        $service->icon_type == 'image' ? Storage::disk('public')->delete($service->icon) : '';
        $service->delete();

        session()->flash('success', __('admin.messages.deleted_successfully'));
        return response(__('admin.global.deleted_successfully'));

    }//end of delete

    public function bulkDelete(DeleteRequest $request): Application | Response | ResponseFactory
    {
        Service::find(request()->ids ?? [])->each(
            fn ($service) => $service->icon_type == 'image' ? Storage::disk('public')->delete($service->icon) : ''
        );

        Service::destroy(request()->ids ?? []);

        session()->flash('success', __('admin.messages.deleted_successfully'));
        return response(__('admin.messages.deleted_successfully'));

    }//end of bulkDelete

    public function status(StatusRequest $request): Application | Response | ResponseFactory
    {
        $services = Service::find($request->id);
        $services?->update(['status' => !$services->status]);

        session()->flash('success', __('admin.messages.updated_successfully'));
        return response(__('admin.messages.updated_successfully'));
        
    }//end of status

    public function sortablePage(): View
    {
        $breadcrumb = [
            ['trans' => 'admin.models.websites'],
            ['trans' => 'admin.models.services', 'route' => 'dashboard.admin.websites.services.index'],
            ['trans' => 'admin.global.sortable']
        ];

        $services = Service::pluck('title', 'id')->toArray();

        return view('dashboard.admin.websites.services.sortable', compact('breadcrumb', 'services'));

    }//end of sortablePage

    public function storeSortable(): bool
    {        
        foreach (request('order') as $index=>$id) {
            Service::where('id', $id)->update(['index' => $index]);
        }

        return true;
        
    }//end of storeSortable

}//end of controller