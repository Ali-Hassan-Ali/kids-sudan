<script type="text/javascript">
	$(document).ready(function () {

		$(document).on('click', '#add-items', () => {

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
										<label class="d-table" style="margin: 2px 16px 8px 16px">${status}</label>
										<input type="hidden" name="faq_status[lang][uuid]" value="0">
	                        			<input class="form-check-input" style="margin-right: 2rem;" id="faq_status[lang][uuid]" type="checkbox" name="faq_status[${code}][]" value="1" checked>
									</div>

									<div class="col-8">
										<x-input.text required="true" name="faq_title[${code}][]" label="${title}"/>
									</div>

									<x-input.textarea required="true" name="faq_description[${code}][]" label="${description}" rows='6' col="col-12"/>

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
									<x-input.text required="true" name="faq_title[${code}][]" label="${title}"/>
								</div>

								<x-input.textarea required="true" name="faq_description[${code}][]" label="${description}" rows='6' col="col-12"/>

							</div>`;

				}
				

			    html.replace(/uuid/g, uuid).replace(/lang/g, code);
			    $('#' + code).append(html);
			});

		});//end of click add-items

		$(document).on('click', '.remove-item', (e) => {
			// e.preventDefault();

			let uuid = $(e.target).data('uuid');

			$('.' + uuid).remove();


		});//end of document ready

	});//end of document ready
</script>