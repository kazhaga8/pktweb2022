
  <!-- ======= Footer ======= -->
  {!! html_entity_decode(str_replace('../../public', url('public'), $config['content_footer_'.request()->route()->parameters['locale']])) !!}
  <!-- End Footer -->

  <div class="overlay"></div>
  <div class="overlay-megamenu"></div>
  <div id="preloader">
    <img src="{{ url('public') }}/assets/web/img/logo-small.png" alt="logo" />
  </div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="ri-arrow-up-line"></i></a>
