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

        $(document).on('change keyup', 'input[name="icon"]', (e) => {

            const iconType    = $('#icon-type').val();
            const value       = $(e.target).val();
            const htmlElement = $(e.target).closest('.form-group').find('.text-danger');

            // Function to update the HTML based on icon type
            const updateIconDisplay = (iconValue) => {

                if (iconType === 'font') {
                    
                    htmlElement.html(`<i class="${iconValue} icon icon--dark"></i>`);

                } else if (iconType === 'svg') {

                    htmlElement.html(iconValue); // Assuming value is an SVG or its representation
                }

            };

            // Use a single timeout for both conditions if needed
            setTimeout(() => {

                updateIconDisplay(value);

            }, 1000); // 1000 milliseconds = 1 second

        });//end of event change keyup

        @php
            $iconType  = old("icon_type", !empty($tool?->icon_type)  ? $tool?->icon_type : '');
            $iconValue = old("icon",!empty($tool?->icon)  ? $tool?->icon : '');
        @endphp

        $(document).ready(function() {

            const textDangerElement = $('input[name="icon"]').closest('.form-group').find('.text-danger');
            
            if ("{{ $iconType }}" === "font") {
                // For font icons
                textDangerElement.html(`<i class="${{!! json_encode($iconValue) !!}} icon icon--dark"></i>`);

            } else if ("{{ $iconType }}" === "svg") {
                // For SVG icons
                textDangerElement.html(`{!! $iconValue !!}`);

            }//end of if

        });//end of document ready
        
    });//min fun
</script>