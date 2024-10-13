<?php

namespace App\Http\Controllers\Dashboard\Admin\Managements;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Admin\Managements\Language\LanguageRequest;
use App\Http\Requests\Dashboard\Admin\Managements\Language\StatusRequest;
use App\Http\Requests\Dashboard\Admin\Managements\Language\DeleteRequest;
use App\Enums\Admin\LanguageType;
use App\Models\Language;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;

class LanguageController extends Controller
{
    public function index()
    {
        abort_if(!permissionAdmin('read-languages'), 403);

        $datatables = datatableServices()
                        ->header([
                            'admin.global.name',
                            'admin.managements.languages.dir',
                            'admin.managements.languages.flag',
                            'admin.managements.languages.code',
                            'admin.global.default',
                            'admin.global.admin',
                            'admin.global.status',
                        ])
                        ->checkbox(['status' => 'dashboard.admin.managements.languages.status'])
                        ->route('dashboard.admin.managements.languages.data')
                        ->columns(['name','dir','flag','code','default','admin','status'])
                        ->sortable('dashboard.admin.managements.languages.sortable.store')
                        ->run();

        $breadcrumb = [
            ['trans' => 'admin.models.managements'],
            ['trans' => 'admin.models.languages'],
            ['trans' => 'admin.global.sortable', 'route' => 'dashboard.admin.managements.languages.sortable.index']
        ];

        return view('dashboard.admin.managements.languages.index', compact('datatables', 'breadcrumb'));

    }//end of index

    public function data(): object
    {
        $permissions = [
            'status' => permissionAdmin('status-languages'),
            'update' => permissionAdmin('update-languages'),
            'delete' => permissionAdmin('delete-languages'),
        ];

        $language = Language::query();

        return dataTables()->of($language)
                ->addColumn('record_select', 'dashboard.admin.dataTables.record_select')
                ->addColumn('created_at', fn (Language $language) => $language?->created_at?->format('Y-m-d'))
                ->addColumn('admin', fn (Language $language) => $language?->admin?->name)
                ->editColumn('flag', 'dashboard.admin.dataTables.image')
                ->addColumn('actions', function(Language $language) use($permissions) {
                    $routeEdit   = route('dashboard.admin.managements.languages.edit', $language->id);
                    $routeDelete = '';
                    if(!$language->default) {
                        $routeDelete = route('dashboard.admin.managements.languages.destroy', $language->id);
                    }
                    return view('dashboard.admin.dataTables.actions', compact('permissions', 'routeEdit', 'routeDelete'));
                })
                ->addColumn('status', fn(Language $language) => !$language->default ? view('dashboard.admin.dataTables.checkbox', ['models' => $language, 'permissions' => $permissions, 'type' => 'status']) : '')
                ->addColumn('default', fn(Language $language) => view('dashboard.admin.managements.languages.data_tables.check_default', compact('language')))
                ->rawColumns(['record_select', 'actions', 'status', 'flag'])
                ->addIndexColumn()
                ->toJson();

    }//end of data

    public function create(): View
    {
        abort_if(!permissionAdmin('create-languages'), 403);

        $types = LanguageType::array();

        $breadcrumb = [
            ['trans' => 'admin.models.managements'],
            [
                'route' => 'dashboard.admin.managements.languages.index',
                'trans' => 'admin.models.languages',
            ],
            [
                'route' => '#',
                'trans' => 'admin.global.create',
            ]
        ];

        return view('dashboard.admin.managements.languages.create', compact('types', 'breadcrumb'));
        
    }//end of create

    //RedirectResponse
    public function store(LanguageRequest $request): RedirectResponse
    {
        $validated = $request->safe()->except(['flag']);

        if(request()->file('flag')) {

            $validated['flag'] = request()->file('flag')->store('languages', 'public');

        }

        Language::create($validated);

        session()->flash('success', __('admin.messages.added_successfully'));
        return to_route('dashboard.admin.managements.languages.index');

    }//end of store

    public function edit(Language $language): View
    {
        abort_if(!permissionAdmin('update-languages'), 403);

        $types = LanguageType::array();

        $breadcrumb = [
            ['trans' => 'admin.models.managements'],
            [
                'route' => 'dashboard.admin.managements.languages.index',
                'trans' => 'admin.models.languages',
            ],
            [
                'route' => '#',
                'trans' => 'admin.global.edit',
            ]
        ];

        return view('dashboard.admin.managements.languages.edit', compact('language', 'types', 'breadcrumb'));

    }//end of edit

    public function update(LanguageRequest $request, Language $language): RedirectResponse
    {
        $validated = $request->safe()->except(['flag']);

        if(request()->has('flag')) {

            $language->flag != 'flag.png' ? Storage::disk('public')->delete($language->flag) : '';

            $validated['flag'] = request()->file('flag')->store('languages', 'public');

        }

        $language->update($validated);

        session()->flash('success', __('admin.messages.updated_successfully'));
        return to_route('dashboard.admin.managements.languages.index');
        
    }//end of update

    public function destroy(Language $language): Application | Response | ResponseFactory
    {
        if(!$language->default) {

            $language->flag != 'flag.png' ? Storage::disk('public')->delete($language->flag) : '';

            in_array($language->code, ['ar', 'en']) ? '' : $language->delete();
        }

        session()->flash('success', __('admin.messages.deleted_successfully'));
        return response(__('admin.messages.deleted_successfully'));

    }//end of delete

    public function bulkDelete(DeleteRequest $request): Application | Response | ResponseFactory
    {
        $images = Language::whereNot('default', 0)->find(request()->ids ?? [])->whereNotNull('flag')->pluck('flag')->toArray();
        count($images) > 0 ? Storage::disk('public')->delete($images) : '';
        Language::whereNotIn('code', ['ar', 'en'])->whereNot('default', 0)->delete(request()->ids ?? []);

        session()->flash('success', __('admin.messages.deleted_successfully'));
        return response(__('admin.messages.deleted_successfully'));

    }//end of bulkDelete

    public function status(StatusRequest $request): Application | Response | ResponseFactory
    {
        $language = Language::find($request->id);
        $language?->update(['status' => !$language->status]);

        session()->flash('success', __('admin.messages.updated_successfully'));
        return response(__('admin.messages.updated_successfully'));
        
    }//end of status

    public function changeDefault(StatusRequest $request): Application | Response | ResponseFactory
    {
        Language::each(fn ($language) => $language->update(['default' => 0]));
        Language::find($request->id)->update(['default' => 1, 'status' => 1]);

        session()->flash('success', __('admin.messages.updated_successfully'));
        return response(__('admin.messages.updated_successfully'));
        
    }//end of status

    public function sortablePage(): View
    {
        $breadcrumb = [
            ['trans' => 'admin.global.home'],
            ['trans' => 'admin.models.languages', 'route' => 'dashboard.admin.managements.languages.index'],
            ['trans' => 'admin.global.sortable']
        ];

        $languages = Language::pluck('name', 'id')->toArray();

        return view('dashboard.admin.managements.languages.sortable', compact('breadcrumb', 'languages'));

    }//end of sortablePage

    public function storeSortable()
    {        
        foreach (request('order') as $index=>$id) {
            Language::where('id', $id)->update(['index' => $index]);
        }

    }//end of storeSortable

}//end of controller