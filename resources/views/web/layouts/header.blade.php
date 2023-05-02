<!-- ======= Header ======= -->
<header id="header" class="fixed-top ">
  <div class="d-flex align-items-center justify-content-between">

    <h1 class="logo large-logo px-4">
      <a href="{{ route('web.index', [$locale, '']) }}">
        <img src="{{ url('public').config('app.main_logo') }}" width="219" alt="...">
      </a>
    </h1>
    <h1 class="logo small-logo t20">
      <a href="{{ route('web.index', [$locale, '']) }}">
        <img src="{{ url('public').config('app.secondary_logo') }}" class="img-fluid" width="60" height="74" alt="...">
      </a>
    </h1>
    <nav id="navbar" class="navbar">
      <ul>
        @foreach ($nav as $lvl1)
        @if ($lvl1->ref > 1 && $lvl1->menu_display == "visible")
        <li>
          <a class="nav-link scrollto {{ in_array($active_menu->id, $lvl1->child_ids) ? 'active' : '' }}" href="{{ $lvl1->href }}">{{ $lvl1->title }}</a>
          @if (isset($lvl1->child) && count($lvl1->child) > 0)
          <div class="mega-menu">
            @foreach ($lvl1->child as $lvl2)
            @if ($lvl2->menu_display == "visible")
            <div class="column-mega-menu">
              <a href="{{ $lvl2->href }}">
                <h3 class="fs-5">{{ $lvl2->title }}</h3>
              </a>
              @if (isset($lvl2->child) && count($lvl2->child) > 0)
              @foreach ($lvl2->child as $lvl3)
              @if ($lvl3->menu_display == "visible")
              <a href="{{ $lvl3->href }}">{{ $lvl3->title }}</a>
              @endif
              @endforeach
              @endif
            </div>
            @endif
            @endforeach
          </div>
          @endif
        </li>
        @endif
        @endforeach
      </ul>
      <ul>
        <li class="nav-lang d-flex align-items-center text-white mx-5">
          <span class="mx-4 position-relative">
            <i id="open-search-desktop" class="ri-search-line fs-4" style="cursor: pointer;"></i>
            <div id="search-desktop" class="position-relative" style="top:10px">
              <i id="close-search-desktop" class="ri-close-line fs-5 text-white position-absolute" style="top: 3px; z-index: 1; cursor: pointer;"></i>
              <input id="input-search" class="search-field-desktop rounded border border-light fs-10 px-3 py-2" type="text" placeholder="Pencarian"/>
            </div>
          </span>
          @php $count = 0; $countlang = count(config('app.lang')); @endphp
          @if ($countlang > 1)
          @foreach(config('app.lang') as $key => $lang)
          @php $index = array_search($lang, array_column($nav_lang, 'lang')); @endphp
          @if (request()->get('keyword') && request()->get('keyword') != '')
          <a class="{{ ($lang == $locale) ? 'active' : '' }}" href="{{ route('web.search', [$lang]).'?keyword='.request()->get('keyword').'#result' }}"><span>{{ $lang }}</span></a>
          @else
          <a class="{{ ($lang == $locale) ? 'active' : '' }}" href="{{ route('web.index', [$nav_lang[$index]['lang'], $nav_lang[$index]['alias']]) }}"><span>{{ $lang }}</span></a>
          @endif
          @if(++$count%2 && $count < $countlang)
          <span class="mx-2 mb-2">|</span>
          @endif
          @endforeach
          @endif
        </li>
      </ul>
      <i class="bi bi-list mobile-nav-toggle"></i>
    </nav><!-- .navbar -->
    <div class="icon-burger-menu" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
      <i class="ri-menu-line text-white"></i>
    </div>
  </div>
</header><!-- End Header -->
