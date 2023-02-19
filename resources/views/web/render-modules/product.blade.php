@if(isset($product) && count($product))
<section id="sliderProduct" class="ui-card-slider">
    @foreach($product as $item)
    <div class="slide">
        <img src="{{ url('public') }}{{ $item->image }}">
    </div>
    @endforeach
</section>
<div class="position-absolute text-center" style="z-index: 1;">
    @foreach($product as $key => $item)
    <div class="slider-content-6 fs-1 fw-bold text-shadow" data-index="{{ $key }}">{{ $item->variant }}</div>
    @endforeach
</div>
@endif

@push('js')
<script src="{{ url('public') }}/assets/web/vendor/card-slider-min.js"></script>
@endpush
@push('javascript')
    <script>
        $( document ).ready(function() {
          window.slider = $('#sliderProduct').cardSlider({
            slideTag: 'div'
            , slideClass: 'slide'
            , current: 1
            , followingClass: 'slider-content-6'
            , delay: 300
            , transition: 'ease'
            , onBeforeMove: function(slider, onMove) {
              console.log('onBeforeMove')
              onMove()
            }
            , onMove: function(slider, onAfterMove) {
              onAfterMove()
            }
            , onAfterMove: function() {
              console.log('onAfterMove')
            }
            , onAfterTransition: function() {
              console.log('onAfterTransition')
            }
            , onCurrent: function() {
              console.log('onCurrent')
            }
          });
        });
      </script>
@endpush
