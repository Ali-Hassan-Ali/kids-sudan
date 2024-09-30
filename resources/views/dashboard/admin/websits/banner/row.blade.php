<div class="row {{ $uuid }}">

	<div class="col-2">
		<label class="d-block">#</label>
		<button type="button" class="btn btn-danger remove-item" data-uuid="{{ $uuid }}">
			<i class="fa fa-trash m-auto"></i>
		</button>
	</div>

	<div class="col-4">
		@if(!empty(getMulteSetting('banner_rxperiences', 'number', $index, $code)) && $old == false)
			<x-input.text required="true" name="banner_rxperiences_number_{{ $code }}[]" label="admin.global.number" :value="getMulteSetting('banner_rxperiences', 'number', $index, $code)" :invalid="'banner_rxperiences_number_' . $code . '.' . $index"/>
		@else
			<x-input.text required="true" name="banner_rxperiences_number_{{ $code }}[]" label="admin.global.number" :value="old('banner_rxperiences_number_' . $code)[$index] ?? ''" :invalid="'banner_rxperiences_number_' . $code . '.' . $index" type="number"/>
		@endif
	</div>
	
	<div class="col-6">
		@if(!empty(getMulteSetting('banner_rxperiences', 'title', $index, $code)) && $old == false)
			<x-input.text required="true" name="banner_rxperiences_title_{{ $code }}[]" label="admin.global.title" :value="getMulteSetting('banner_rxperiences', 'title', $index, $code)" :invalid="'banner_rxperiences_title_' . $code . '.' . $index"/>
		@else
			<x-input.text required="true" name="banner_rxperiences_title_{{ $code }}[]" label="admin.global.title" :value="old('banner_rxperiences_title_' . $code)[$index] ?? ''" :invalid="'banner_rxperiences_title_' . $code . '.' . $index"/>
		@endif
	</div>

</div>