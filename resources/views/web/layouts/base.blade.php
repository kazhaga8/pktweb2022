
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>{{ isset($page) ? $page->title : 'COMING SOON' }} | PT Pupuk Kaltim</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ url('public') }}/assets/web/img/favicon.png" rel="icon">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="{{ url('public') }}/assets/web/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <link href="{{ url('public') }}/assets/web/vendor/aos/aos.css" rel="stylesheet">
  <link href="{{ url('public') }}/assets/web/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ url('public') }}/assets/web/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="{{ url('public') }}/assets/web/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="{{ url('public') }}/assets/web/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/jquery.slick/1.5.0/slick-theme.css" rel="stylesheet">

  @stack('css')
  @yield('css')

  <link href="{{ url('public') }}/assets/web/css/style.css" rel="stylesheet">
  <link href="{{ url('public') }}/assets/web/css/style-improve.css" rel="stylesheet">

</head>

<body>
  @include('web.layouts.header')
  @if (isset($active_menu->ref) && $active_menu->ref == 1)
  @include('web.layouts.sliders')
  @else
  @include('web.layouts.banner')
  @endif
  
  <main id="main">
    @yield('content')
    @stack('content-support')
    @yield('content-support')
    @if ($active_menu->ref == 1)
    @include('web.layouts.sliderbottom')
    @endif
    @include('web.layouts.sidemenu')
    @include('web.layouts.shortcut')
    @include('web.layouts.floatingmenu')
  </main>
  @if ($active_menu->ref > 1)
  @include('web.layouts.nextmenu')
  @endif
  @include('web.layouts.footer')

  <script src="{{ url('public') }}/assets/web/vendor/aos/aos.js"></script>
  <script src="{{ url('public') }}/assets/web/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="{{ url('public') }}/assets/web/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="{{ url('public') }}/assets/web/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="{{ url('public') }}/assets/web/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="{{ url('public') }}/assets/web/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@panzoom/panzoom/dist/panzoom.min.js"></script>
  @stack('js')
  @yield('js')
  <script src="{{ url('public') }}/assets/web/js/main.js"></script>

  @stack('javascript')
  @yield('javascript')
</body>
</html>