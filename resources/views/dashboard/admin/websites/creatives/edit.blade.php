<x-dashboard.admin.layout.app>
    
    <x-slot name="title">
        {{ trans('admin.global.edit') . ' - ' . trans('admin.models.creatives') }}
    </x-slot>

    <h2>@lang('admin.models.creatives')</h2>

    <x-dashboard.admin.layout.includes.breadcrumb :breadcrumb='$breadcrumb'/>

    <form method="post" action="{{ route('dashboard.admin.websites.creatives.update', $creative->id) }}" enctype="multipart/form-data">
        @csrf
        @method('put')

        <div class="row">

            <div class="col-12 col-md-4">

                <div class="tite shadow">

                    @include('dashboard.admin.dataTables.image_privew', ['name' => 'image', 'label' => 'admin.global.image', 'required' => true, 'imagepath' => $creative->image_path])

                </div><!-- end of title -->

            </div><!-- end of col -->

            <div class="col-12 col-md-8">

                <div class="tile shadow">

                    <div class="row">

    					{{--name--}}
                        <x-input.text required="true" name="name" label="admin.global.name" col="col-md-6" :value="$creative->name"/>

                        {{-- date --}}
                        <x-input.text required="true" name="date" label="admin.global.date" col="col-md-6" type="date" :value="$creative->date"/>

                        @foreach ([0,1] as $index=>$link)

	                        {{-- date --}}
	                        <x-input.text required="true" name="links[]" :index='$index' label="admin.global.links" col="col-md-6" :value="json_decode($creative->links)[$index] ?? ''"/>
                        	
                        @endforeach

                        {{--status--}}
                        <x-input.checkbox :required="true" name="status" label="admin.global.status" col="col-md-6" :value="$creative->status"/>

                    </div>

                    <div class="form-group mt-5">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i>@lang('admin.global.create')</button>
                    </div>

                </div><!-- end of tile -->

            </div><!-- end of col -->

        </div><!-- end of row -->

    </form><!-- end of form -->

</x-dashboard.admin.layout.app>