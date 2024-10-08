<x-dashboard.admin.layout.app>
    
    <x-slot name="title">
        {{ trans('admin.global.create') . ' - ' . trans('admin.models.creatives') }}
    </x-slot>

    <h2>@lang('admin.models.creatives')</h2>

    <x-dashboard.admin.layout.includes.breadcrumb :breadcrumb='$breadcrumb'/>

    <form method="post" action="{{ route('dashboard.admin.websits.creatives.store') }}" enctype="multipart/form-data">
        @csrf
        @method('post')

        <div class="row">

            <div class="col-12 col-md-4">

                <div class="title shadow">

                    @include('dashboard.admin.dataTables.image_privew', ['name' => 'image', 'label' => 'admin.global.image', 'required' => true])

                </div><!-- end of title -->

            </div><!-- end of col -->

            <div class="col-12 col-md-8">

                <div class="tile shadow">

                    <div class="row">

    					{{--name--}}
                        <x-input.text required="true" name="name" label="admin.global.name" col="col-md-6"/>

                        {{-- date --}}
                        <x-input.text required="true" name="date" label="admin.global.date" col="col-md-6" type="date"/>

                        @foreach ([0,1] as $index=>$link)

	                        {{-- date --}}
	                        <x-input.text required="true" name="links[]" label="admin.global.links" col="col-md-6" 
	                        :value="old('links.' . $index)"
	                        invalid="{{ 'links.' . $index }}"/>
                        	
                        @endforeach

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