@componentlib
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ url('public') }}/assets/images/favicon.ico">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App title -->
    <title>{{ config('app.name', 'Laravel') }}</title>

    @stack('css')
    @yield('css')

    <!-- App css -->
    <link href="{{ url('public') }}/plugins/bootstrap-sweetalert/sweet-alert.css" rel="stylesheet" type="text/css">
    <link href="{{ url('public') }}/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- <link href="{{ url('public') }}/assets/web/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="{{ url('public') }}/assets/css/core.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('public') }}/assets/css/components.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('public') }}/assets/css/icons.css" rel="stylesheet" type="text/css" />
    <!-- <link href="{{ url('public') }}/assets/css/pages.css" rel="stylesheet" type="text/css" /> -->
    <link href="{{ url('public') }}/assets/css/menu.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('public') }}/assets/css/responsive.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ url('public') }}/plugins/switchery/switchery.min.css">
    <link rel="stylesheet" href="{{ url('public') }}/plugins/fancybox/jquery.fancybox.css">


    <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

    <script src="{{ url('public') }}/assets/js/modernizr.min.js"></script>

</head>
<body class="fixed-left">
    <!-- Begin page -->
    <div id="wrapper">
        @include('webmin.layouts.topbar')
        @include('webmin.layouts.leftsidebar')
        <div class="content-page">
            <div class="content">
                <div class="container">
                    @include('webmin.layouts.breadcrumb')
                    @yield('content')
                    
                </div>
            </div>
            @include('webmin.layouts.footer')
        </div>
        @include('webmin.layouts.rightsidebar')
        <div class="modal fade" id="baseModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <!-- <h4 class="modal-title">Modal with Dynamic Content</h4> -->
                    </div>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END wrapper -->
    <script>
        var resizefunc = [];
    </script>
    <!-- jQuery  -->
    <script src="{{ url('public') }}/assets/js/jquery.min.js"></script>
    <script src="{{ url('public') }}/assets/js/bootstrap.min.js"></script>
    <!-- <script src="{{ url('public') }}/assets/web/vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->
    <script src="{{ url('public') }}/assets/js/detect.js"></script>
    <script src="{{ url('public') }}/assets/js/fastclick.js"></script>
    <!-- <script src="{{ url('public') }}/assets/js/jquery.blockUI.js"></script> -->
    <!-- <script src="{{ url('public') }}/assets/js/waves.js"></script> -->
    <script src="{{ url('public') }}/assets/js/jquery.slimscroll.js"></script>
    <!-- <script src="{{ url('public') }}/assets/js/jquery.scrollTo.min.js"></script> -->
    <script src="{{ url('public') }}/plugins/switchery/switchery.min.js"></script>
    <script src="{{ url('public') }}/plugins/bootstrap-sweetalert/sweet-alert.min.js"></script>
    <script src="{{ url('public') }}/plugins/fancybox/jquery.fancybox.pack.js"></script>

    @stack('js')
    @yield('js')
    
    <!-- App js -->
    <script src="{{ url('public') }}/assets/js/jquery.core.js"></script>
    <script src="{{ url('public') }}/assets/js/jquery.app.js"></script>
    
    @stack('javascript')
    @yield('javascript')

</body>

</html>
