<x-dashboard.admin.layout.app>
    
    <x-slot name="title">
        {{ trans('admin.global.edit') . ' - ' . trans('admin.models.services') }}
    </x-slot>

    <h2>@lang('admin.models.services')</h2>

    <x-dashboard.admin.layout.includes.breadcrumb :breadcrumb='$breadcrumb'/>

    <form method="post" action="{{ route('dashboard.admin.websites.services.update', $service->id) }}" enctype="multipart/form-data">
        
        @csrf
        @method('put')

        <div class="col-12 col-md">

            <div class="row">

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

                                <x-input.text required="{{ $loop->first ? true : false }}" name="title[{{ $language->code }}]" label="admin.global.title" :value="$service->getTranslations('title')[$language->code] ?? ''"/>

                                <x-input.textarea required="{{ $loop->first ? true : false }}" name="short_description[{{ $language->code }}]" label="admin.global.description" :value="$service->getTranslations('short_description')[$language->code] ?? ''"/>

                            </div>
                        @endforeach
                    </div>

                </div><!-- end of tile -->

                <div class="tile shadow">

                    <div class="row">

                        <x-input.checkbox :required="true" name="status" label="admin.global.status" :value="$service->status"/>

                        <x-input.option required="true" name="icon_type" label="admin.global.type" :value='$service->icon_type' :lists="$imageTypes" :choose="false"/>

                        <input name="icon" id="icon-hiddenImage" name="old('icon_type', $service->icon_type) == 'image' ? 'icon' : ''" hidden>

                        <x-input.text required="true" :name='old("icon_type", $service->icon_type) == "image" ? "icon" : ""' label="admin.files.image" :value='$service->icon' :hidden='old("icon_type", $service->icon_type) == "image" ? false : true' id="icon-image" type="file"/>
                        <x-input.text required="true" :name='old("icon_type", $service->icon_type) == "font" ? "icon" : ""' label="admin.files.font" :value='$service->icon' :hidden='old("icon_type", $service->icon_type) == "font" ? false : true' id="icon-font"/>
                        <x-input.text required="true" :name='old("icon_type", $service->icon_type) == "svg" ? "icon" : ""' label="admin.files.svg" :value='$service->icon' :hidden='old("icon_type", $service->icon_type) == "svg" ? false : true' id="icon-svg"/>
                        
                    </div>{{-- row --}}

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i>@lang('admin.global.create')</button>
                    </div>

                </div>{{-- shadow --}}

            </div>{{-- row --}}

        </div>{{-- col-12 col-md --}}

    </form><!-- end of form -->

    <x-slot name="scripts">
        @include('dashboard.admin.websites.services.script', ['imageTypes' => $imageTypes])
    </x-slot>

</x-dashboard.admin.layout.app>