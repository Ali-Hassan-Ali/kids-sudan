<script type="text/javascript">
	$(document).ready(function () {

		$(document).on('click', '#add-items', function (e) {
			e.preventDefault();

			html = `{!! view('dashboard.admin.settings.social-links.row', ['index' => 'index', 'item' => []])->render() !!}`;

			newHtml = html.replace(/index/g, $.now());

			$(this).closest('.row').find('#item-links').append(newHtml);

			$('.select2').select2({'width': '100%', 'minimumResultsForSearch': Infinity});

		});//end of click add-items

		$(document).on('click', '.remove-item', function (e) {
			e.preventDefault();

			$(this).closest('.row').remove();

		});//end of document ready

		$(document).on('change', '.select2', function (e) {
			e.preventDefault();

			// alert($(this).val());

		});//end of document ready


		$(document).on('change keyup', 'input[name="social_icons[]"]', (e) => {
			e.preventDefault();

            const uuid 		  = $(e.target).attr('id').replace(/social-icons-/g, '');
			const iconType    = $('#social-types-' + uuid).val();
            const value       = $(e.target).val();
            const htmlElement = $(e.target).closest('.form-group').find('.text-danger');

            // Function to update the HTML based on icon type
            const updateIconDisplay = (iconValue) => {

                if (iconType === 'font') {
                    
                    htmlElement.html(`<i class="${iconValue} icon icon--dark"></i>`);

                } else if (iconType === 'svg') {

                	newiconValue = $(iconValue).attr('width', '45').attr('height', '45');

                    htmlElement.html(newiconValue);
                }

            };

            setTimeout(() => {

                updateIconDisplay(value);

            }, 1000); // 1000 milliseconds = 1 second

		});//end of document ready

		$('#item-links').sortable({
            items: 'li',
            cursor: 'move',
        }).disableSelection();

	});//end of document ready
</script>