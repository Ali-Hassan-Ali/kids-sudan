@if ($old)
	
	<div class="row {{ $uuid }}">
						
	    <div class="col">
	        <label class="d-block">#</label>
	        <button type="button" class="btn btn-danger remove-item" data-uiid="{{ $uuid }}">
	            <i class="fa fa-trash m-auto"></i>
	        </button>
	    </div>

	    <div class="col-3">
	        <x-input.option required="true" name="skills_type_icon[{{ $code }}][]" 
	        label="admin.global.type" :lists="$imageTypes" 
	        id="{{ $uuid }}-{{ $code }}-skillsTypeIcon" :choose="false" 
	        :invalid="'skills_type_icon.' . $code . '.' . $uuid"
	        :value="old('skills_type_icon.' . $code . '.' . $uuid) ?? ''"/>
	    </div>

	    <div class="col-4">

	    	<input name="skills_icon[lang][]" id="uuid-lang-hiddenImage" hidden>

	        <x-input.text required="true" type="file"
	        			  name="{{ old('skills_type_icon.' . $code . '.' . $uuid) == 'image' ? 'skills_icon['.$code.'][]' : '' }}"
				          label="admin.files.image" type="file" 	
				          hidden="{{ old('skills_type_icon.' . $code . '.' . $uuid) == 'image' ? false : true }}"
				          id="{{ $uuid }}-{{ $code }}-image"
				          :invalid="'skills_icon.' . $code . '.' . $uuid"
			        	  :value="old('skills_icon.' . $code . '.' . $uuid) ?? ''"/>
	        
	        <x-input.text required="true"
	        			  name="{{ old('skills_type_icon.' . $code . '.' . $uuid) == 'font' ? 'skills_icon['.$code.'][]' : '' }}"
				          label="admin.files.font" 
				          hidden="{{ old('skills_type_icon.' . $code . '.' . $uuid) == 'font' ? false : true }}"
				          id="{{ $uuid }}-{{ $code }}-font"
				          :invalid="'skills_icon.' . $code . '.' . $uuid"
			        	  :value="old('skills_icon.' . $code . '.' . $uuid) ?? ''"/>

	        <x-input.text required="true" 
	        			  name="{{ old('skills_type_icon.' . $code . '.' . $uuid) == 'svg' ? 'skills_icon['.$code.'][]' : '' }}"
					      label="admin.files.svg" 
					      hidden="{{ old('skills_type_icon.' . $code . '.' . $uuid) == 'svg' ? false : true }}"
					      id="{{ $uuid }}-{{ $code }}-svg"
					      :invalid="'skills_icon.' . $code . '.' . $uuid"
				          :value="old('skills_icon.' . $code . '.' . $uuid) ?? ''"/>
	        
	    </div>

	    <div class="col-4">
	        <x-input.text required="true" name="skills_title[{{ $code }}][]" label="admin.global.title" id="{{ $uuid }}-{{ $code }}-skillsTitle"
	        :invalid="'skills_title.' . $code . '.' . $uuid"
	        :value="old('skills_title.' . $code . '.' . $uuid) ?? ''"
	        id="{{ $uuid }}-{{ $code }}-skillsTitle"/>
	    </div>
	    
	    <div class="col-12">
	        <x-input.textarea name="skills_description[{{ $code }}][]" label="admin.global.description" rows='6' id="{{ $uuid }}-{{ $code }}-skillsDescription"
	        :invalid="'skills_description.' . $code . '.' . $uuid"
	        :value="old('skills_description.' . $code . '.' . $uuid) ?? ''"
	        id="{{ $uuid }}-{{ $code }}-skillsDescription"/>
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
	        <x-input.option required="true" name="skills_type_icon[{{ $code }}][]" 
	        label="admin.global.type" :lists="$imageTypes" 
	        id="{{ $uuid }}-{{ $code }}-skillsTypeIcon" :choose="false" 
	        :invalid="'skills_type_icon.' . $code . '.' . $uuid"
	        value="{{ getSetting('skills', true)['skills_type_icon'][$index][$code] }}"/>
	    </div>

	    <div class="col-4">
	    	
	    	@if (!empty(getSetting('skills', true)['skills_icon'][$index][$code]) && getSetting('skills', true)['skills_type_icon'][$index][$code] == 'image')
	    		
    			<input name="" id="uuid-lang-hiddenImage" hidden>

	    	@else

    			<input name="" id="uuid-lang-hiddenImage" hidden>

	    	@endif

	        <x-input.text required="true" type="file"
	        			  name="{{ getSetting('skills', true)['skills_type_icon'][$index][$code] == 'image' ? 'skills_icon['.$code.'][]' : '' }}"
				          label="admin.files.image" type="file" 	
				          hidden="{{ getSetting('skills', true)['skills_type_icon'][$index][$code] == 'image' ? false : true }}"
				          id="{{ $uuid }}-{{ $code }}-image"
				          :invalid="'skills_icon.' . $code . '.' . $uuid"
			        	  :value="getSetting('skills', true)['skills_icon'][$index][$code] ?? ''"/>
	        
	        <x-input.text required="true"
	        			  name="{{ getSetting('skills', true)['skills_type_icon'][$index][$code] == 'font' ? 'skills_icon['.$code.'][]' : '' }}"
				          label="admin.files.font" 
				          hidden="{{ getSetting('skills', true)['skills_type_icon'][$index][$code] == 'font' ? false : true }}"
				          id="{{ $uuid }}-{{ $code }}-font"
				          :invalid="'skills_icon.' . $code . '.' . $uuid"
			        	  :value="getSetting('skills', true)['skills_icon'][$index][$code] ?? ''"/>

	        <x-input.text required="true" 
	        			  name="{{ getSetting('skills', true)['skills_type_icon'][$index][$code] == 'svg' ? 'skills_icon['.$code.'][]' : '' }}"
					      label="admin.files.svg" 
					      hidden="{{ getSetting('skills', true)['skills_type_icon'][$index][$code] == 'svg' ? false : true }}"
					      id="{{ $uuid }}-{{ $code }}-svg"
					      :invalid="'skills_icon.' . $code . '.' . $uuid"
				          :value="getSetting('skills', true)['skills_icon'][$index][$code] ?? ''"/>
	        
	    </div>

	    <div class="col-4">
	        <x-input.text required="true" name="skills_title[{{ $code }}][]" label="admin.global.title" id="{{ $uuid }}-{{ $code }}-skillsTitle"
	        :invalid="'skills_title.' . $code . '.' . $uuid"
	        value="{{ getSetting('skills', true)['skills_title'][$index][$code] }}"
	        id="{{ $uuid }}-{{ $code }}-skillsTitle"/>
	    </div>
	    
	    <div class="col-12">
	        <x-input.textarea name="skills_description[{{ $code }}][]" label="admin.global.description" rows='6' id="{{ $uuid }}-{{ $code }}-skillsDescription"
	        :invalid="'skills_description.' . $code . '.' . $uuid"
	        value="{{ getSetting('skills', true)['skills_description'][$index][$code] }}"
	        id="{{ $uuid }}-{{ $code }}-skillsDescription"/>
	    </div>

	</div>

@endif