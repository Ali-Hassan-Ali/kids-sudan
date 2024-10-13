<x-dashboard.admin.layout.app>
    
    <x-slot name="title">
        {{ trans('admin.global.edit') . ' - ' . trans('admin.models.faqs') }}
    </x-slot>

    <h2>@lang('admin.models.faqs')</h2>

    <x-dashboard.admin.layout.includes.breadcrumb :breadcrumb='$breadcrumb'/>

    <form method="post" action="{{ route('dashboard.admin.websites.faqs.update', $faq->id) }}" enctype="multipart/form-data">
        
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

                                <x-input.text required="{{ $loop->first ? true : false }}" name="question[{{ $language->code }}]" label="admin.websites.faqs.question" :value="$faq->getTranslations('question')[$language->code] ?? ''"/>

                                <x-input.textarea required="{{ $loop->first ? true : false }}" name="answer[{{ $language->code }}]" label="admin.websites.faqs.answer" rows="8" :value="$faq->getTranslations('answer')[$language->code] ?? ''"/>

                            </div>
                        @endforeach
                    </div>

                </div><!-- end of tile -->

                <div class="tile shadow">

                    <div class="row">

                            <x-input.checkbox :required="true" name="status" label="admin.global.status" :value="$faq->status"/>
                        
                    </div>{{-- row --}}

                    <div class="form-group mt-5">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i>@lang('admin.global.create')</button>
                    </div>

                </div>{{-- shadow --}}

            </div>{{-- row --}}

        </div>{{-- col-12 col-md --}}

    </form><!-- end of form -->

</x-dashboard.admin.layout.app>