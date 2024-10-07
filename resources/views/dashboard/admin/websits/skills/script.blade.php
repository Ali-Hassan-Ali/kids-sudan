<script type="text/javascript">

    $(document).ready(function () {

        $(document).on('click', '#add-items', function (e) {
            e.preventDefault();

            let languages = @json(getLanguages()->pluck('code')->toArray());
            let uuid      = $.now(); // Generates a unique timestamp-based ID
            let htmlRow   = `{!! view('dashboard.admin.websits.skills.mew_row', ['imageTypes' => $imageTypes])->render() !!}`;
 
            $.each(languages, (index, code) => {
                
                let newRow = htmlRow.replace(/uuid/g, uuid).replace(/lang/g, code);

                $('#' + code).append(newRow);

            });

        });//end of click add-items

        // Event listener for removing items
        $(document).on('click', '.remove-item', function(e) {
            e.preventDefault();

            let uuid = $(this).data('uiid');

            $('.' + uuid).remove();

        });//end of click remove-item

        $(document).on('change', '.select2', (e) => {
            e.preventDefault();

            let id    = $(e.target).attr('id');
            let type  = $(e.target).val();
            let item  = id.split('-');
            let uuid  = item[0];
            let lang  = item[1];
            let types = @json($imageTypes);

            $.each(types, (index, type) => {

                $('#' + uuid + '-' + lang + '-' + type + '-hidden').attr('hidden', true).attr('name', '');

            });
            
            let name = `skills_icon[${lang}][]`;
            
            $('#' + uuid + '-' + lang + '-' + type + '-hidden').attr('hidden', false); 
            $('#' + uuid + '-' + lang + '-' + type).attr('name', name); 

            if(type == 'image') {

                if($('#' + uuid + '-' + lang + '-image').val()) {

                    $('#' + uuid + '-' + lang + '-hiddenImage').attr('name', '');

                } else {

                    $('#' + uuid + '-' + lang + '-hiddenImage').attr('name', name);

                }
                
            }

        });//end of click remove-item

        $(document).on('change', 'input[type="file"]', (e) => {
            e.preventDefault();

            value = $(e.target).val();

            let id    = $(e.target).attr('id');
            let item  = id.split('-');
            let uuid  = item[0];
            let lang  = item[1];
            let name = `skills_icon[${lang}][]`;

            if (value) {

                $('#' + uuid + '-' + lang + '-hiddenImage').attr('name', '');

            } else {

                $('#' + uuid + '-' + lang + '-hiddenImage').attr('name', name);

            }


        });

    });//end of document ready

</script>
