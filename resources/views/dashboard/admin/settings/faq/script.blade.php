<script type="text/javascript">
	$(document).ready(function () {

		$(document).on('click', '#add-items', (e) => {
			e.preventDefault();

			let languages   = @json(getLanguages()->pluck('code','default')->toArray());
			let uuid        = $.now();
			let title       = "{{ trans('admin.global.title') }}";
			let description = "{{ trans('admin.global.description') }}";
			let status 		= "{{ trans('admin.global.status') }}";

			$.each(languages, function(LangDefault , code) {

				if (LangDefault == '1') {

					html = `<div class="row ${uuid}">

									<div class="col-2">
										<label style="margin: 2px 16px 8px 16px">#</label>
										<button type="button" class="btn btn-danger remove-item d-block" data-uuid="${uuid}">
											<i class="fa fa-trash m-auto"></i>
										</button>
									</div>

									<div class="col-2">
										<x-input.checkbox name="faq_status[${code}][]" id="faq-status-${uuid}-${code}" label="admin.global.status"/>
									</div>

									<div class="col-8">
										<x-input.text required="true" name="faq_title[${code}][]" id="faq-title-${uuid}-${code}" label="${title}"/>
									</div>

									<x-input.textarea required="true" name="faq_description[${code}][]" id="faq-description-${uuid}-${code}" label="${description}" rows='6' col="col-12"/>

								</div>`;

				} else {

					html = `<div class="row ${uuid}">

								<div class="col-2">
									<label style="margin: 2px 16px 8px 16px">#</label>
									<button type="button" class="btn btn-danger remove-item d-block" data-uuid="${uuid}">
										<i class="fa fa-trash m-auto"></i>
									</button>
								</div>

								<div class="col-9">
									<x-input.text required="true" name="faq_title[${code}][]" id="faq-title-${uuid}-${code}" label="${title}"/>
								</div>

								<x-input.textarea required="true" name="faq_description[${code}][]" id="faq-description-${uuid}-${code}" label="${description}" rows='6' col="col-12"/>

							</div>`;

				}//end of if

			    $('#' + code).append(html);

			    $('#faq-status-' + uuid + '-' + code).attr('name', '');
			    $('#faq-status-' + uuid + '-' + code + '-status-hidden').val('1');

			});

		});//end of click add-items

		$(document).on('click', '.remove-item', (e) => {

            let uuid = $(e.target).data('uuid');

            $('.' + uuid).remove();

        });//end of click remove-item

		$(document).on('click', '.form-check-input', (e) => {

			let id      = $(e.target).attr('id');
			let checked = e.target.checked;
			let input   = $('#' + id + '-status-hidden');

			checked ? input.val(1) : input.val(0);

		});//end of on click check

		$.each($('.form-check-input'),  (index, item) => {

            id = $(item).attr('id');

            $('#' + id + '-status-hidden').val($(item).prop('checked') ? 1 : 0);

            $(item).attr('name', '');

        });//end of each

	});//end of document ready
</script>