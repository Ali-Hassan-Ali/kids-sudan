<x-dashboard.admin.layout.app>

    <x-slot name="title">
        {{ trans('admin.auth.profile') . ' - ' . trans('admin.auth.edit_password') }}
    </x-slot>

    <h2>@lang('admin.auth.edit_password')</h2>

    <x-dashboard.admin.layout.includes.breadcrumb :breadcrumb='$breadcrumb'/>

    <form method="post" action="{{ route('dashboard.admin.auth.accounts.password.update') }}">
        
        @csrf
        @method('post')

        <div class="row">

            <div class="col-12 col-md-12">

                <div class="title shadow">

                	<div class="row">

                        <x-input.text required="true" name="current_password" label="admin.auth.current_password" col="col-md-6" type="password"/>

                        <x-input.text required="true" name="new_password" label="admin.auth.new_password" col="col-md-6" type="password"/>

                        <x-input.text required="true" name="password_confirmation" label="admin.auth.password_confirmation" col="col-md-6" type="password"/>
                        
                	</div>


                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i>@lang('site.create')</button>
                    </div>

                </div><!-- end of title -->

            </div><!-- end of col -->

        </div><!-- end of row -->

    </form><!-- end of form -->

</x-dashboard.admin.layout.app>