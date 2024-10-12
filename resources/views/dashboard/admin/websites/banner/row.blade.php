<div class="row {{ $index }}">

	<div class="col-2">
		<label class="d-block">#</label>
		<button type="button" class="btn btn-danger remove-item" data-uuid="{{ $index }}">
			<i class="fa fa-trash m-auto"></i>
		</button>
	</div>

	<div class="col-4">
		@if(!empty(getMulteSetting('banner_rxperiences', 'number', $index, $code)) && $old == false)
			<x-input.text required="true" name="banner_rxperiences_number[{{ $code }}][]" label="admin.global.number" :index="$uuid" type="number" :value="getMulteSetting('banner_rxperiences', 'number', $index, $code)"/>
		@else
			<x-input.text required="true" name="banner_rxperiences_number[{{ $code }}][]" label="admin.global.number" :index="$index" type="number"/>
		@endif
	</div>
	
	<div class="col-6">
		@if(!empty(getMulteSetting('banner_rxperiences', 'title', $index, $code)) && $old == false)
			<x-input.text required="true" name="banner_rxperiences_title[{{ $code }}][]" label="admin.global.title" :index="$uuid" :value="getMulteSetting('banner_rxperiences', 'title', $index, $code)"/>
		@else
			<x-input.text required="true" name="banner_rxperiences_title[{{ $code }}][]" label="admin.global.title" :index="$index"/>
		@endif
	</div>

</div>