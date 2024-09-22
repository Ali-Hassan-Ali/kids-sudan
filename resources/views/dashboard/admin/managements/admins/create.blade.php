<x-dashboard.admin.layout.app>
    
    <x-slot name="title">
        {{ trans('admin.global.create') . ' - ' . trans('admin.models.admins') }}
    </x-slot>

    <h2>@lang('admin.models.admins')</h2>

    <x-dashboard.admin.layout.includes.breadcrumb :breadcrumb='$breadcrumb'/>

    <form method="post" action="{{ route('dashboard.admin.managements.admins.store') }}" enctype="multipart/form-data">
        @csrf
        @method('post')

        <div class="row">

            <div class="col-12 col-md-4">

                <div class="title shadow">

                    @include('dashboard.admin.dataTables.image_privew', ['name' => 'image', 'label' => 'admin.global.image', 'required' => true])

                </div><!-- end of tile -->

            </div><!-- end of col -->

            <div class="col-12 col-md-8">

                <div class="tile shadow">

                    <div class="row">

    					{{--name--}}
                        <x-input.text required="true" name="name" label="admin.global.name" col="col-md-6"/>

                        {{--email--}}
                        <x-input.text required="true" name="email" label="admin.global.email" col="col-md-6" type="email"/>

                        {{-- password --}}
                        <x-input.text required="true" name="password" label="admin.auth.password" col="col-md-6" type="password"/>

                        {{-- password_confirmation --}}
                        <x-input.text required="true" name="password_confirmation" label="admin.auth.password_confirmation" col="col-md-6" type="password"/>

                        {{--roles--}}
                        <x-input.option required="true" name="roles[]" invalid="" label="menu.roles" :lists="$roles" :multiple="true" col="col-md-6" :value="old('roles')"/>

                        {{--status--}}
                        <x-input.checkbox :required="true" name="status" label="admin.global.status" col="col-md-6"/>

                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i>@lang('admin.global.create')</button>
                    </div>

                </div><!-- end of tile -->


            </div><!-- end of col -->

        </div><!-- end of row -->

    </form><!-- end of form -->

</x-dashboard.admin.layout.app>