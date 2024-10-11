<x-dashboard.admin.layout.app>
    
    <x-slot name="title">
        {{ trans('admin.global.create') . ' - ' . trans('admin.models.skills') }}
    </x-slot>

    <h2>@lang('admin.models.skills')</h2>

    <x-dashboard.admin.layout.includes.breadcrumb :breadcrumb='$breadcrumb'/>

    <form method="post" action="{{ route('dashboard.admin.websits.skills.store') }}" enctype="multipart/form-data">
        
        @csrf
        @method('post')

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

                                <x-input.text required="{{ $loop->first ? true : false }}" name="title[{{ $language->code }}]" label="admin.global.title"/>

                                <x-input.textarea required="{{ $loop->first ? true : false }}" name="description[{{ $language->code }}]" label="admin.global.description"/>

                            </div>
                        @endforeach
                    </div>

                </div><!-- end of tile -->

                <div class="tile shadow">

                    <div class="row">

                        <x-input.checkbox :required="true" name="status" label="admin.global.status"/>

                        <x-input.option required="true" name="icon_type" label="admin.global.type" :lists="$imageTypes" :choose="false"/>

                        @php($typeIcon = in_array(old("icon_type"), $imageTypes) ? old("icon_type") : 'image')

                        <input name="icon" id="icon-hiddenImage" name="$typeIcon == 'image' ? 'icon' : ''" hidden>
                        

                        <x-input.text required="true" :name='$typeIcon == "image" ? "icon" : ""' label="admin.files.image" :hidden='$typeIcon == "image" ? false : true' id="icon-image" type="file"/>
                        <x-input.text required="true" :name='old("icon_type") == "font" ? "icon" : ""' label="admin.files.font" :hidden='old("icon_type") == "font" ? false : true' id="icon-font"/>
                        <x-input.text required="true" :name='old("icon_type") == "svg" ? "icon" : ""' label="admin.files.svg" :hidden='old("icon_type") == "svg" ? false : true' id="icon-svg"/>
                        
                    </div>{{-- row --}}

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i>@lang('admin.global.create')</button>
                    </div>

                </div>{{-- shadow --}}

            </div>{{-- row --}}

        </div>{{-- col-12 col-md --}}

    </form><!-- end of form -->

    <x-slot name="scripts">

        <script type="text/javascript">
            $(function() {
                
                $(document).on('change', '.select2', (e) => {
                    e.preventDefault();

                    let id    = $(e.target).attr('id');
                    let type  = $(e.target).val();
                    let types = @json($imageTypes);

                    $.each(types, (index, type) => {

                        $('#icon-' + type + '-hidden').attr('hidden', true);
                        $('#icon-' + type).attr('name', '');

                    });

                    $('#icon-hiddenImage').attr('name', '');
                    
                    $('#icon-' + type + '-hidden').attr('hidden', false); 
                    $('#icon-' + type).attr('name', 'icon'); 

                    if(type == 'image') {

                        $('#icon-hiddenImage').attr('name', 'icon');

                        let valueImage = $('#icon-image').val();

                        $('#icon-hiddenImage').attr('name', valueImage ? '' : 'icon');
                        
                    }

                });//end of click remove-item

                $(document).on('change', 'input[type="file"]', (e) => {

                    var value = $(e.target).val();

                    $('#icon-hiddenImage').attr('name', value ? '' : 'icon');
                    $('#icon-image').attr('name', value ? 'icon' : '');

                });//end of chous file
                
            });//min fun
        </script>

    </x-slot>

</x-dashboard.admin.layout.app>