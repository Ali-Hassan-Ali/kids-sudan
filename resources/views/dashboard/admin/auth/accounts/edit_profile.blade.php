<x-dashboard.admin.layout.app>

    <x-slot name="title">
        {{ trans('admin.models.profiles') . ' - ' . trans('admin.auth.edit_profile') }}
    </x-slot>

    <h2>@lang('admin.auth.edit_profile')</h2>

    <x-dashboard.admin.layout.includes.breadcrumb :breadcrumb='$breadcrumb'/>

    <form method="post" action="{{ route('dashboard.admin.auth.accounts.profile.update', $admin->id) }}" enctype="multipart/form-data">
        @csrf
        @method('put')

        <div class="row">

            <div class="col-12 col-md-4">

                <div class="title shadow">

                    @include('dashboard.admin.dataTables.image_privew', ['name' => 'image', 'imagepath' => $admin->image_path, 'label' => 'admin.global.image'])

                </div><!-- end of tile -->

            </div><!-- end of col -->

            <div class="col-12 col-md-8">

                <div class="tile shadow">

                    <div class="row">

    					{{--name--}}
                        <x-input.text required="true" name="name" label="admin.global.name" col="col-md-6" :value="$admin->name"/>

                        {{--email--}}
                        <x-input.text required="true" name="email" label="admin.global.email" col="col-md-6" type="email" :value="$admin->email"/>

                        {{--status--}}
                        <x-input.checkbox :required="true" name="status" label="admin.global.status" :value="$admin->status" col="col-md-6" :disabled='true'/>

                    </div>{{-- row --}}

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i>@lang('admin.global.edit')</button>
                    </div>

                </div><!-- end of tile -->

            </div><!-- end of col -->

        </div><!-- end of row -->

    </form><!-- end of form -->

</x-dashboard.admin.layout.app>