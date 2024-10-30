<li class="row">
	
	<div class="col-1">
		<label class="d-block m-auto">#</label>
		<button type="button" class="btn btn-danger remove-item">
			<i class="fa fa-trash m-auto"></i>
		</button>
	</div>

	<div class="col-3">
		@php($items = ['svg' => 'svg', 'font' => 'font'])
		<x-input.option required="true" name="social_types[]" label="admin.global.type" :lists="$items" :index='$index' :choose='false' value="{{ isset($item['type']) ? $item['type'] : old('social_types.' . $index) }}"/>
	</div>

	<div class="col-3">
		<x-input.text required="true" name="social_icons[]" label="admin.global.icon" :index='$index' value="{{ isset($item['icon']) ? $item['icon'] : old('social_icons.' . $index) }}"/>
	</div>

	<div class="col-4">
		<x-input.text required="true" name="social_links[]" label="admin.global.links" :index='$index' value="{{ isset($item['link']) ? $item['link'] : old('social_links.' . $index) }}"/>
	</div>

	<div class="col-1">
		<x-input.checkbox name="social_status[]" label="admin.global.status" :index='$index'  value="{{ isset($item['status']) ? $item['status'] : old('social_status.' . $index) }}"/>
	</div>

</li>