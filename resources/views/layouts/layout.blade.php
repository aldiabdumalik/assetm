<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('templates/assets/images/favicon.ico')}}">
    {{-- Other css --}} 
    <link href="{{asset('templates/plugins/spinkit/spinkit.css')}}" rel="stylesheet" />
    {{-- <link href="{{asset('templates/plugins/dropify/css/dropify.min.css')}}" rel="stylesheet" type="text/css" /> --}}
    <link href="{{asset('templates/plugins/jquery-toastr/jquery.toast.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('templates/plugins/sweet-alert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('templates/plugins/jquery-loading/jquery.loading.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('templates/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('templates/plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('templates/plugins/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
    <!-- App css -->
    <link href="{{asset('templates/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('templates/assets/css/icons.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('templates/assets/css/metismenu.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('templates/assets/css/style.css')}}" rel="stylesheet" type="text/css" />
    <script src="{{asset('templates/assets/js/modernizr.min.js')}}"></script>
</head>
<body class="@yield('page')">
    <div id="baseurl" data-id="{{url('')}}"></div>
    @yield('layout')
    <!-- jQuery  -->
    <script src="{{asset('templates/assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('templates/assets/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('templates/assets/js/metisMenu.min.js')}}"></script>
    <script src="{{asset('templates/assets/js/waves.js')}}"></script>
    <script src="{{asset('templates/assets/js/jquery.slimscroll.js')}}"></script>
    {{-- Other js --}}
    {{-- <script src="{{asset('templates/plugins/dropify/js/dropify.min.js')}}"></script> --}}
    <script src="{{asset('templates/plugins/jquery-toastr/jquery.toast.min.js')}}"></script>
    <script src="{{asset('templates/plugins/sweet-alert/sweetalert2.min.js')}}"></script>
    <script src="{{asset('templates/plugins/jquery-loading/jquery.loading.min.js')}}"></script>
    <script src="{{asset('templates/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('templates/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('templates/plugins/datatables/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('templates/plugins/datatables/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('templates/plugins/moment/moment.js')}}"></script>
    <script src="{{asset('templates/plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <!-- App js -->
    <script src="{{asset('templates/assets/js/jquery.core.js')}}"></script>
    <script src="{{asset('templates/assets/js/jquery.app.js')}}"></script>
    @stack('page-js')
</body>
</html>