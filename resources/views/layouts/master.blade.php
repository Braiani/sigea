<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('/img/apple-icon.png')}}">
    <link rel="icon" type="image/png" href="{{asset('/img/favicon.ico')}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{setting('site.title')}} - @yield('title')</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <!-- CSS Files -->
    <link href="{{asset('/css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/css/light-bootstrap-dashboard.css')}}" rel="stylesheet" />
    <link href="{{asset('/css/bootstrap-select.css')}}" rel="stylesheet" />
    @toastr_css
    @stack('css')
</head>

<body>
    <div class="wrapper">
        @include('layouts.sidebar')
        <div class="main-panel">
            @include('layouts.panel-navbar')
            <div class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
            @include('layouts.footer')
        </div>
    </div>

<!--   Core JS Files   -->
<script src="{{asset('/js/core/jquery.3.2.1.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/js/core/popper.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/js/core/bootstrap.min.js')}}" type="text/javascript"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="{{asset('/js/plugins/bootstrap-switch.js')}}"></script>
<!--  Chartist Plugin  -->
<script src="{{asset('/js/plugins/chart.bundle.min.js')}}"></script>
<!--  Bootstrap Table Plugin -->
<script src="{{asset('/js/plugins/bootstrap-table.js')}}"></script>
<script src="{{asset('/js/locale/bootstrap-table-pt-BR.js')}}"></script>
<!--  Sweet Alert  -->
<script src="{{asset('/js/plugins/sweetalert2.min.js')}}" type="text/javascript"></script>
<!--  Bootstrap Select  -->
<script src="{{asset('/js/plugins/bootstrap-select.js')}}" type="text/javascript"></script>
<script src="{{asset('/js/plugins/i18n/defaults-pt_BR.js')}}" type="text/javascript"></script>
<!--  Notifications Plugin    -->
<script src="{{asset('/js/plugins/bootstrap-notify.js')}}"></script>
<!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
<script src="{{asset('/js/light-bootstrap-dashboard.js?v=2.0.1')}}" type="text/javascript"></script>

<script src="{{asset('/js/app.js')}}"></script>

@toastr_js
@toastr_render

<script>
    $(document).ready(function() {
        $(document).trigger('documentReady');
        $(document).trigger('pageReady');
        $('#sair').on('click', function(e){
            e.preventDefault();
            $('#form-sair').submit();
        });
        app.checkFullPageBackgroundImage();
        app.initSidebarMini();

        $('#minimizeSidebar').on('click', function(){
            app.toggleNavbar();
        });
    });
</script>


@stack('script')
</body>
</html>
