@if ($old)
	
	<div class="row {{ $uuid }}">
						
	    <div class="col">
	        <label class="d-block">#</label>
	        <button type="button" class="btn btn-danger remove-item" data-uiid="{{ $uuid }}">
	            <i class="fa fa-trash m-auto"></i>
	        </button>
	    </div>

	    <div class="col-3">
	        <x-input.option required="true" name="tools_type_icon[{{ $code }}][]" 
	        label="admin.global.type" :lists="$imageTypes" 
	        id="{{ $uuid }}-{{ $code }}-toolsTypeIcon" :choose="false" 
	        :invalid="'tools_type_icon.' . $code . '.' . $uuid"
	        :value="old('tools_type_icon.' . $code . '.' . $uuid) ?? ''"/>
	    </div>

	    <div class="col-4">

	    	<input name="tools_icon[lang][]" id="uuid-lang-hiddenImage" hidden>

	        <x-input.text required="true" type="file"
	        			  name="{{ old('tools_type_icon.' . $code . '.' . $uuid) == 'image' ? 'tools_icon['.$code.'][]' : '' }}"
				          label="admin.files.image" type="file" 	
				          hidden="{{ old('tools_type_icon.' . $code . '.' . $uuid) == 'image' ? false : true }}"
				          id="{{ $uuid }}-{{ $code }}-image"
				          :invalid="'tools_icon.' . $code . '.' . $uuid"
			        	  :value="old('tools_icon.' . $code . '.' . $uuid) ?? ''"/>
	        
	        <x-input.text required="true"
	        			  name="{{ old('tools_type_icon.' . $code . '.' . $uuid) == 'font' ? 'tools_icon['.$code.'][]' : '' }}"
				          label="admin.files.font" 
				          hidden="{{ old('tools_type_icon.' . $code . '.' . $uuid) == 'font' ? false : true }}"
				          id="{{ $uuid }}-{{ $code }}-font"
				          :invalid="'tools_icon.' . $code . '.' . $uuid"
			        	  :value="old('tools_icon.' . $code . '.' . $uuid) ?? ''"/>

	        <x-input.text required="true" 
	        			  name="{{ old('tools_type_icon.' . $code . '.' . $uuid) == 'svg' ? 'tools_icon['.$code.'][]' : '' }}"
					      label="admin.files.svg" 
					      hidden="{{ old('tools_type_icon.' . $code . '.' . $uuid) == 'svg' ? false : true }}"
					      id="{{ $uuid }}-{{ $code }}-svg"
					      :invalid="'tools_icon.' . $code . '.' . $uuid"
				          :value="old('tools_icon.' . $code . '.' . $uuid) ?? ''"/>
	        
	    </div>

	    <div class="col-4">
	        <x-input.text required="true" name="tools_title[{{ $code }}][]" label="admin.global.title" id="{{ $uuid }}-{{ $code }}-toolsTitle"
	        :invalid="'tools_title.' . $code . '.' . $uuid"
	        :value="old('tools_title.' . $code . '.' . $uuid) ?? ''"
	        id="{{ $uuid }}-{{ $code }}-toolsTitle"/>
	    </div>
	    
	    <div class="col-12">
	        <x-input.textarea name="tools_description[{{ $code }}][]" label="admin.global.description" rows='6' id="{{ $uuid }}-{{ $code }}-toolsDescription"
	        :invalid="'tools_description.' . $code . '.' . $uuid"
	        :value="old('tools_description.' . $code . '.' . $uuid) ?? ''"
	        id="{{ $uuid }}-{{ $code }}-toolsDescription"/>
	    </div>

	</div>

@else

	<div class="row {{ $uuid }}">
						
	    <div class="col">
	        <label class="d-block">#</label>
	        <button type="button" class="btn btn-danger remove-item" data-uiid="{{ $uuid }}">
	            <i class="fa fa-trash m-auto"></i>
	        </button>
	    </div>

	    <div class="col-3">
	        <x-input.option required="true" name="tools_type_icon[{{ $code }}][]" 
	        label="admin.global.type" :lists="$imageTypes" 
	        id="{{ $uuid }}-{{ $code }}-toolsTypeIcon" :choose="false" 
	        :invalid="'tools_type_icon.' . $code . '.' . $uuid"
	        value="{{ getSetting('tools', true)['tools_type_icon'][$index][$code] }}"/>
	    </div>

	    <div class="col-4">
	    	
	    	@if (!empty(getSetting('tools', true)['tools_icon'][$index][$code]) && getSetting('tools', true)['tools_type_icon'][$index][$code] == 'image')
	    		
    			<input name="" id="uuid-lang-hiddenImage" hidden>

	    	@else

    			<input name="" id="uuid-lang-hiddenImage" hidden>

	    	@endif

	        <x-input.text required="true" type="file"
	        			  name="{{ getSetting('tools', true)['tools_type_icon'][$index][$code] == 'image' ? 'tools_icon['.$code.'][]' : '' }}"
				          label="admin.files.image" type="file" 	
				          hidden="{{ getSetting('tools', true)['tools_type_icon'][$index][$code] == 'image' ? false : true }}"
				          id="{{ $uuid }}-{{ $code }}-image"
				          :invalid="'tools_icon.' . $code . '.' . $uuid"
			        	  :value="getSetting('tools', true)['tools_icon'][$index][$code] ?? ''"/>
	        
	        <x-input.text required="true"
	        			  name="{{ getSetting('tools', true)['tools_type_icon'][$index][$code] == 'font' ? 'tools_icon['.$code.'][]' : '' }}"
				          label="admin.files.font" 
				          hidden="{{ getSetting('tools', true)['tools_type_icon'][$index][$code] == 'font' ? false : true }}"
				          id="{{ $uuid }}-{{ $code }}-font"
				          :invalid="'tools_icon.' . $code . '.' . $uuid"
			        	  :value="getSetting('tools', true)['tools_icon'][$index][$code] ?? ''"/>

	        <x-input.text required="true" 
	        			  name="{{ getSetting('tools', true)['tools_type_icon'][$index][$code] == 'svg' ? 'tools_icon['.$code.'][]' : '' }}"
					      label="admin.files.svg" 
					      hidden="{{ getSetting('tools', true)['tools_type_icon'][$index][$code] == 'svg' ? false : true }}"
					      id="{{ $uuid }}-{{ $code }}-svg"
					      :invalid="'tools_icon.' . $code . '.' . $uuid"
				          :value="getSetting('tools', true)['tools_icon'][$index][$code] ?? ''"/>
	        
	    </div>

	    <div class="col-4">
	        <x-input.text required="true" name="tools_title[{{ $code }}][]" label="admin.global.title" id="{{ $uuid }}-{{ $code }}-toolsTitle"
	        :invalid="'tools_title.' . $code . '.' . $uuid"
	        value="{{ getSetting('tools', true)['tools_title'][$index][$code] }}"
	        id="{{ $uuid }}-{{ $code }}-toolsTitle"/>
	    </div>
	    
	    <div class="col-12">
	        <x-input.textarea name="tools_description[{{ $code }}][]" label="admin.global.description" rows='6' id="{{ $uuid }}-{{ $code }}-toolsDescription"
	        :invalid="'tools_description.' . $code . '.' . $uuid"
	        value="{{ getSetting('tools', true)['tools_description'][$index][$code] }}"
	        id="{{ $uuid }}-{{ $code }}-toolsDescription"/>
	    </div>

	</div>

@endif