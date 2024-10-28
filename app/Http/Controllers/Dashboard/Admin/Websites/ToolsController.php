<?php

namespace App\Http\Controllers\Dashboard\Admin\Websites;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Admin\Websites\Tools\ToolsRequest;
use App\Http\Requests\Dashboard\Admin\Websites\Tools\DeleteRequest;
use App\Http\Requests\Dashboard\Admin\Websites\Tools\StatusRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use App\Enums\Admin\WebsitsToolsImageType;
use App\Models\Tools;

class ToolsController extends Controller
{
    public function index(): View
    {
        abort_if(!permissionAdmin('read-tools'), 403);

        $datatables = datatableServices()
                        ->header([
                            'admin.global.title',
                            'admin.global.image',
                            'admin.global.description',
                            'admin.global.status'
                        ])
                        ->checkbox(['status' => 'dashboard.admin.websites.tools.status'])
                        ->route('dashboard.admin.websites.tools.data')
                        ->columns(['title', 'image', 'description', 'status'])
                        ->sortable('dashboard.admin.websites.tools.sortable.store')
                        ->run();

        $imageTypes = WebsitsToolsImageType::array();

        $breadcrumb = [
            ['trans' => 'admin.models.websites'],
            ['trans' => 'admin.websites.tools'],
            ['trans' => 'admin.global.sortable', 'route' => 'dashboard.admin.websites.tools.sortable.index']
        ];

        return view('dashboard.admin.websites.tools.index', compact('breadcrumb', 'imageTypes', 'datatables'));

    }//end of index

    public function data(): object
    {
        $permissions = [
            'status' => permissionAdmin('status-tools'),
            'update' => permissionAdmin('update-tools'),
            'delete' => permissionAdmin('delete-tools'),
        ];

        $tools = Tools::query();

        return dataTables()->of($tools)
                ->addColumn('record_select', 'dashboard.admin.dataTables.record_select')
                ->editColumn('title', fn (Tools $tools) => $tools?->title)
                ->editColumn('description', fn (Tools $tools) => str()->limit($tools->description, 35))
                ->addColumn('image', 'dashboard.admin.websites.tools.icon_type')
                ->addColumn('actions', fn(Tools $tools) => datatableAction($tools, $permissions)->buttons()->build())
                ->addColumn('status', fn (Tools $tools) => view('dashboard.admin.dataTables.checkbox', ['models' => $tools, 'permissions' => $permissions, 'type' => 'status']))
                ->rawColumns(['record_select', 'actions', 'status', 'title', 'description', 'image'])
                ->addIndexColumn()
                ->toJson();

    }//end of data

    public function create(): View
    {
        abort_if(!permissionAdmin('create-tools'), 403);

        $breadcrumb = [
            [
                'route' => 'dashboard.admin.websites.tools.index',
                'trans' => 'admin.models.tools',
            ],
            [
                'route' => '#',
                'trans' => 'admin.global.create',
            ]
        ];

        $imageTypes = WebsitsToolsImageType::array();

        return view('dashboard.admin.websites.tools.create', compact('breadcrumb', 'imageTypes'));

    }//end of create

    public function store(ToolsRequest $request): RedirectResponse
    {
        $validated = $request->safe()->except(['icon']);

        if($request->icon_type == 'image' && request()->has('icon')) {

            $validated['icon'] = request()->file('icon')->store('tools', 'public');

        } else {

            $validated['icon'] = request()->icon;
        }

        Tools::create($validated);

        session()->flash('success', __('admin.messages.added_successfully'));
        return to_route('dashboard.admin.websites.tools.index');
        
    }//end of update

    public function edit(Tools $tool): View
    {
        abort_if(!permissionAdmin('update-tools'), 403);

        $breadcrumb = [
            [
                'route' => 'dashboard.admin.websites.tools.index',
                'trans' => 'admin.models.tools',
            ],
            [
                'route' => '#',
                'trans' => 'admin.global.edit',
            ]
        ];

        $imageTypes = WebsitsToolsImageType::array();

        return view('dashboard.admin.websites.tools.edit', compact('tool', 'breadcrumb', 'imageTypes'));

    }//end of edit

    public function update(ToolsRequest $request, Tools $tool): RedirectResponse
    {
        $validated = $request->safe()->except(['icon']);

        if ($tool->icon_type == 'image' && $request->icon_type != 'image') Storage::disk('public')->delete($tool->icon);

        if ($request->icon_type == 'image') {
            
            if(request()->has('icon')) {

                $tool->icon_type == 'image' ? Storage::disk('public')->delete($tool->icon) : '';

                $validated['icon'] = request()->file('icon')->store('tools', 'public');
            }

        } else {

            $validated['icon'] = request()->icon;
        }

        $tool->update($validated);

        session()->flash('success', __('admin.messages.updated_successfully'));
        return to_route('dashboard.admin.websites.tools.index');
        
    }//end of update

    public function destroy(Tools $tool): Application | Response | ResponseFactory
    {
        $tool->icon_type == 'image' ? Storage::disk('public')->delete($tool->icon) : '';
        $tool->delete();

        session()->flash('success', __('admin.messages.deleted_successfully'));
        return response(__('admin.global.deleted_successfully'));

    }//end of delete

    public function bulkDelete(DeleteRequest $request): Application | Response | ResponseFactory
    {
        Tools::find(request()->ids ?? [])->each(
            fn ($tool) => $tool->icon_type == 'image' ? Storage::disk('public')->delete($tool->icon) : ''
        );

        Tools::destroy(request()->ids ?? []);

        session()->flash('success', __('admin.messages.deleted_successfully'));
        return response(__('admin.messages.deleted_successfully'));

    }//end of bulkDelete

    public function status(StatusRequest $request): Application | Response | ResponseFactory
    {
        $tools = Tools::find($request->id);
        $tools?->update(['status' => !$tools->status]);

        session()->flash('success', __('admin.messages.updated_successfully'));
        return response(__('admin.messages.updated_successfully'));
        
    }//end of status

    public function sortablePage(): View
    {
        $breadcrumb = [
            ['trans' => 'admin.models.websites'],
            ['trans' => 'admin.websites.tools', 'route' => 'dashboard.admin.websites.tools.index'],
            ['trans' => 'admin.global.sortable']
        ];

        $tools = Tools::pluck('title', 'id')->toArray();

        return view('dashboard.admin.websites.tools.sortable', compact('breadcrumb', 'tools'));

    }//end of sortablePage

    public function storeSortable(): bool
    {        
        foreach (request('order') as $index=>$id) {
            Tools::where('id', $id)->update(['index' => $index]);
        }

        return true;
        
    }//end of storeSortable

}//end of controller