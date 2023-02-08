<!-- ======= Floating Menu ======= -->
@if (isset($active_menu->child))
<ul id="floating-menu-general" class="floating-menu">
  @foreach($active_menu->child as $menu)
  @if ($menu->menu_type == 'anchor')
  <li class="dropdown d-flex">
    <button class="dropbtn"><i class="ri-external-link-fill"></i></button>
    <div class="dropdown-content fw-lighter"><a href="{{ $menu->href }}">{{ $menu->title }}</a></div>
  </li>
  @endif
  @endforeach
</ul>
@endif
<!-- End Floating Menu -->