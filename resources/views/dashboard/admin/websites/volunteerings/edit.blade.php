<x-dashboard.admin.layout.app>

    <x-slot name="title">
        {{ trans('admin.models.websites') . ' - ' . trans('admin.models.volunteerings') }}
    </x-slot>

    <h2>@lang('admin.models.volunteerings')</h2>

    <x-dashboard.admin.layout.includes.breadcrumb :breadcrumb='$breadcrumb'/>

    <form method="post" action="{{ route('dashboard.admin.websites.volunteerings.update', $volunteering->id) }}" enctype="multipart/form-data">
        
        @csrf
        @method('put')

        <div class="row">

            <div class="col-12 col-md-4">

                <div class="tile shadow">

                    @include('dashboard.admin.dataTables.image_privew', ['name' => 'image', 'imagepath' => $volunteering->image_path, 'label' => 'admin.global.image'])

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

                                <x-input.text :required='$loop->first ? true : false' name="title[{{ $language->code }}]" label="admin.global.title" :value="$volunteering->getTranslations('title')[$language->code]" />

                                <x-input.text :required='$loop->first ? true : false' name="job[{{ $language->code }}]" label="admin.models.job" :value="$volunteering->getTranslations('job')[$language->code]"/>

                                <x-input.textarea :required='$loop->first ? true : false' name="description[{{ $language->code }}]" rows="7"label="admin.global.description" :value="$volunteering->getTranslations('description')[$language->code]"/>

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
                                <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="volunteerings-rxperiences-{{ $language->code }}-tab" data-toggle="tab" data-target="#volunteerings-rxperiences-{{ $language->code }}" type="button" role="tab" aria-controls="{{ $language->code }}" aria-selected="{{ $loop->first ? true : false }}">
                                    {{ $language?->name }}
                                </button>
                            </li>
                        @endforeach

                    </ul>

                    <div class="tab-content" id="myTabContent">
                        
                        @foreach(getLanguages() as $language)

                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="volunteerings-rxperiences-{{ $language->code }}" role="tabpanel" aria-labelledby="volunteerings-rxperiences-{{ $language->code }}-tab">
                                
                                @if(!empty(old('rxperiences_title.' . $language->code)))

                                    @foreach(old('rxperiences_title.' . $language->code) as $index=>$item)

                                        @include('dashboard.admin.websites.volunteerings.row', ['code' => $language->code, 'index' => $index, 'uuid' => str()->uuid(), 'old' => true])

                                    @endforeach

                                @else

                                    @if(!empty(json_decode(getSetting('rxperiences'), true)['title']))

                                        @foreach(json_decode(getSetting('rxperiences'), true)['title'] as $index=>$item)

                                            @include('dashboard.admin.websites.volunteerings.row', ['code' => $language->code, 'index' => $index, 'uuid' => str()->uuid(), 'old' => false])

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
            	
            	<div class="tile shadow row">

                    {{--status--}}
                    <x-input.checkbox :required="true" name="status" label="admin.global.status" col="col-md-6" :value='$volunteering->status'/>

            		{{--date--}}
                    <x-input.text :required='true' name="date" label="admin.global.date" type="date" col="col-md-6" :value='$volunteering->date'/>

	                <div class="form-group mt-5">
	                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i>@lang('admin.global.edit')</button>
	                </div>

            	</div>

            </div>

        </div><!-- end of row -->

    </form><!-- end of form -->

    <x-slot name="scripts">
        {{-- @include('dashboard.admin.websites.volunteerings.script') --}}
    </x-slot>

</x-dashboard.admin.layout.app>