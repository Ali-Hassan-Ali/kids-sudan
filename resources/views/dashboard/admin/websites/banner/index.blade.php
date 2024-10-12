<x-dashboard.admin.layout.app>

    <x-slot name="title">
        {{ trans('admin.models.websites') . ' - ' . trans('admin.websites.banner') }}
    </x-slot>

    <h2>@lang('admin.websites.banner')</h2>

    <x-dashboard.admin.layout.includes.breadcrumb :breadcrumb='$breadcrumb'/>

    <form method="post" action="{{ route('dashboard.admin.websites.banner.store') }}" enctype="multipart/form-data">
        @csrf
        @method('post')

        <div class="row">

            <div class="col-12 col-md-4">

                <div class="tile shadow">

                    @include('dashboard.admin.dataTables.image_privew', ['name' => 'banner_picture', 'imagepath' => getImageSetting('banner_picture'), 'label' => 'admin.global.picture'])

                </div><!-- end of title -->

            </div><!-- end of col -->

            <div class="col-12 col-md-4">

                <div class="tile shadow">

                    <ul class="nav nav-tabs" id="myTab" role="tablist">

                        @foreach(getLanguages() as $language)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{ $language->code }}-tab" data-toggle="tab" data-target="#{{ $language->code }}" type="button" role="tab" aria-controls="{{ $language->code }}" aria-selected="{{ $loop->first ? true : false }}">
                                    {{ $language?->name }}
                                </button>
                            </li>
                        @endforeach

                    </ul>

                    <div class="tab-content" id="myTabContent">
                        @foreach(getLanguages() as $language)
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $language->code }}" role="tabpanel" aria-labelledby="{{ $language->code }}-tab">
                                {{--name--}}

                                <x-input.text :required='true' 
                                    name="banner_welcome[{{ $language->code }}]" 
                                    label="admin.websites.banners.welcome" :value="old('banner_welcome.' . $language->code, getTransSetting('banner_welcome', $language->code))" />

                                <x-input.text required="{{ $loop->first ? true : false }}" 
                                    name="banner_hello[{{ $language->code }}]" 
                                    label="admin.websites.banners.hello" :value="old('banner_hello.' . $language->code, getTransSetting('banner_hello', $language->code))"/>

                                <x-input.text required="{{ $loop->first ? true : false }}" 
                                    name="banner_name[{{ $language->code }}]" 
                                    label="admin.websites.banners.name" :value="old('banner_name.' . $language->code, getTransSetting('banner_name', $language->code))"/>

                                <x-input.option required="{{ $loop->first ? true : false }}" 
                                    name="banner_Skills[{{ $language->code }}][]" multiple='true'
                                    label="admin.websites.banners.skills" invalid="{{ 'banner_Skills.' . $language->code }}" 
                                    :lists="getItemTagesSetting('banner_Skills', $language->code)"
                                    :value="getItemTagesSetting('banner_Skills', $language->code, false)"/>

                            </div>
                        @endforeach
                    </div>

                </div><!-- end of title -->

            </div><!-- end of col -->

            <div class="col-12 col-md-4">

                <div class="tile shadow">

                    <ul class="nav nav-tabs" id="myTab" role="tablist">

                        @foreach(getLanguages() as $language)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="banner-rxperiences-{{ $language->code }}-tab" data-toggle="tab" data-target="#banner-rxperiences-{{ $language->code }}" type="button" role="tab" aria-controls="{{ $language->code }}" aria-selected="{{ $loop->first ? true : false }}">
                                    {{ $language?->name }}
                                </button>
                            </li>
                        @endforeach

                    </ul>

                    <div class="tab-content" id="myTabContent">
                        
                        @foreach(getLanguages() as $language)

                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="banner-rxperiences-{{ $language->code }}" role="tabpanel" aria-labelledby="banner-rxperiences-{{ $language->code }}-tab">
                                
                                @if(!empty(old('banner_rxperiences_title.' . $language->code)))

                                    @foreach(old('banner_rxperiences_title.' . $language->code) as $index=>$item)

                                        @include('dashboard.admin.websites.banner.row', ['code' => $language->code, 'index' => $index, 'uuid' => str()->uuid(), 'old' => true])

                                    @endforeach

                                @else

                                    @if(!empty(json_decode(getSetting('banner_rxperiences'), true)['title']))

                                        @foreach(json_decode(getSetting('banner_rxperiences'), true)['title'] as $index=>$item)

                                            @include('dashboard.admin.websites.banner.row', ['code' => $language->code, 'index' => $index, 'uuid' => str()->uuid(), 'old' => false])

                                        @endforeach

                                    @endif

                                @endif

                            </div>

                        @endforeach

                    </div>

                    <div class="form-group mt-3">
                        <button type="submit" id="add-items" class="btn btn-info col-12"><i class="fa fa-plus"></i>@lang('site.add')</button>
                    </div>

                </div><!-- end of title -->

            </div><!-- end of col -->

            <div class="col-12 col-md">
            	
            	<div class="tile shadow">

	                <div class="form-group">
	                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i>@lang('site.create')</button>
	                </div>

            	</div>

            </div>

        </div><!-- end of row -->

    </form><!-- end of form -->

    <x-slot name="scripts">
        @include('dashboard.admin.websites.banner.script')
    </x-slot>

</x-dashboard.admin.layout.app>