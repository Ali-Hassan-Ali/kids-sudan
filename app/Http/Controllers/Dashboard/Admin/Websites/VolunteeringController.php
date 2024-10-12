<?php

namespace App\Http\Controllers\Dashboard\Admin\Websites;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Admin\Websites\Volunteering\VolunteeringRequest;
use App\Http\Requests\Dashboard\Admin\Websites\Volunteering\DeleteRequest;
use App\Http\Requests\Dashboard\Admin\Websites\Volunteering\StatusRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use App\Enums\Admin\WebsitsVolunteeringImageType;
use App\Models\Volunteering;

class VolunteeringController extends Controller
{
    public function index(): View
    {
        abort_if(!permissionAdmin('read-volunteerings'), 403);

        $datatables = datatableServices()
                        ->header([
                            'admin.global.title',
                            'admin.global.image',
                            'admin.models.job',
                            'admin.global.date',
                            'admin.global.status'
                        ])
                        ->checkbox(['status' => 'dashboard.admin.websites.volunteerings.status'])
                        ->route('dashboard.admin.websites.volunteerings.data')
                        ->columns(['title', 'image', 'job', 'date', 'status'])
                        ->sortable('dashboard.admin.websites.volunteerings.sortable.store')
                        ->run();

        $breadcrumb = [
            ['trans' => 'admin.models.websites'],
            ['trans' => 'admin.models.volunteerings'],
            ['trans' => 'admin.global.sortable', 'route' => 'dashboard.admin.websites.volunteerings.sortable.index']
        ];

        return view('dashboard.admin.websites.volunteerings.index', compact('breadcrumb', 'datatables'));

    }//end of index

    public function data(): object
    {
        $permissions = [
            'status' => permissionAdmin('status-volunteerings'),
            'update' => permissionAdmin('update-volunteerings'),
            'delete' => permissionAdmin('delete-volunteerings'),
        ];

        $volunteering = Volunteering::query();

        return dataTables()->of($volunteering)
                ->addColumn('record_select', 'dashboard.admin.dataTables.record_select')
                ->addColumn('created_at', fn (Volunteering $volunteering) => $volunteering?->created_at?->format('Y-m-d'))
                ->editColumn('title', fn (Volunteering $volunteering) => $volunteering?->title)
                ->editColumn('job', fn (Volunteering $volunteering) => $volunteering?->job)
                ->editColumn('description', fn (Volunteering $volunteering) => str()->limit($volunteering->description, 35))
                ->editColumn('image', 'dashboard.admin.dataTables.image')
                ->addColumn('actions', function(Volunteering $volunteering) use($permissions) {
                    $routeEdit   = route('dashboard.admin.websites.volunteerings.edit', $volunteering->id);
                    $routeDelete = route('dashboard.admin.websites.volunteerings.destroy', $volunteering->id);
                    return view('dashboard.admin.dataTables.actions', compact('permissions', 'routeEdit', 'routeDelete'));
                })
                ->addColumn('status', fn (Volunteering $volunteering) => view('dashboard.admin.dataTables.checkbox', ['models' => $volunteering, 'permissions' => $permissions, 'type' => 'status']))
                ->rawColumns(['record_select', 'actions', 'status', 'title', 'job', 'image'])
                ->addIndexColumn()
                ->toJson();

    }//end of data

    public function create(): View
    {
        abort_if(!permissionAdmin('create-volunteerings'), 403);

        $breadcrumb = [
            [
                'route' => 'dashboard.admin.websites.volunteerings.index',
                'trans' => 'admin.models.volunteerings',
            ],
            [
                'route' => '#',
                'trans' => 'admin.global.create',
            ]
        ];

        return view('dashboard.admin.websites.volunteerings.create', compact('breadcrumb'));

    }//end of create

    public function store(VolunteeringRequest $request): RedirectResponse
    {
        $validated = $request->safe()->except(['image']);

        if(request()->has('image')) {

            $validated['image'] = request()->file('image')->store('volunteerings', 'public');

        }

        Volunteering::create($validated);

        session()->flash('success', __('admin.messages.added_successfully'));
        return to_route('dashboard.admin.websites.volunteerings.index');
        
    }//end of update

    public function edit(Volunteering $volunteering): View
    {
        abort_if(!permissionAdmin('update-volunteerings'), 403);

        $breadcrumb = [
            [
                'route' => 'dashboard.admin.websites.volunteerings.index',
                'trans' => 'admin.models.volunteerings',
            ],
            [
                'route' => '#',
                'trans' => 'admin.global.edit',
            ]
        ];

        return view('dashboard.admin.websites.volunteerings.edit', compact('volunteering', 'breadcrumb'));

    }//end of edit

    public function update(VolunteeringRequest $request, Volunteering $volunteering): RedirectResponse
    {
        $validated = $request->safe()->except(['image']);
    
        if(request()->has('image')) {

            $volunteering->image != 'default.png' ? Storage::disk('public')->delete($volunteering->image) : '';

            $validated['image'] = request()->file('image')->store('volunteerings', 'public');
        }

        $volunteering->update($validated);

        session()->flash('success', __('admin.messages.updated_successfully'));
        return to_route('dashboard.admin.websites.volunteerings.index');
        
    }//end of update

    public function destroy(Volunteering $volunteering): Application | Response | ResponseFactory
    {
        $volunteering->image != 'default.png' ? Storage::disk('public')->delete($volunteering->image) : '';
        $volunteering->delete();

        session()->flash('success', __('admin.messages.deleted_successfully'));
        return response(__('admin.global.deleted_successfully'));

    }//end of delete

    public function bulkDelete(DeleteRequest $request): Application | Response | ResponseFactory
    {
    	$images = Volunteering::find(request()->ids ?? [])->pluck('image')->toArray();
        count($images) > 0 ? Storage::disk('public')->delete($images) : '';
        Volunteering::destroy(request()->ids ?? []);

        session()->flash('success', __('admin.messages.deleted_successfully'));
        return response(__('admin.messages.deleted_successfully'));

    }//end of bulkDelete

    public function status(StatusRequest $request): Application | Response | ResponseFactory
    {
        $volunteering = Volunteering::find($request->id);
        $volunteering?->update(['status' => !$volunteering->status]);

        session()->flash('success', __('admin.messages.updated_successfully'));
        return response(__('admin.messages.updated_successfully'));
        
    }//end of status

    public function sortablePage(): View
    {
        $breadcrumb = [
            ['trans' => 'admin.models.websites'],
            ['trans' => 'admin.models.volunteerings', 'route' => 'dashboard.admin.websites.volunteerings.index'],
            ['trans' => 'admin.global.sortable']
        ];

        $volunteerings = Volunteering::pluck('title', 'id')->toArray();

        return view('dashboard.admin.websites.volunteerings.sortable', compact('breadcrumb', 'volunteerings'));

    }//end of sortablePage

    public function storeSortable(): bool
    {        
        foreach (request('order') as $index=>$id) {
            Volunteering::where('id', $id)->update(['index' => $index]);
        }

        return true;
        
    }//end of storeSortable

}//end of controller