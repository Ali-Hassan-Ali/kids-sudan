<x-dashboard.admin.layout.app>

    <x-slot name="title">
        {{ trans('admin.models.settings') . ' ' . trans('admin.settings.contact') }}
    </x-slot>

    <h2>@lang('admin.settings.contact')</h2>

    <x-dashboard.admin.layout.includes.breadcrumb :breadcrumb='$breadcrumb'/>

    <form method="post" action="{{ route('dashboard.admin.settings.contact.store') }}" enctype="multipart/form-data">
        @csrf
        @method('post')

        <div class="row">

            <div class="col-12 col-md-12">

                <div class="tile shadow">

                	<div class="row">

                        @php($items = ['phone', 'whatsapp', 'email', 'address', 'address_link'])

                        @foreach($items as $item)

                            {{--$item--}}
                            <x-input.text required="true" :name="'contact_' . $item" :label="'admin.settings.contacts.' . $item" :value="getSetting('contact_' . $item)" col="col-md-6"/>

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