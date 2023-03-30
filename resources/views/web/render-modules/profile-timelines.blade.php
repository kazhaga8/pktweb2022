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

@push('content-support')
@foreach($timeline as $key => $item)
<div class="offcanvas offcanvas-end sidebar-cert" tabindex="-1" id="offcanvasCert{{ $key }}" aria-labelledby="offcanvasExampleLabel">
      <div class="offcanvas-header justify-content-end py-0 bg-grey">
        <div data-bs-dismiss="offcanvas" aria-label="Close" class="hvrbtn"><i class="ri-close-line fs-1 text-grey"></i></div>
      </div>
      <div class="offcanvas-body p-0">
        <div class="top-cert d-flex w-full align-items-center py-3">
          <div class="p-5" style="padding-top: 0 !important; padding-bottom:0 !important;">
            <label class="fs-6 text-blue mb-2 d-block">{{ $item->year }}</label>
            <h4 class="fs-5 text-blue">{{ $item->title }}</h4>
          </div>
        </div>
        <div class="p-5">{!! $item->content !!}</div>
      </div>
    </div>
@endforeach
@endpush
