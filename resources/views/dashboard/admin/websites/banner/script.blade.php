<script type="text/javascript">
	$(document).ready(function () {

		$(document).on('click', '#add-items', function (e) {
			e.preventDefault();

			let languages = @json(getLanguages()->pluck('code')->toArray());
			let uuid      = $.now();

			$.each(languages, function(index, code) {
				
				let html = `<div class="row ${uuid}">
								
								<div class="col-2">

									<label class="d-block">#</label>
									<button type="button" class="btn btn-danger remove-item" data-uuid="${uuid}">
										<i class="fa fa-trash m-auto"></i>
									</button>
    
								</div>
								
								<div class="col-4">
									<x-input.text required="true" name="banner_rxperiences_number[${code}][]" label="admin.global.number" type="number"/>
								</div>

								<div class="col-6">
									<x-input.text required="true" name="banner_rxperiences_title[${code}][]" label="admin.global.title"/>
								</div>

							</div>`;

			    $('#banner-rxperiences-' + code).append(html);
			});

		});//end of click add-items

		$(document).on('click', '.remove-item', function (e) {
			e.preventDefault();

			let uuid = $(this).data('uuid');

			$('.' + uuid).remove();


		});//end of document ready

	});//end of document ready
</script>