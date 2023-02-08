<section id="hero" class="d-flex align-items-center" style="background-image: url(<?php echo url('public') . ($active_menu->banner_img ? $active_menu->banner_img : '/assets/files/img/banner-cert.jpg') ?>); background-size: cover;">
  <div class="box-caption-banner position-relative w-100">
    <div class="w-75 mx-auto">
      <h3 class="mb-4 d-block w-100 text-white">{{ $active_menu->title }}</h3>
      @if (isset($active_menu->child))
      <ul class="general-menu-banner">
        @foreach($active_menu->child as $menu)
        @if ($menu->menu_type == 'anchor')
        <li>
          <a class="d-flex" href="{{ $menu->href }}">
            <span>{{ $menu->title }}</span>
            <i class="ri-arrow-right-down-line"></i>
          </a>
        </li>
        @endif
        @endforeach
      </ul>
      @endif
    </div>
  </div>
</section>