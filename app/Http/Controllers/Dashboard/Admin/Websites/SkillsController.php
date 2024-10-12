<?php

namespace App\Http\Controllers\Dashboard\Admin\Websites;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Admin\Websites\Skills\SkillsRequest;
use App\Http\Requests\Dashboard\Admin\Websites\Skills\DeleteRequest;
use App\Http\Requests\Dashboard\Admin\Websites\Skills\StatusRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use App\Enums\Admin\WebsitsSkillsImageType;
use App\Models\Skills;

class SkillsController extends Controller
{
    public function index(): View
    {
        abort_if(!permissionAdmin('read-skills'), 403);

        $datatables = datatableServices()
                        ->header([
                            'admin.global.title',
                            'admin.global.image',
                            'admin.global.description',
                            'admin.global.status'
                        ])
                        ->checkbox(['status' => 'dashboard.admin.websits.skills.status'])
                        ->route('dashboard.admin.websits.skills.data')
                        ->columns(['title', 'image', 'description', 'status'])
                        ->sortable('dashboard.admin.websits.skills.sortable.store')
                        ->run();

        $imageTypes = WebsitsSkillsImageType::array();

        $breadcrumb = [
            ['trans' => 'admin.models.websits'],
            ['trans' => 'admin.websits.banners.skills'],
            ['trans' => 'admin.global.sortable', 'route' => 'dashboard.admin.websits.skills.sortable.index']
        ];

    	return view('dashboard.admin.websits.skills.index', compact('breadcrumb', 'imageTypes', 'datatables'));

    }//end of index

    public function data(): object
    {
        $permissions = [
            'status' => permissionAdmin('status-skills'),
            'update' => permissionAdmin('update-skills'),
            'delete' => permissionAdmin('delete-skills'),
        ];

        $skills = Skills::query();

        return dataTables()->of($skills)
                ->addColumn('record_select', 'dashboard.admin.dataTables.record_select')
                ->addColumn('created_at', fn (Skills $skills) => $skills?->created_at?->format('Y-m-d'))
                ->editColumn('title', fn (Skills $skills) => $skills?->title)
                ->editColumn('description', fn (Skills $skills) => str()->limit($skills->description, 35))
                ->addColumn('image', fn (Skills $skills) => $skills?->icon_type)
                ->addColumn('actions', function(Skills $skills) use($permissions) {
                    $routeEdit   = route('dashboard.admin.websits.skills.edit', $skills->id);
                    $routeDelete = route('dashboard.admin.websits.skills.destroy', $skills->id);
                    return view('dashboard.admin.dataTables.actions', compact('permissions', 'routeEdit', 'routeDelete'));
                })
                ->addColumn('status', fn (Skills $skills) => view('dashboard.admin.dataTables.checkbox', ['models' => $skills, 'permissions' => $permissions, 'type' => 'status']))
                ->rawColumns(['record_select', 'actions', 'status', 'title', 'description'])
                ->addIndexColumn()
                ->toJson();

    }//end of data

    public function create(): View
    {
        abort_if(!permissionAdmin('create-skills'), 403);

        $breadcrumb = [
            [
                'route' => 'dashboard.admin.websits.skills.index',
                'trans' => 'admin.models.skills',
            ],
            [
                'route' => '#',
                'trans' => 'admin.global.create',
            ]
        ];

        $imageTypes = WebsitsSkillsImageType::array();

        return view('dashboard.admin.websits.skills.create', compact('breadcrumb', 'imageTypes'));

    }//end of create

    public function store(SkillsRequest $request): RedirectResponse
    {
        $validated = $request->safe()->except(['icon']);

        if($request->icon_type == 'image' && request()->has('icon')) {

            $validated['icon'] = request()->file('icon')->store('skills', 'public');

        } else {

            $validated['icon'] = request()->icon;
        }

        Skills::create($validated);

        session()->flash('success', __('admin.messages.added_successfully'));
        return redirect()->route('dashboard.admin.websits.skills.index');
        
    }//end of update

    public function edit(Skills $skill): View
    {
        abort_if(!permissionAdmin('update-skills'), 403);

        $breadcrumb = [
            [
                'route' => 'dashboard.admin.websits.skills.index',
                'trans' => 'admin.models.skills',
            ],
            [
                'route' => '#',
                'trans' => 'admin.global.edit',
            ]
        ];

        $imageTypes = WebsitsSkillsImageType::array();

        return view('dashboard.admin.websits.skills.edit', compact('skill', 'breadcrumb', 'imageTypes'));

    }//end of edit

    public function update(SkillsRequest $request, Skills $skill): RedirectResponse
    {
        $validated = $request->safe()->except(['icon']);

        if ($skill->icon_type == 'image' && $request->icon_type == 'image') {
            
            $skill->icon_type == 'image' ? Storage::disk('public')->delete($skill->icon) : '';
        }

        if ($request->icon_type == 'image') {
            
            if(request()->has('icon')) {

                $skill->icon_type == 'image' ? Storage::disk('public')->delete($skill->icon) : '';

                $validated['icon'] = request()->file('icon')->store('skills', 'public');
            }

        } else {

            $skill->update($validated);
        }

        session()->flash('success', __('admin.messages.updated_successfully'));
        return redirect()->route('dashboard.admin.websits.skills.index');
        
    }//end of update

    public function destroy(Skills $skill): Application | Response | ResponseFactory
    {
        $skill->icon_type == 'image' ? Storage::disk('public')->delete($skill->icon) : '';
        $skill->delete();

        session()->flash('success', __('admin.messages.deleted_successfully'));
        return response(__('admin.global.deleted_successfully'));

    }//end of delete

    public function bulkDelete(DeleteRequest $request): Application | Response | ResponseFactory
    {
        Skills::find(request()->ids ?? [])->each(
            fn ($skill) => $skill->icon_type == 'image' ? Storage::disk('public')->delete($skill->icon) : ''
        );

        Skills::destroy(request()->ids ?? []);

        session()->flash('success', __('admin.messages.deleted_successfully'));
        return response(__('admin.messages.deleted_successfully'));

    }//end of bulkDelete

    public function status(StatusRequest $request): Application | Response | ResponseFactory
    {
        $skills = Skills::find($request->id);
        $skills?->update(['status' => !$skills->status]);

        session()->flash('success', __('admin.messages.updated_successfully'));
        return response(__('admin.messages.updated_successfully'));
        
    }//end of status

    public function sortablePage(): View
    {
        $breadcrumb = [
            ['trans' => 'admin.models.websits'],
            ['trans' => 'admin.websits.banners.skills', 'route' => 'dashboard.admin.websits.skills.index'],
            ['trans' => 'admin.global.sortable']
        ];

        $skills = Skills::pluck('title', 'id')->toArray();

        return view('dashboard.admin.websits.skills.sortable', compact('breadcrumb', 'skills'));

    }//end of sortablePage

    public function storeSortable(): bool
    {        
        foreach (request('order') as $index=>$id) {
            Skills::where('id', $id)->update(['index' => $index]);
        }

        return true;
        
    }//end of storeSortable

}//end of controller