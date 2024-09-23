<x-dashboard.admin.layout.app>

    <x-slot name="title">
        {{ trans('admin.models.settings') . ' ' . trans('admin.settings.media') }}
    </x-slot>

    <h2>@lang('admin.settings.media')</h2>

    <x-dashboard.admin.layout.includes.breadcrumb :breadcrumb='$breadcrumb'/>

    <form method="post" action="{{ route('dashboard.admin.settings.media.store') }}" enctype="multipart/form-data">
        @csrf
        @method('post')

        <div class="row">

            <div class="col-12 col-md-12">

                <div class="tile shadow">

                	<div class="row">

                        @php($items = ['facebook', 'twitter', 'instagram', 'video_links', 'google_play', 'apple_store'])

                        @foreach($items as $item)

    	                	{{--phone--}}
    	                    <x-input.text required="true" :name="'media_' . $item" :label="'admin.settings.medias.' . $item" :value="getSetting('media_' . $item)" col="col-md-6"/>

                        @endforeach

                	</div>


                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i>@lang('site.create')</button>
                    </div>

                </div><!-- end of tile -->

            </div><!-- end of col -->

        </div><!-- end of row -->

    </form><!-- end of form -->

</x-dashboard.admin.layout.app>