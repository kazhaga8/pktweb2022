<!-- ======= Miscellaneous Section ======= -->
<section id="miscellaneous" class="miscellaneous">
  <div class="" data-aos="fade-up">
    <div class="slider center">
      @foreach($slider_bottom as $key => $item)
      <div class="slide">
        <div class="cl"><img src="{{ url('public') }}{{ $item->image }}" /></div>
      </div>
      @endforeach
    </div>
  </div>
</section><!-- End Miscellaneous Section -->