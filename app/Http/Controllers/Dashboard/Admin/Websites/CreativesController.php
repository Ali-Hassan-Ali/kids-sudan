<?php

namespace App\Http\Controllers\Dashboard\Admin\Websites;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Admin\Websites\Creative\CreativeRequest;
use App\Http\Requests\Dashboard\Admin\Websites\Creative\StatusRequest;
use App\Http\Requests\Dashboard\Admin\Websites\Creative\DeleteRequest;
use App\Enums\Admin\CreativeType;
use App\Models\Creative;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;

class CreativesController extends Controller
{
    public function index()
    {
        abort_if(!permissionAdmin('read-creatives'), 403);

        $datatables = datatableServices()
                    ->header([
                        'admin.global.name',
                        'admin.global.image',
                        'admin.global.date',
                        'admin.global.status',
                        'admin.global.links',
                    ])
                    ->checkbox(['status' => 'dashboard.admin.websits.creatives.status'])
                    ->route('dashboard.admin.websits.creatives.data')
                    ->columns(['name','image','date','status','links'])
                    ->run();

        $breadcrumb = [['trans' => 'admin.models.creatives']];

        return view('dashboard.admin.websits.creatives.index', compact('datatables', 'breadcrumb'));

    }//end of index

    public function data(): object
    {
        $permissions = [
            'status' => permissionAdmin('status-creatives'),
            'update' => permissionAdmin('update-creatives'),
            'delete' => permissionAdmin('delete-creatives'),
        ];

        $creative = Creative::query();

        return dataTables()->of($creative)
            ->addColumn('record_select', 'dashboard.admin.dataTables.record_select')
            ->editColumn('created_at', fn (Creative $creative) => $creative?->created_at?->format('Y-m-d'))
            ->editColumn('image', 'dashboard.admin.dataTables.image')
            ->editColumn('name', fn (Creative $creative) => $creative?->name)
            ->addColumn('admin', fn (Creative $creative) => $creative?->admin?->name)
            ->addColumn('actions', function(Creative $creative) use($permissions) {
                $routeEdit   = route('dashboard.admin.websits.creatives.edit', $creative->id);
                $routeDelete = route('dashboard.admin.websits.creatives.destroy', $creative->id);
                return view('dashboard.admin.dataTables.actions', compact('permissions', 'routeEdit', 'routeDelete'));
            })
            ->addColumn('status', fn(Creative $creative) => !$creative->default ? view('dashboard.admin.dataTables.checkbox', ['models' => $creative, 'permissions' => $permissions, 'type' => 'status']) : '')
            ->rawColumns(['record_select', 'actions', 'status', 'name', 'image'])
            ->addIndexColumn()
            ->toJson();

    }//end of data

    public function create(): View
    {
        abort_if(!permissionAdmin('create-creatives'), 403);

        $breadcrumb = [
            [
                'route' => 'dashboard.admin.websits.creatives.index',
                'trans' => 'admin.models.creatives',
            ],
            [
                'route' => '#',
                'trans' => 'admin.global.create',
            ]
        ];

        return view('dashboard.admin.websits.creatives.create', compact('breadcrumb'));
        
    }//end of create

    //RedirectResponse
    public function store(CreativeRequest $request): RedirectResponse
    {
    	$validated = $request->safe()->except(['image', 'links']);

        if(request()->file('image')) {

            $validated['image'] = request()->file('image')->store('creatives', 'public');

        }

        $validated['links'] = json_encode(request()->links);
        
        Creative::create($validated);

        session()->flash('success', __('admin.messages.added_successfully'));
        return redirect()->route('dashboard.admin.websits.creatives.index');

    }//end of store

    public function edit(Creative $creative): View
    {
        abort_if(!permissionAdmin('update-creatives'), 403);

        $breadcrumb = [
            [
                'route' => 'dashboard.admin.websits.creatives.index',
                'trans' => 'admin.models.creatives',
            ],
            [
                'route' => '#',
                'trans' => 'admin.global.edit',
            ]
        ];

        return view('dashboard.admin.websits.creatives.edit', compact('creative', 'breadcrumb'));

    }//end of edit

    public function update(CreativeRequest $request, Creative $creative): RedirectResponse
    {
    	$validated = $request->safe()->except(['image', 'links']);

        if(request()->has('image')) {

            $creative->image != 'default.png' ? Storage::disk('public')->delete($creative->image) : '';

            $validated['image'] = request()->file('image')->store('creatives', 'public');

        }

        $validated['links'] = json_encode(request()->links);

        $creative->update($validated);

        session()->flash('success', __('admin.messages.updated_successfully'));
        return redirect()->route('dashboard.admin.websits.creatives.index');
        
    }//end of update

    public function destroy(Creative $creative): Application | Response | ResponseFactory
    {
        $creative->image != 'default.png' ? Storage::disk('public')->delete($creative->image) : '';
        $creative->delete();

        session()->flash('success', __('admin.messages.deleted_successfully'));
        return response(__('admin.global.deleted_successfully'));

    }//end of delete

    public function bulkDelete(DeleteRequest $request): Application | Response | ResponseFactory
    {
        $images = Creative::find(request()->ids ?? [])?->pluck('image')->toArray();

        count($images) > 0 ? Storage::disk('public')->delete($images) : '';

        Creative::destroy(request()->ids ?? []);

        session()->flash('success', __('admin.messages.deleted_successfully'));
        return response(__('admin.messages.deleted_successfully'));

    }//end of bulkDelete

    public function status(StatusRequest $request): Application | Response | ResponseFactory
    {
        $creative = Creative::find($request->id);
        $creative?->update(['status' => !$creative->status]);

        session()->flash('success', __('admin.messages.updated_successfully'));
        return response(__('admin.messages.updated_successfully'));
        
    }//end of status

}//end of controller