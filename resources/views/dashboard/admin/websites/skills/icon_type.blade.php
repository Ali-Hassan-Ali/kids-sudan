@if ($icon_type == 'image')
	
	<img src="{{ $image_path }}" width="70">

@elseif($icon_type == 'font')

	<i class="{{ $icon }} fa-4x" style="color: red;"></i>
	
@elseif($icon_type == 'svg')
	
	{!! $icon !!}

@endif