<x-admin.layout.app>

    <x-slot name="title">
        {{ trans('admin.global.create') . ' - ' . trans('menu.cupons') }}
    </x-slot>

    <div>
        <h2>@lang('menu.cupons')</h2>
    </div>

    <ul class="breadcrumb mt-2">
        <li class="breadcrumb-item"><a class="back-page" href="{{ route('admin.index') }}">@lang('admin.global.home')</a></li>
        <li class="breadcrumb-item">@lang('menu.products')</li>
        <li class="breadcrumb-item"><a class="back-page" href="{{ route('admin.products.cupons.index') }}">@lang('menu.cupons')</a></li>
        <li class="breadcrumb-item">@lang('admin.global.create')</li>
    </ul>

    <form method="post" action="{{ route('admin.products.cupons.store') }}" enctype="multipart/form-data">
        @csrf
        @method('post')

        <div class="col-12 col-md-12">

            <div class="tile shadow">

                <div class="row">

                    {{--code--}}
                    <x-input.text required="true" name="code" label="admin.global.code" col="col-md-6"/>

                    {{--price--}}
                    <x-input.text type="number" required="true" name="price" label="admin.global.price" col="col-md-6"/>

                    {{--start_date--}}
                    <x-input.text type="date" required="true" name="start_date" label="admin.products.cupons.start_date" col="col-md-6"/>

                    {{--end_date--}}
                    <x-input.text type="date" required="true" name="end_date" label="admin.products.cupons.end_date" col="col-md-6"/>

                    {{--status--}}
                    <x-input.checkbox :required="true" name="status" label="admin.global.status" col="col-md"/>

                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i>@lang('admin.global.create')</button>
                </div>

            </div><!-- end of tile -->

        </div><!-- end of col -->

    </form><!-- end of form -->

</x-admin.layout.app>