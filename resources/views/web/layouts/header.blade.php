<!-- ======= Header ======= -->
<header id="header" class="fixed-top ">
  <div class="d-flex align-items-center justify-content-between">

    <h1 class="logo large-logo px-4">
      <a href="{{ route('web.index', [$locale, '']) }}">
        <img src="{{ url('public').$config['main_logo'] }}" width="219" alt="...">
      </a>
    </h1>
    <h1 class="logo small-logo t20">
      <a href="{{ route('web.index', [$locale, '']) }}">
        <img src="{{ url('public').$config['secondary_logo'] }}" class="img-fluid" width="60" height="74" alt="...">
      </a>
    </h1>
    <nav id="navbar" class="navbar">
      <ul>
        @foreach ($nav as $lvl1)
        @if ($lvl1->ref > 1)
        <li>
          <a class="nav-link scrollto" href="{{ $lvl1->href }}">{{ $lvl1->title }}</a>
          @if (isset($lvl1->child) && count($lvl1->child) > 0)
          <div class="mega-menu">
            @foreach ($lvl1->child as $lvl2)
            <div class="column-mega-menu">
              <a href="{{ $lvl2->href }}">
                <h3 class="fs-5">{{ $lvl2->title }}</h3>
              </a>
              @if (isset($lvl2->child) && count($lvl2->child) > 0)
              @foreach ($lvl2->child as $lvl3)
              <a href="{{ $lvl3->href }}">{{ $lvl3->title }}</a>
              @endforeach
              @endif
            </div>
            @endforeach
          </div>
          @endif
        </li>
        @endif
        @endforeach
      </ul>
      <ul>
        <li class="nav-lang d-flex align-items-center text-white mx-5">
          <span class="mx-4">
            <i class="ri-search-line fs-4"></i>
          </span>
          <a href="{{ route('web.index', [$nav_lang[0]['lang'], $nav_lang[0]['alias']]) }}"><span>{{ $nav_lang[0]['lang'] }}</span></a>
          <span class="mx-2">|</span>
          <a href="{{ route('web.index', [$nav_lang[1]['lang'], $nav_lang[1]['alias']]) }}"><span>{{ $nav_lang[1]['lang'] }}</span></a>
        </li>
      </ul>
      <i class="bi bi-list mobile-nav-toggle"></i>
    </nav><!-- .navbar -->
    <div class="icon-burger-menu" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
      <i class="ri-menu-line text-white"></i>
    </div>
  </div>
</header><!-- End Header -->