<x-dashboard.admin.layout.app>

    <x-slot name="title">
        {{ trans('admin.models.websites') . ' - ' . trans('admin.models.volunteerings') }}
    </x-slot>

    <h2>@lang('admin.models.volunteerings')</h2>

    <x-dashboard.admin.layout.includes.breadcrumb :breadcrumb='$breadcrumb'/>

    <div class="row">

        <div class="col-md-12">

            <div class="tile shadow">

                <div class="row mb-2">

                    <div class="col-md-12">

                        <ul id="sortable">
                            <div class="bs-component">
                                <ul class="list-group">
                    	           @foreach ($volunteerings as $id=>$title)
                                        <li class="list-group-item mb-3 text-white bg-primary d-flex justify-content-between align-items-start"  data-id="{{ $id }}">
                                            {{ $title }}
                                            <span class="badge bg-primary rounded-pill">{{ $loop->index }}</span>
                                        </li>
                    	           @endforeach
                                </ul>
                            </div>
						</ul>

                    </div>

                </div><!-- end of row -->

            </div><!-- end of title -->

        </div><!-- end of col -->

    </div><!-- end of row -->

    <x-slot name="scripts">

        <script type="text/javascript">
        	$(function() {
        		
        		let route = "{{ route('dashboard.admin.websites.volunteerings.sortable.store') }}";
		    	
		    	$('#sortable').sortable({
		            items: 'li',
                    cursor: 'move',
		            update: function(event, ui) {

		                var sortedIDs = $(this).sortable('toArray', {attribute: 'data-id'});

		                $.post(route, {order: sortedIDs}, (response) => {});
		            }

		        }).disableSelection();
		  	});
        </script>

    </x-slot>

</x-dashboard.admin.layout.app>