<?php

namespace App\Http\Controllers\Dashboard\Admin\Websites;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Admin\Websites\Faqs\FaqRequest;
use App\Http\Requests\Dashboard\Admin\Websites\Faqs\DeleteRequest;
use App\Http\Requests\Dashboard\Admin\Websites\Faqs\StatusRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use App\Enums\Admin\WebsitsFaqImageType;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index(): View
    {
        abort_if(!permissionAdmin('read-faqs'), 403);

        $datatables = datatableServices()
                        ->header([
                            'admin.websites.faqs.question',
                            'admin.websites.faqs.answer',
                            'admin.global.status'
                        ])
                        ->checkbox(['status' => 'dashboard.admin.websites.faqs.status'])
                        ->route('dashboard.admin.websites.faqs.data')
                        ->columns(['question', 'answer', 'status'])
                        ->sortable('dashboard.admin.websites.faqs.sortable.store')
                        ->run();

        $breadcrumb = [
            ['trans' => 'admin.models.websites'],
            ['trans' => 'admin.models.faqs'],
            ['trans' => 'admin.global.sortable', 'route' => 'dashboard.admin.websites.faqs.sortable.index']
        ];

        return view('dashboard.admin.websites.faqs.index', compact('breadcrumb', 'datatables'));

    }//end of index

    public function data(): object
    {
        $permissions = [
            'status' => permissionAdmin('status-faqs'),
            'update' => permissionAdmin('update-faqs'),
            'delete' => permissionAdmin('delete-faqs'),
        ];

        $faq = Faq::query();

        return dataTables()->of($faq)
                ->addColumn('record_select', 'dashboard.admin.dataTables.record_select')
                ->editColumn('question', fn (Faq $faq) => str()->limit($faq->question, 35))
                ->editColumn('answer', fn (Faq $faq) => str()->limit($faq->answer, 45))
                ->addColumn('actions', fn(Faq $faq) => datatableAction($faq, $permissions)->buttons()->build())
                ->addColumn('status', fn (Faq $faq) => view('dashboard.admin.dataTables.checkbox', ['models' => $faq, 'permissions' => $permissions, 'type' => 'status']))
                ->rawColumns(['record_select', 'actions', 'status', 'question', 'answer'])
                ->addIndexColumn()
                ->toJson();

    }//end of data

    public function create(): View
    {
        abort_if(!permissionAdmin('create-faqs'), 403);

        $breadcrumb = [
            [
                'route' => 'dashboard.admin.websites.faqs.index',
                'trans' => 'admin.models.faqs',
            ],
            [
                'route' => '#',
                'trans' => 'admin.global.create',
            ]
        ];

        return view('dashboard.admin.websites.faqs.create', compact('breadcrumb'));

    }//end of create

    public function store(FaqRequest $request): RedirectResponse
    {
        Faq::create($request->validated());

        session()->flash('success', __('admin.messages.added_successfully'));
        return to_route('dashboard.admin.websites.faqs.index');
        
    }//end of update

    public function edit(Faq $faq): View
    {
        abort_if(!permissionAdmin('update-faqs'), 403);

        $breadcrumb = [
            [
                'route' => 'dashboard.admin.websites.faqs.index',
                'trans' => 'admin.models.faqs',
            ],
            [
                'route' => '#',
                'trans' => 'admin.global.edit',
            ]
        ];

        return view('dashboard.admin.websites.faqs.edit', compact('faq', 'breadcrumb'));

    }//end of edit

    public function update(FaqRequest $request, Faq $faq): RedirectResponse
    {
        $faq->update($request->validated());

        session()->flash('success', __('admin.messages.updated_successfully'));
        return to_route('dashboard.admin.websites.faqs.index');
        
    }//end of update

    public function destroy(Faq $faq): Application | Response | ResponseFactory
    {
        $faq->delete();

        session()->flash('success', __('admin.messages.deleted_successfully'));
        return response(__('admin.global.deleted_successfully'));

    }//end of delete

    public function bulkDelete(DeleteRequest $request): Application | Response | ResponseFactory
    {
        Faq::destroy(request()->ids ?? []);

        session()->flash('success', __('admin.messages.deleted_successfully'));
        return response(__('admin.messages.deleted_successfully'));

    }//end of bulkDelete

    public function status(StatusRequest $request): Application | Response | ResponseFactory
    {
        $faq = Faq::find($request->id);
        $faq?->update(['status' => !$faq->status]);

        session()->flash('success', __('admin.messages.updated_successfully'));
        return response(__('admin.messages.updated_successfully'));
        
    }//end of status

    public function sortablePage(): View
    {
        $breadcrumb = [
            ['trans' => 'admin.models.websites'],
            ['trans' => 'admin.models.faqs', 'route' => 'dashboard.admin.websites.faqs.index'],
            ['trans' => 'admin.global.sortable']
        ];

        $faqs = Faq::pluck('question', 'id')->toArray();

        return view('dashboard.admin.websites.faqs.sortable', compact('breadcrumb', 'faqs'));

    }//end of sortablePage

    public function storeSortable(): bool
    {        
        foreach (request('order') as $index=>$id) {
            Faq::where('id', $id)->update(['index' => $index]);
        }

        return true;
        
    }//end of storeSortable

}//end of controller