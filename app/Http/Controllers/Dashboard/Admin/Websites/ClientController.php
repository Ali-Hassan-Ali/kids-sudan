<?php

namespace App\Http\Controllers\Dashboard\Admin\Websites;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Admin\Websites\Client\ClientRequest;
use App\Http\Requests\Dashboard\Admin\Websites\Client\DeleteRequest;
use App\Http\Requests\Dashboard\Admin\Websites\Client\StatusRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use App\Enums\Admin\WebsitsClientImageType;
use App\Models\Client;

class ClientController extends Controller
{
    public function index(): View
    {
        abort_if(!permissionAdmin('read-clients'), 403);

        $datatables = datatableServices()
                        ->header([
                            'admin.global.name',
                            'admin.global.picture',
                            'admin.models.job',
                            'admin.global.description',
                            'admin.global.status'
                        ])
                        ->checkbox(['status' => 'dashboard.admin.websites.clients.status'])
                        ->route('dashboard.admin.websites.clients.data')
                        ->columns(['name', 'picture', 'job', 'description', 'status'])
                        ->sortable('dashboard.admin.websites.clients.sortable.store')
                        ->run();

        $breadcrumb = [
            ['trans' => 'admin.models.websites'],
            ['trans' => 'admin.models.clients'],
            ['trans' => 'admin.global.sortable', 'route' => 'dashboard.admin.websites.clients.sortable.index']
        ];

        return view('dashboard.admin.websites.clients.index', compact('breadcrumb', 'datatables'));

    }//end of index

    public function data(): object
    {
        $permissions = [
            'status' => permissionAdmin('status-clients'),
            'update' => permissionAdmin('update-clients'),
            'delete' => permissionAdmin('delete-clients'),
        ];

        $client = Client::query();

        return dataTables()->of($client)
                ->addColumn('record_select', 'dashboard.admin.dataTables.record_select')
                ->addColumn('created_at', fn (Client $client) => $client?->created_at?->format('Y-m-d'))
                ->editColumn('name', fn (Client $client) => $client?->name)
                ->editColumn('job', fn (Client $client) => $client?->job)
                ->editColumn('description', fn (Client $client) => str()->limit($client->description, 35))
                ->editColumn('picture', 'dashboard.admin.dataTables.image')
                ->addColumn('actions', function(Client $client) use($permissions) {
                    $routeEdit   = route('dashboard.admin.websites.clients.edit', $client->id);
                    $routeDelete = route('dashboard.admin.websites.clients.destroy', $client->id);
                    return view('dashboard.admin.dataTables.actions', compact('permissions', 'routeEdit', 'routeDelete'));
                })
                ->addColumn('status', fn (Client $client) => view('dashboard.admin.dataTables.checkbox', ['models' => $client, 'permissions' => $permissions, 'type' => 'status']))
                ->rawColumns(['record_select', 'actions', 'status', 'name', 'job', 'description', 'picture'])
                ->addIndexColumn()
                ->toJson();

    }//end of data

    public function create(): View
    {
        abort_if(!permissionAdmin('create-clients'), 403);

        $breadcrumb = [
            [
                'route' => 'dashboard.admin.websites.clients.index',
                'trans' => 'admin.models.clients',
            ],
            [
                'route' => '#',
                'trans' => 'admin.global.create',
            ]
        ];

        return view('dashboard.admin.websites.clients.create', compact('breadcrumb'));

    }//end of create

    public function store(ClientRequest $request): RedirectResponse
    {
        $validated = $request->safe()->except(['picture']);

        if(request()->has('picture')) {

            $validated['picture'] = request()->file('picture')->store('clients', 'public');

        }

        Client::create($validated);

        session()->flash('success', __('admin.messages.added_successfully'));
        return to_route('dashboard.admin.websites.clients.index');
        
    }//end of update

    public function edit(Client $client): View
    {
        abort_if(!permissionAdmin('update-clients'), 403);

        $breadcrumb = [
            [
                'route' => 'dashboard.admin.websites.clients.index',
                'trans' => 'admin.models.clients',
            ],
            [
                'route' => '#',
                'trans' => 'admin.global.edit',
            ]
        ];

        return view('dashboard.admin.websites.clients.edit', compact('client', 'breadcrumb'));

    }//end of edit

    public function update(ClientRequest $request, Client $client): RedirectResponse
    {
        $validated = $request->safe()->except(['picture']);
    
        if(request()->has('picture')) {

            $client->picture != 'default.png' ? Storage::disk('public')->delete($client->picture) : '';

            $validated['picture'] = request()->file('picture')->store('clients', 'public');
        }

        $client->update($validated);

        session()->flash('success', __('admin.messages.updated_successfully'));
        return to_route('dashboard.admin.websites.clients.index');
        
    }//end of update

    public function destroy(Client $client): Application | Response | ResponseFactory
    {
        $client->picture != 'default.png' ? Storage::disk('public')->delete($client->picture) : '';
        $client->delete();

        session()->flash('success', __('admin.messages.deleted_successfully'));
        return response(__('admin.global.deleted_successfully'));

    }//end of delete

    public function bulkDelete(DeleteRequest $request): Application | Response | ResponseFactory
    {
    	$pictures = Client::find(request()->ids ?? [])->pluck('picture')->toArray();
        count($pictures) > 0 ? Storage::disk('public')->delete($pictures) : '';
        Client::destroy(request()->ids ?? []);

        session()->flash('success', __('admin.messages.deleted_successfully'));
        return response(__('admin.messages.deleted_successfully'));

    }//end of bulkDelete

    public function status(StatusRequest $request): Application | Response | ResponseFactory
    {
        $client = Client::find($request->id);
        $client?->update(['status' => !$client->status]);

        session()->flash('success', __('admin.messages.updated_successfully'));
        return response(__('admin.messages.updated_successfully'));
        
    }//end of status

    public function sortablePage(): View
    {
        $breadcrumb = [
            ['trans' => 'admin.models.websites'],
            ['trans' => 'admin.models.clients', 'route' => 'dashboard.admin.websites.clients.index'],
            ['trans' => 'admin.global.sortable']
        ];

        $clients = Client::pluck('name', 'id')->toArray();

        return view('dashboard.admin.websites.clients.sortable', compact('breadcrumb', 'clients'));

    }//end of sortablePage

    public function storeSortable(): bool
    {        
        foreach (request('order') as $index=>$id) {
            Client::where('id', $id)->update(['index' => $index]);
        }

        return true;
        
    }//end of storeSortable

}//end of controller