<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('assets/images/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('assets/images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('assets/images/favicon-16x16.png') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ get_setting('site_title') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
{{--    <link href="{{ url('css/app.css') }}" rel="stylesheet">--}}

    <link href="{{ url('assets/node_modules/morrisjs/morris.css') }}" rel="stylesheet">
    <!--Toaster Popup message CSS -->
    <link href="{{ url('assets/node_modules/toast-master/css/jquery.toast.css') }}" rel="stylesheet">
    <!-- Morris CSS -->
    <link href="{{ url('assets/node_modules/morrisjs/morris.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ url('dist/css/style.min.css') }}" rel="stylesheet">
    <!-- Dashboard 1 Page CSS -->
    <link href="{{ url('dist/css/pages/dashboard1.css') }}" rel="stylesheet">
    <!-- Fileupload -->
    <link href="{{ url('dist/css/pages/file-upload.css') }}" rel="stylesheet">
    <!-- Sweetalert -->
    <link href="{{ url('assets/node_modules/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">

    <link href="{{ url('css/my-styles.css') }}" rel="stylesheet">

</head>
<body class="skin-blue fixed-layout">

    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">{{ get_setting('site_title') }}</p>
        </div>
    </div>

    <div id="app">
        @include('partials.header')
        @include('partials.sidebar')
        <div class="page-wrapper">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
        <footer class="footer">
            <div class="row">
                <div class="col-md-9">
                    © {{ date('Y') }} - {{ get_setting('site_title') }}
                </div>
                <div class="col-md-3">
                    Developed By <a href="https://www.innovativeducks.com/">Innovative Ducks</a>
                </div>
            </div>
        </footer>
    </div>


    <!-- Scripts -->

    <script>
        var site_url = "{{ url('/') }}";
    </script>
    <script src="{{ url('assets/node_modules/jquery/jquery-3.2.1.min.js') }}"></script>
    <!-- Bootstrap popper Core JavaScript -->
    <script src="{{ url('assets/node_modules/popper/popper.min.js') }}"></script>
    <script src="{{ url('assets/node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{ url('dist/js/perfect-scrollbar.jquery.min.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ url('dist/js/waves.js') }}"></script>
    <!--Menu sidebar -->
    <script src="{{ url('dist/js/sidebarmenu.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ url('dist/js/custom.min.js') }}"></script>
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <!--morris JavaScript -->
    <script src="{{ url('assets/node_modules/raphael/raphael-min.js') }}"></script>
    <script src="{{ url('assets/node_modules/morrisjs/morris.min.js') }}"></script>
    <script src="{{ url('assets/node_modules/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ url('assets/node_modules/sweetalert2/dist/sweetalert2.min.js') }}"></script>
    <!-- Popup message jquery -->
    <script src="{{ url('assets/node_modules/toast-master/js/jquery.toast.js') }}"></script>
    <!-- Chart JS -->
    <script src="{{ url('dist/js/pages/jasny-bootstrap.js') }}"></script>
    <!-- Custom Theme JavaScript -->
    <script src="{{ url('dist/js/dashboard1.js') }}"></script>
    <!-- Ajax -->
{{--    <script src="{{ url('js/ajax.js') }}"></script>--}}

    <script>
        $(document).ready(function(){
            $('#myTable').DataTable();
            $('#attendance_table').DataTable();
            $('#fee_table').DataTable();
            $('#results_table').DataTable();
        });
    </script>
    @yield('javascript')
</body>
</html>
