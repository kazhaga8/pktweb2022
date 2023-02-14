<div data-aos="fade-up" class="row box-news-slide as-is-it">
  @if(isset($timeline))
  @foreach($timeline as $key => $item)
  <div data-bs-toggle="offcanvas" data-bs-target="#offcanvasCert{{ $key }}" aria-controls="offcanvasCert" class="box" style="cursor:pointer;">
    <div class="box-image w-100">
      <img class="w-100" src="{{ url('public') }}{{ $item->image }}" alt="..." />
    </div>
    <div class="content">
      <div class="d-flex justify-content-start mb-2">
        <span class="tag">{{ $item->year }}</span>
      </div>
      <p class="fs-6 fw-semibold">{{ $item->title }}</p>
    </div>
  </div>
  @endforeach
  @endif
</div>