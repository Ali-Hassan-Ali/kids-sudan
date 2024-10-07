<div class="row uuid">
					
    <div class="col">
        <label class="d-block">#</label>
        <button type="button" class="btn btn-danger remove-item" data-uiid="uuid">
            <i class="fa fa-trash m-auto"></i>
        </button>
    </div>

    <div class="col-3">
        <x-input.option required="true" name="tools_type_icon[lang][]" label="admin.global.type" :lists="$imageTypes" id="uuid-lang-toolsTypeIcon" :choose="false"/>
    </div>

    <div class="col-4">

        <input name="tools_icon[lang][]" id="uuid-lang-hiddenImage" hidden>

        <x-input.text required="true" name="tools_icon[lang][]" label="admin.files.image" type="file" :hidden="false" id="uuid-lang-image"/>
        <x-input.text required="true" label="admin.files.font" :hidden="true" id="uuid-lang-font"/>
        <x-input.text required="true" label="admin.files.svg" :hidden="true" id="uuid-lang-svg"/>
        
    </div>

    <div class="col-4">
        <x-input.text required="true" name="tools_title[lang][]" label="admin.global.title" id="uuid-lang-toolsTitle"/>
    </div>

    <div class="col-12">
        <x-input.textarea name="tools_description[lang][]" label="admin.global.description" rows='6' id="uuid-lang-toolsDescription"/>
    </div>

</div>