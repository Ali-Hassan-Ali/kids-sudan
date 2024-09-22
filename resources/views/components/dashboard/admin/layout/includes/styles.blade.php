<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
          integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
          
<!-- Main CSS-->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/css/main-teal.css') }}" media="all">

<!-- Font-icon css-->
<link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/css/font-awesome.min.css') }}">

@if (app()->getLocale() == 'ar')

    {{--google font--}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cairo:400,600&display=swap">

    <style>
        body {
            font-family: 'cairo', 'sans-serif';
        }
        .breadcrumb-item + .breadcrumb-item {
            padding-left: 0.5rem;
        }
        .breadcrumb-item+.breadcrumb-item::before {
            float: right;
        }
        .breadcrumb-item + .breadcrumb-item::before {
            padding-left: .5rem;
        }

        div.dataTables_wrapper div.dataTables_paginate ul.pagination {
            margin: 2px 2px;
        }
    </style>
@endif

{{--jquery--}}
<script src="{{ asset('admin_assets/js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('admin_assets/js/jquery-ui.js') }}"></script>

{{--noty--}}
<link rel="stylesheet" href="{{ asset('admin_assets/plugins/noty/noty.css') }}">
<script src="{{ asset('admin_assets/plugins/noty/noty.min.js') }}"></script>

{{--datatable--}}
<script type="text/javascript" src="{{ asset('admin_assets/plugins/jquery.dataTables/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('admin_assets/plugins/dataTables.bootstrap/dataTables.bootstrap.min.js') }}"></script>

{{--magnific-popup--}}
<link rel="stylesheet" href="{{ asset('admin_assets/plugins/magnific-popup/magnific-popup.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.2.0/css/rowGroup.dataTables.min.css">

<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/rowgroup/1.2.0/js/dataTables.rowGroup.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.19/api/sum().js"></script>

<link rel="stylesheet" href="{{ asset('admin_assets/css/custom.css')}}">

<style>
    @if (request()->segment(2) == 'reports')
        .dataTables_filter, .dataTables_info {
        display: none;
    }

    @endif
    .has-error .select2-selection {
        border-color: rgb(185, 74, 72) !important;
    }

    .app-sidebar::-webkit-scrollbar {
        width: 15px;
        height: 8px;
        background-color: #aaa; /* or add it to the track */
    }

    .bg-hover {
        background-color: #dee2e6;
    }

    .bg-danger-datatable {
        background-color: #e7081e33;
    }

    .table-bordered {
        border: 3px solid #dee2e6 !important;
    }

    td, tr, th {
        text-align: center;
    }

    label, th, li {
        text-transform: capitalize;
    }

    .loader {
        -webkit-animation: spin 2s linear infinite; /* Safari */
        animation: spin 2s linear infinite;
    }

    .loader-sm {
        border: 5px solid #f3f3f3;
        border-radius: 50%;
        border-top: 5px solid #009688;
        width: 40px;
        height: 40px;
    }

    .loader-md {
        border: 8px solid #f3f3f3;
        border-radius: 50%;
        border-top: 8px solid #009688;
        width: 90px;
        height: 90px;
    }

    /* Safari */
    @-webkit-keyframes spin {
        0% {
            -webkit-transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
        }
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
</style>

{{ $style ?? '' }}