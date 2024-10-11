<!-- Essential javascripts for application to work-->
<script src="{{ asset('admin_assets/js/popper.min.js') }}"></script>
<script src="{{ asset('admin_assets/js/bootstrap.min.js') }}"></script>

{{-- font-awesome --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js"
        integrity="sha512-6PM0qYu5KExuNcKt5bURAoT6KCThUmHRewN3zUFNaoI6Di7XJPTMoT6K0nsagZKk2OB4L7E3q1uQKHNHd4stIQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

{{--select2.min.js--}}
<script src="{{ asset('admin_assets/plugins/select2/select2.min.js') }}"></script>

{{--main.js 2--}}
<script src="{{ asset('admin_assets/js/main.js') }}"></script>

{{--ckeditor--}}
<script src="{{ asset('admin_assets/plugins/ckeditor/ckeditor.js') }}"></script>

{{--magnific-popup--}}
<script src="{{ asset('admin_assets/plugins/magnific-popup/jquery.magnific-popup.min.js') }}"></script>

{{--apex chart--}}
{{-- <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> --}}

{{--custom--}}
<script src="{{ asset('admin_assets/js/custom/index.js?updated=20') }}" type="text/javascript"></script>
<script src="{{ asset('admin_assets/js/custom/roles.js?updated=20') }}" type="text/javascript"></script>
{{--jquery number--}}
{{-- <script src="{{ asset('admin_assets/js/query.number.min.js') }}"></script> --}}
{{-- <script src="{{ asset('admin_assets/js/custom/ajax.js?updated=20') }}" type="text/javascript"></script> --}}

<script>

    $(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('change', '.record__select', function () {
            $(this).closest('tr').toggleClass('bg-hover');
        });

    });//end of ready

    $(document).ready(function () {

        //delete
        $(document).on('click', '.delete, #bulk-delete', function (e) {

            var that = $(this)

            e.preventDefault();

            var n = new Noty({
                text: "@lang('admin.messages.confirm_delete')",
                type: "alert",
                killer: true,
                buttons: [
                    Noty.button("@lang('admin.global.yes')", 'btn btn-success mr-2', function () {
                        let url = that.closest('form').attr('action');
                        let data = new FormData(that.closest('form').get(0));

                        let loadingText = '<i class="fa fa-circle-o-notch fa-spin"></i>';
                        let originalText = that.html();
                        that.html(loadingText);

                        n.close();

                        $.ajax({
                            url: url,
                            data: data,
                            method: 'post',
                            processData: false,
                            contentType: false,
                            cache: false,
                            success: function (response) {

                                $("#record__select-all").prop("checked", false);

                                $('.datatable').DataTable().ajax.reload();

                                new Noty({
                                    layout: 'topRight',
                                    type: 'alert',
                                    text: response,
                                    killer: true,
                                    timeout: 2000,
                                }).show();

                                that.html(originalText);
                            },
                            error: function (response) {
                                data = response.responseJSON.message;
                                new Noty({
                                    layout: 'topRight',
                                    type: 'error',
                                    text: data + '😥',
                                    killer: true,
                                    timeout: 4000,
                                }).show();
                                that.html(originalText);
                            }

                        });//end of ajax call

                    }),

                    Noty.button("@lang('admin.global.no')", 'btn btn-danger mr-2', function () {
                        n.close();
                    })
                ]
            });

            n.show();

        });//end of delete

    });//end of document ready

    CKEDITOR.config.language = "{{ app()->getLocale() }}";

    //select 2
    $('.select2').select2({
        'width': '100%',
        'tags': true,
    });

    $('.select2-tags-false').select2({
        'width': '100%',
        'tags': false,
        'minimumResultsForSearch': Infinity
    });

</script>