@if(isset($next_menu))
  <section class="linked-section text-center">
    <p>Halaman Selanjutnya</p>
    <h2 class="fw-bold"><a href="{{ $next_menu->href }}">{{ $next_menu->title }}</a></h2>
  </section>
@endif