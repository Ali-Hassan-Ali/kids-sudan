<script type="text/javascript">
    $(function() {
        
        $(document).on('change', '.select2', (e) => {
            e.preventDefault();

            let id    = $(e.target).attr('id');
            let type  = $(e.target).val();
            let types = @json($imageTypes);

            $.each(types, (index, type) => {

                $('#icon-' + type + '-hidden').attr('hidden', true);
                $('#icon-' + type).attr('name', '');

            });

            $('#icon-hiddenImage').attr('name', '');
            
            $('#icon-' + type + '-hidden').attr('hidden', false); 
            $('#icon-' + type).attr('name', 'icon'); 

            if(type == 'image') {

                $('#icon-hiddenImage').attr('name', 'icon');

                let valueImage = $('#icon-image').val();

                $('#icon-hiddenImage').attr('name', valueImage ? '' : 'icon');
                
            }

        });//end of click remove-item

        $(document).on('change', 'input[type="file"]', (e) => {

            var value = $(e.target).val();

            $('#icon-hiddenImage').attr('name', value ? '' : 'icon');
            $('#icon-image').attr('name', value ? 'icon' : '');

        });//end of chous file
        
    });//min fun
</script>