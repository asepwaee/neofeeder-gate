<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from htmldemo.net/jibanu/jibanu/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 07 Aug 2023 16:13:25 GMT -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Statistik | @yield('title')</title>

    <!--== Favicon ==-->
    <link rel="shortcut icon" href="{{asset('aseplab/neofeeder/themes/assets/img/favicon.ico')}}" type="image/x-icon" />

    <!--== Google Fonts ==-->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,300;1,400&amp;display=swap" rel="stylesheet">

    <!-- build:css assets/css/app.min.css -->
    <!--== jqvmap Min CSS ==-->
    <link href="{{asset('aseplab/neofeeder/themes/assets/css/jqvmap.min.css')}}" rel="stylesheet" />
    <!--== ChartJS Min CSS ==-->
    <link href="{{asset('aseplab/neofeeder/themes/assets/css/chart.min.css')}}" rel="stylesheet" />
    <!--== DataTables Min CSS ==-->
    <link href="{{asset('aseplab/neofeeder/themes/assets/css/datatables.min.css')}}" rel="stylesheet" />
    <!--== Select2 Min CSS ==-->
    <link href="{{asset('aseplab/neofeeder/themes/assets/css/select2.min.css')}}" rel="stylesheet" />
    <!--== Bootstrap Min CSS ==-->
    <link href="{{asset('aseplab/neofeeder/themes/assets/css/bootstrap.min.css')}}" rel="stylesheet" />

    <!--== Main Style CSS ==-->
    <link href="{{asset('aseplab/neofeeder/themes/assets/css/style.css')}}" rel="stylesheet" />
    <!-- endbuild -->
    @stack('style')
    <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <!--== Start Header Wrapper ==-->
    <header class="header-wrapper">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-6">
                    <div class="logo-wrap">
                        <a href="#"><img src="{{asset('aseplab/neofeeder/themes/assets/img/logo.png')}}" alt="logo" /></a>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6">
                    <div class="navbar-wrap">
                        <nav class="menubar">
                            <ul class="nav">
                                <li><a href="{{route('mahasiswa.index')}}">Mahasiswa</a></li>
                                <li><a href="{{route('dosen.index')}}">Dosen</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!--== End Header Wrapper ==-->

    <!--== Start Main Content Wrapper ==-->
    @yield('content')
    <!--== End Main Content Wrapper ==-->

    <!--== Start Header Wrapper ==-->
    <footer class="header-wrapper bg-success" style="margin-top:30px;">
        <div class="container">
            <div class="row justify-content-center align-items-center text-light">
                <div class="col-sm-12 col-lg-12">
                    <h6 class="text-center">Dikembangkan Oleh UPT TIK Hang Tuah Pekanbaru</h6>
                </div>
            </div>
        </div>
    </footer>
    <!--=======================Javascript============================-->
    <!-- build:js assets/js/app.min.js -->
    <!--=== Modernizr Min Js ===-->
    <script src="{{asset('aseplab/neofeeder/themes/assets/js/modernizr.min.js')}}"></script>
    <!--=== jQuery Min Js ===-->
    <script src="{{asset('aseplab/neofeeder/themes/assets/js/jquery.min.js')}}"></script>
    <!--=== jQuery Migration Min Js ===-->
    <script src="{{asset('aseplab/neofeeder/themes/assets/js/jquery-migrate.min.js')}}"></script>
    <!--=== Popper Min Js ===-->
    <script src="{{asset('aseplab/neofeeder/themes/assets/js/popper.min.js')}}"></script>
    <!--=== Bootstrap Min Js ===-->
    <script src="{{asset('aseplab/neofeeder/themes/assets/js/bootstrap.min.js')}}"></script>
    <!--=== Select2 Min Js ===-->
    <script src="{{asset('aseplab/neofeeder/themes/assets/js/select2.full.min.js')}}"></script>
    <!--=== Data Table Min Js ===-->
    <script src="{{asset('aseplab/neofeeder/themes/assets/js/datatables.min.js')}}"></script>
    <!--=== ChartJS Min Js ===-->
    <script src="{{asset('aseplab/neofeeder/themes/assets/js/chart.min.js')}}"></script>
    <!--=== jQuery Vector Map Min Js ===-->
    <script src="{{asset('aseplab/neofeeder/themes/assets/js/jquery.vmap.min.js')}}"></script>
    <!--=== jQuery Vector World Min Js ===-->
    <script src="{{asset('aseplab/neofeeder/themes/assets/js/jquery.vmap.world.js')}}"></script>
    @stack('script')
    <!--=== APP Js ===-->
    <!-- <script src="{{asset('aseplab/neofeeder/themes/assets/js/app.js')}}"></script> -->
    <!--=== Active Js ===-->
    <!-- <script src="{{asset('aseplab/neofeeder/themes/assets/js/active.js')}}"></script> -->

    <!-- endbuild -->
</body>


<!-- Mirrored from htmldemo.net/jibanu/jibanu/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 07 Aug 2023 16:13:34 GMT -->
</html>