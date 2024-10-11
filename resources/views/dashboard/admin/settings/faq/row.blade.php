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
		        <x-input.checkbox name="faq_status[{{ $code }}][]" label="admin.global.status" col="col-md-6" id="faq-status-{{ $uuid }}-{{ $code }}" :index='$index' :value="getMulteSetting('faq', 'status', $index, $code)"/>
			@else
		        <x-input.checkbox name="faq_status[{{ $code }}][]" label="admin.global.status" col="col-md-6" id="faq-status-{{ $uuid }}-{{ $code }}" :index='$index' :value="old('faq_status.' . $code)[$index] ?? ''"/>
			@endif
		</div>
	@endif

	<div class="col-{{ $default ? '8' : '10' }}">
		@if(!empty(getMulteSetting('faq', 'title', $index, $code)) && $old == false)
			<x-input.text required="true" name="faq_title[{{ $code }}][]" label="admin.global.title" :index='$index' id="faq-title-{{ $uuid }}-{{ $code }}" :value="getMulteSetting('faq', 'title', $index, $code)"/>
		@else
			<x-input.text required="true" name="faq_title[{{ $code }}][]" label="admin.global.title" :index='$index' id="faq-title-{{ $uuid }}-{{ $code }}" :value="old('faq_title.' . $code)[$index] ?? ''"/>
		@endif
	</div>
	
	@if(!empty(getMulteSetting('faq', 'description', $index, $code)) && $old == false)
		<x-input.textarea required="true" name="faq_description[{{ $code }}][]" label="admin.global.description" rows='6' col="col-12" :index='$index' id="faq-description-${{ $uuid }}-{{ $code }}" :value="getMulteSetting('faq', 'description', $index, $code)"/>
	@else
		<x-input.textarea required="true" name="faq_description[{{ $code }}][]" label="admin.global.description" rows='6' col="col-12" :index='$index' id="faq-description-{{ $uuid }}-{{ $code }}" :value="old('faq_description.' . $code)[$index] ?? ''"/>
	@endif

</div>