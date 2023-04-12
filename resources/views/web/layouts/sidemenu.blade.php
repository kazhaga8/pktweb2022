<!-- ======= Sidebar Navigation ======= -->
<div class="offcanvas offcanvas-end sidebar-navigation" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
  <div class="offcanvas-header justify-content-end py-0">
    <div data-bs-dismiss="offcanvas" aria-label="Close"><i class="ri-close-line fs-1 text-white"></i></div>
  </div>
  <div class="offcanvas-body">
    <nav class="animated bounceInDown">
      <div class="header-menu-mobile is_mobile">
        <a href="{{ route('web.index', [$locale, '']) }}">
          <img src="{{ url('public').config('app.main_logo') }}" class="mb-4" width="135" alt="...">
        </a>
        <div class="form-search-mobile d-flex">
          <i class="ri-search-line fs-5 text-white"></i>
          <input id="input-search-mobile" type="text" placeholder="Pencarian" class="w-100" />
        </div>
      </div>
      <ul class="main-menu-mobile">
        @foreach ($nav as $lvl1)
        @if ($lvl1->ref > 1)
        <li class="sub-menu">
          <a href="{{ isset($lvl1->child) ? '#' : $lvl1->href }}">{{ $lvl1->title }}
            @if (isset($lvl1->child) && count($lvl1->child) > 0)<i class="ri-add-line right"></i>@endif
          </a>
          @if (isset($lvl1->child) && count($lvl1->child) > 0)
          <ul>
            @foreach ($lvl1->child as $lvl2)
            <li class="sub-menu"><a href="{{ isset($lvl2->child) ? '#' : $lvl2->href }}">{{ $lvl2->title }}
                @if (isset($lvl2->child) && count($lvl2->child) > 0)<i class="ri-add-line right"></i>@endif
              </a>
              @if (isset($lvl2->child) && count($lvl2->child) > 0)
              <ul>
                @foreach ($lvl2->child as $lvl3)
                <li><a href="{{ $lvl3->href }}">{{ $lvl3->title }}</a></li>
                @endforeach
              </ul>
              @endif
            </li>
            @endforeach
          </ul>
          @endif
        </li>
        @endif
        @endforeach
      </ul>
      <ul class="secondary-menu">
        @foreach ($nav_right as $lvl1)
        @if ($lvl1->ref > 1)
        <li class="sub-menu">
          <a href="{{ isset($lvl1->child) ? '#' : $lvl1->href }}">{{ $lvl1->title }}
            @if (isset($lvl1->child) && count($lvl1->child) > 0)<i class="ri-add-line right"></i>@endif
          </a>
          @if (isset($lvl1->child) && count($lvl1->child) > 0)
          <ul>
            @foreach ($lvl1->child as $lvl2)
            <li class="sub-menu"><a href="{{ isset($lvl2->child) ? '#' : $lvl2->href }}">{{ $lvl2->title }}
                @if (isset($lvl2->child) && count($lvl2->child) > 0)<i class="ri-add-line right"></i>@endif
              </a>
              @if (isset($lvl2->child) && count($lvl2->child) > 0)
              <ul>
                @foreach ($lvl2->child as $lvl3)
                <li><a href="{{ $lvl3->href }}">{{ $lvl3->title }}</a></li>
                @endforeach
              </ul>
              @endif
            </li>
            @endforeach
          </ul>
          @endif
        </li>
        @endif
        @endforeach
        <li class="is_mobile nav-lang text-white fs-6 mt-5">

          @php $count = 0; $countlang = count(config('app.lang')); @endphp
          @if ($countlang > 1)
          @foreach(config('app.lang') as $key => $lang)
          @php $index = array_search($lang, array_column($nav_lang, 'lang')); @endphp
          @if (request()->get('keyword') || request()->get('keyword') == '')
          <a href="{{ route('web.search') }}"><span>{{ $lang }}</span></a>
          @else
          <a href="{{ route('web.index', [$nav_lang[$index]['lang'], $nav_lang[$index]['alias']]) }}"><span>{{ $lang }}</span></a>
          @endif
          @if(++$count%2 && $count < $countlang)
          <span class="mx-2">|</span>
          @endif
          @endforeach
          @endif
        </li>
      </ul>
    </nav>
  </div>
</div><!-- End Sidebar Navigation -->
