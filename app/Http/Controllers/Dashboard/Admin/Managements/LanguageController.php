<?php

namespace App\Http\Controllers\Dashboard\Admin\Managements;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Admin\Managements\Language\LanguageRequest;
use App\Http\Requests\Dashboard\Admin\Managements\Language\StatusRequest;
use App\Http\Requests\Dashboard\Admin\Managements\Language\DeleteRequest;
use App\Enums\Admin\LanguageType;
use App\Services\DatatableServices;
use App\Models\Language;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;

class LanguageController extends Controller
{
    public function index(): View
    {
        abort_if(!permissionAdmin('read-languages'), 403);

        $datatables = (new DatatableServices())->header(
            [
                'route' => route('dashboard.admin.managements.languages.data'),
                'checkbox' => [
                    'status' => route('dashboard.admin.managements.languages.status'),
                ],
                'header'  => [
                    'admin.global.name',
                    'admin.managements.languages.dir',
                    'admin.managements.languages.flag',
                    'admin.managements.languages.code',
                    'admin.global.default',
                    'admin.global.admin',
                    'admin.global.status',
                ],
                'columns' => [
                    'name'   => 'name',
                    'dir'    => 'dir',
                    'flag'   => 'flag',
                    'code'   => 'code',
                    'default'=> 'default',
                    'admin'  => 'admin',
                    'status' => 'status',
                ]
            ]
        );

        $breadcrumb = [['trans' => 'admin.models.languages']];

        return view('dashboard.admin.managements.languages.index', compact('datatables', 'breadcrumb'));

    }//end of index

    public function data(): object
    {
        $permissions = [
            'status' => 'status-languages',
            'update' => 'update-languages',
            'delete' => 'delete-languages',
        ];

        $language = Language::all();

        return dataTables()->of($language)
            ->addColumn('record_select', 'dashboard.admin.dataTables.record_select')
            ->addColumn('created_at', fn (Language $language) => $language?->created_at?->format('Y-m-d'))
            ->addColumn('admin', fn (Language $language) => $language?->admin?->name)
            ->editColumn('flag', fn(Language $language) => view('dashboard.admin.dataTables.image', ['models' => $language]))
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
            ->rawColumns(['record_select', 'actions', 'status'])
            ->addIndexColumn()
            ->toJson();

    }//end of data

    public function create(): View
    {
        abort_if(!permissionAdmin('create-languages'), 403);

        $types = LanguageType::array();

        $breadcrumb = [
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
        $requestData = request()->except(['flag']);

        if(request()->file('flag')) {

            $requestData['flag'] = request()->file('flag')->store('languages', 'public');

        }

        Language::create($requestData);

        session()->flash('success', __('admin.messages.added_successfully'));
        return redirect()->route('dashboard.admin.managements.languages.index');

    }//end of store

    public function edit(Language $language): View
    {
        abort_if(!permissionAdmin('update-languages'), 403);

        $types = LanguageType::array();

        $breadcrumb = [
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
        $requestData = request()->except(['flag']);

        if(request()->has('flag')) {

            $language->flag ? Storage::disk('public')->delete($language->flag) : '';

            $requestData['flag'] = request()->file('flag')->store('languages', 'public');

        }

        $language->update($requestData);

        session()->flash('success', __('admin.messages.updated_successfully'));
        return redirect()->route('admin.managements.languages.index');
        
    }//end of update

    public function destroy(Language $language): Application | Response | ResponseFactory
    {
        if(!$language->default) {

            $language->flag ? Storage::disk('public')->delete($language->flag) : '';
            $language->delete();
        }

        session()->flash('success', __('admin.messages.deleted_successfully'));
        return response(__('admin.messages.deleted_successfully'));

    }//end of delete

    public function bulkDelete(DeleteRequest $request)
    {
        $images = Language::where('default', 0)->find(request()->ids ?? [])->whereNotNull('flag')->pluck('flag')->toArray();
        count($images) > 0 ? Storage::disk('public')->delete($images) : '';
        Language::destroy(request()->ids ?? []);

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

}//end of controller