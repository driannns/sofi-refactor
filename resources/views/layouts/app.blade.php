<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{config('app.name')}}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 4.1.1 -->
    {{--  <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">  --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('css/coreui.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@icon/coreui-icons-free@1.0.1-alpha.1/coreui-icons-free.css">

     <!-- PRO version // if you have PRO version licence than remove comment and use it. -->
    {{--<link rel="stylesheet" href="https://unpkg.com/@coreui/icons@1.0.0/css/brand.min.css">--}}
    {{--<link rel="stylesheet" href="https://unpkg.com/@coreui/icons@1.0.0/css/flag.min.css">--}}
     <!-- PRO version -->

    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.3.0/css/flag-icon.min.css">

    <!-- datatables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">


    <!-- select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <style>
      .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 33px
      }
      .select2-container .select2-selection--single {
        height: 36px;
      }

      .table thead{
        background-color:#20a8d8!important;
        color:white;
      }

      .table thead tr{
        white-space: nowrap;
      }

      .dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background: #20a8d8!important;
        color: white !important;
        border: 1px solid white !important;
        margin: 10px 0px 10px 0px;
      }

      .card-header, .breadcrumb{
        font-weight: bold;
      }

      .search{
        display:inline;
        width: 75%;
      }

      .custom-file-label{
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
      }

      .nav-link{
        font-size: 12px;
      }

      td{
        font-size: 12px;
      }

      .active{
        color:black;
      }
    </style>
    @stack('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{--  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>  --}}
</head>
<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
@include('layouts.navbar')

<div class="app-body">
    @include('layouts.sidebar')
    <main class="main">
        @yield('content')
    </main>
</div>
<footer class="app-footer">
    <div>
        <a href="#">Sidang Online - </a>
        <span>&copy; {{ date('Y') }} Fakultas Rekayasa Industri</span>
    </div>
    <div class="ml-auto">
        <span>Powered by</span>
        <a href="#" data-toggle="tooltip" title="Dulur.dev - sepasang pria sevisi yang memutuskan mengabdikan diri kepada FRI dan Tel-U" >Dulur Dev</a>
    </div>
</footer>
</body>
<!-- jQuery 3.1.1 -->

<script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{asset('js/coreui.min.js')}}"></script>
<script src="{{asset('dataTables.min.js')}}"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script src="{{asset('select2.min.js')}}"></script>
@include('sweetalert::alert')
<script type="text/javascript">
    $(document).ready( function () {
        $('.datatable').DataTable({
            pageLength: 15,
        });
        $('.select2').select2();
        $('.table').removeClass('table-striped');
        $('.animated .card-header .btn-light').addClass('pull-right btn-primary').removeClass('btn-light');
        $('input[type=search]').addClass('form-control search').attr("placeholder", "Search..").css('display','inline');
        $('[data-toggle="tooltip"]').tooltip();
    } );
</script>

@stack('scripts')

</html>
