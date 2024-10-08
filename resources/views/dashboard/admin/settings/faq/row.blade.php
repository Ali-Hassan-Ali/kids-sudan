<div class="row {{ $uuid }}">

	<div class="col-2">
		<label style="margin: 2px 16px 8px 16px">#</label>
		<button type="button" class="btn btn-danger remove-item d-block" data-uuid="{{ $uuid }}">
			<i class="fa fa-trash m-auto"></i>
		</button>
	</div>

	@if ($default)
		<div class="col-2">
			@if(!empty(getMulteSetting('faq', 'status', $index, $code)) && $old == false)
		        <x-input.checkbox :required="true" name="faq_status[{{ $code }}][]" label="admin.global.status" col="col-md-6" :value="getMulteSetting('faq', 'status', $index, $code)" :invalid="'faq_status.' . $code . '.' . $index"/>
			@else
		        <x-input.checkbox :required="true" name="faq_status[{{ $code }}][]" label="admin.global.status" col="col-md-6" :value="old('faq_status.' . $code)[$index] ?? ''" :invalid="'faq_status.' . $code . '.' . $index"/>
			@endif
		</div>
	@endif

	<div class="col-{{ $default ? '8' : '10' }}">
		@if(!empty(getMulteSetting('faq', 'title', $index, $code)) && $old == false)
			<x-input.text required="true" name="faq_title[{{ $code }}][]" label="admin.global.title" :value="getMulteSetting('faq', 'title', $index, $code)" :invalid="'faq_title.' . $code . '.' . $index"/>
		@else
			<x-input.text required="true" name="faq_title[{{ $code }}][]" label="admin.global.title" :value="old('faq_title_' . $code)[$index] ?? ''" :invalid="'faq_title.' . $code . '.' . $index"/>
		@endif
	</div>

</div>
@if(!empty(getMulteSetting('faq', 'description', $index, $code)) && $old == false)
	<x-input.textarea required="true" name="faq_description[{{ $code }}][]" label="admin.global.description" rows='6' col="col-12" :value="getMulteSetting('faq', 'description', $index, $code)" :invalid="'faq_description.' . $code . '.' . $index"/>
@else
	<x-input.textarea required="true" name="faq_description[{{ $code }}][]" label="admin.global.description" rows='6' col="col-12" :value="old('faq_description.' . $code)[$index] ?? ''" :invalid="'faq_description.' . $code . '.' . $index"/>
@endif