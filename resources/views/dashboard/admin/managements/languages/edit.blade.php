<x-dashboard.admin.layout.app>

    <x-slot name="title">
        {{ trans('admin.global.edit') . ' - ' . trans('menu.languages') }}
    </x-slot>

    <h2>@lang('menu.languages')</h2>

    <x-dashboard.admin.layout.includes.breadcrumb :breadcrumb='$breadcrumb'/>

    <form method="post" action="{{ route('dashboard.admin.managements.languages.update', $language->id) }}" enctype="multipart/form-data">
        @csrf
        @method('put')

        <div class="row">

            <div class="col-12 col-md-4">

                <div class="tile shadow">

                    @include('dashboard.admin.dataTables.image_privew', ['name' => 'flag', 'imagepath' => $language->image_path, 'label' => 'admin.managements.languages.flag'])

                </div><!-- end of tile -->

            </div><!-- end of col -->

            <div class="col-12 col-md-8">

                <div class="tile shadow row">

					{{--name--}}
                    <x-input.text required="true" name="name" label="admin.global.name" col="col-md-6" :value="$language->name"/>

                    {{--code--}}
                    <x-input.text required="true" name="code" label="admin.managements.languages.code" col="col-md-6" :value="$language->code"/>

                    {{--type--}}
                    <x-input.option required="true" name="dir" label="admin.managements.languages.dir" :lists="$types" :value="$language->dir" col="col-md-6"/>

                    {{--status--}}
                    <x-input.checkbox :required="true" name="status" label="admin.global.status" :value="$language->status" col="col-md-6"/>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i>@lang('admin.global.edit')</button>
                    </div>

                </div><!-- end of tile -->

            </div><!-- end of col -->

        </div><!-- end of row -->

    </form><!-- end of form -->

</x-dashboard.admin.layout.app>