<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon-16x16.png') }}">

    <title>@yield('title') - {{ get_setting('site_title') }}</title>

    <!-- page css -->
    <link href="{{ asset('css/pages/login-register-lock.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/my-styles.css') }}" rel="stylesheet">
    <!-- Sweetalert -->
    <link href="{{ asset('assets/node_modules/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet">

</head>

<body>

    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">{{ get_setting('site_title') }}</p>
        </div>
    </div>

    <section id="wrapper" class="login-register login-sidebar"
        style=" background-image: url({{ asset('assets/images/background.jpg') }}) !important;">
        <div class="login-box card">
            <div class="card-body">
                @yield('content')
            </div>
        </div>
    </section>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{ asset('assets/node_modules/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('assets/node_modules/popper/popper.min.js') }}"></script>
    <script src="{{ asset('assets/node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/node_modules/sweetalert2/dist/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('js/ajax.js') }}"></script>
    <!--Custom JavaScript -->
    <script type="text/javascript">
        $(function() {
            $(".preloader").fadeOut();
        });
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        });
        $('#to-recover').on("click", function() {
            $("#login").slideUp();
            $("#recoverform").fadeIn();
        });
    </script>
</body>

</html>
