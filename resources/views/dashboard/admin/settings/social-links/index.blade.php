<x-dashboard.admin.layout.app>

    <x-slot name="title">
        {{ trans('admin.models.settings') . ' ' . trans('admin.settings.media') }}
    </x-slot>

    <x-slot name="styles">
        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
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

                        <div id="item-links">

                            @if (!empty(old('social_types')))
                                
                                @foreach (old('social_types') as $index=>$item)

                                    @include('dashboard.admin.settings.social-links.row', ['index' => $index])
                                    
                                @endforeach
                                
                            @elseif(!empty(getSetting('social_links')))

                                @foreach(getSetting('social_links', true) as $item)
                                    
                                    @include('dashboard.admin.settings.social-links.row', ['index' => str()->uuid(), 'item' => $item])
                                                                
                                @endforeach

                            @endif
                            
                        </div>   

                    </div>

                    <div class="form-group mt-3">
                        <button type="submit" id="add-items" class="btn btn-info col-12"><i class="fa fa-plus"></i>@lang('admin.global.add')</button>
                    </div>

                </div><!-- end of tile -->

            </div><!-- end of col -->

            <div class="col-12 col-md-12">

                <div class="tile shadow">

                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> @lang('admin.global.save')</button>
                    </div>

                </div><!-- end of tile -->

            </div><!-- end of col -->

        </div><!-- end of row -->

    </form><!-- end of form -->

    <x-slot name="scripts">
        @include('dashboard.admin.settings.social-links.script')
    </x-slot>

</x-dashboard.admin.layout.app>