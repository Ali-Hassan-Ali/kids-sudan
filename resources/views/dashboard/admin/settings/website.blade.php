<x-dashboard.admin.layout.app>

    <x-slot name="title">
        {{ trans('admin.models.settings') . ' - ' . trans('admin.settings.websit') }}
    </x-slot>

    <h2>@lang('admin.settings.websit')</h2>

    <x-dashboard.admin.layout.includes.breadcrumb :breadcrumb='$breadcrumb'/>

    <form method="post" action="{{ route('dashboard.admin.settings.websit.store') }}" enctype="multipart/form-data">
        @csrf
        @method('post')

        <div class="row">

            <div class="col-12 col-md-4">

                <div class="tile shadow">

                    @include('dashboard.admin.dataTables.image_privew', ['name' => 'websit_logo', 'imagepath' => getImageSetting('websit_logo'), 'label' => 'admin.global.logo'])

                </div><!-- end of tile -->

            </div><!-- end of col -->

            <div class="col-12 col-md-8">

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

                                <x-input.text required="{{ $loop->first ? true : false }}" 
                                    name="websit_title[{{ $language->code }}]" 
                                    label="admin.global.title" :value="old('websit_title.' . $language->code, getTransSetting('websit_title', $language->code))"
                                    invalid="{{ 'websit_title.' . $language->code }}" />

                                <x-input.option required="{{ $loop->first ? true : false }}" 
                                    name="websit_keywords[{{ $language->code }}]" multiple='true'
                                    label="admin.settings.keywords" :value="old('websit_keywords.' . $language->code, getItemTagesSetting('websit_keywords', $language->code)->toArray())"
                                    invalid="{{ 'websit_keywords.' . $language->code }}" />

                                <x-input.textarea required="{{ $loop->first ? true : false }}" 
                                    name="websit_description[{{ $language->code }}]" 
                                    label="admin.global.description" :value="old('websit_description.' . $language->code, getTransSetting('websit_description', $language->code))"
                                    invalid="{{ 'websit_description.' . $language->code }}" />

                            </div>
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