<section id="hero" class="align-items-center">
  <div id="carouselExampleCaptions" class="carousel slide carousel-fade" data-bs-ride="carousel">
    <div class="box-caption-banner position-relative">
      <div class="carousel-inner">
        @foreach($slider as $key => $item)
        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
          <img src="{{ url('public') }}{{ $item->image }}" class="d-block w-100" alt="{{ $item->title }}">
          <div class="carousel-caption d-md-block">
            <h1 class="text-start mb-4">{{ $item->title }}</h1>
            <p class="text-start">{{ $item->description }}</p>
          </div>
        </div>
        @endforeach
      </div>
      <br />
      <br />
      <div class="carousel-indicators">
        @foreach($slider as $key => $item)
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}" aria-current="{{ $key == 0 ? 'true' : '' }}" aria-label="{{ $item->title }}"></button>
        @endforeach
      </div>
    </div>
  </div>
  <div class="arrow-down">
    <a href="#main">
      <i class="ri-arrow-down-s-line fs-1"></i>
    </a>
  </div>
</section>