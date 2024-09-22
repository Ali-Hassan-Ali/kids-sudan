<x-dashboard.admin.layout.app>
    
    <x-slot name="title">
        {{ trans('admin.global.create') . ' - ' . trans('admin.models.roles') }}
    </x-slot>

    <h2>@lang('admin.models.roles')</h2>

    <x-dashboard.admin.layout.includes.breadcrumb :breadcrumb='$breadcrumb'/>

    <form method="post" action="{{ route('dashboard.admin.managements.roles.store') }}" enctype="multipart/form-data">
        @csrf
        @method('post')

        <div class="row">

            <div class="col-md-12">

                <div class="tile shadow">

                    <form method="post" action="{{ route('dashboard.admin.managements.roles.store') }}">
                        @csrf
                        @method('post')

                        {{--name--}}
                        <x-input.text required="true" name="name" label="admin.global.name"/>

                        <h5>@lang('admin.models.permissions') <span class="text-danger">*</span></h5>

                        <table class="table">
                            <thead>
                            <tr>
                                <th>@lang('admin.global.model')</th>
                                <th>@lang('menu.permissions')</th>
                            </tr>
                            </thead>

                            <tbody>
                                @foreach($permissions as $name=>$permission)
                                    <tr>
                                        <td>@lang($name)</td>
                                        <td>
                                            <div class="animated-checkbox mx-2 form-check form-switch" style="display:inline-block;">
                                                <label class="m-0">
                                                    <input type="checkbox" value="{{ $name }}" name="all[{{ $name }}]" class="all-roles form-check-input" {{ old('all.' . $name) == $name ? 'checked' : '' }}>
                                                    <span class="label-text">@lang('admin.global.all')</span>
                                                </label>
                                            </div>

                                            @foreach ($permission as $items)
                                                <div class="animated-checkbox mx-2 form-check form-switch" style="display:inline-block;">
                                                    <label class="m-0">
                                                        <input type="checkbox" value="{{ $items['name'] }}" name="permissions[{{ $items['name'] }}]" class="role form-check-input" {{ old('permissions.' . $items['name']) == $items['name'] ? 'checked' : '' }}>
                                                        <span class="label-text">{{ $items['name'] }}</span>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table><!-- end of table -->

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i>@lang('admin.global.create')</button>
                        </div>

                    </form><!-- end of form -->

                </div><!-- end of tile -->

            </div><!-- end of col -->

        </div><!-- end of row -->

    </form><!-- end of form -->

</x-dashboard.admin.layout.app>
