@if (count($data))
@foreach($data as $key => $cert)
<div class="offcanvas offcanvas-end sidebar-cert" tabindex="-1" id="offcanvasTJSL{{ $cert->id }}" aria-labelledby="offcanvasExampleLabel">
      <div class="offcanvas-header justify-content-end py-0 bg-grey">
        <div data-bs-dismiss="offcanvas" aria-label="Close" class="hvrbtn"><i class="ri-close-line fs-1 text-grey"></i></div>
      </div>
      <div class="offcanvas-body p-0">
        <div class="top-cert d-flex w-full align-items-center py-3 text-center">
          <img style="margin: 0 auto;" src="{{ $cert->image }}" width="500" alt="{{ $cert->title }}" />
        </div>
        <div class="p-4">
          <h4 class="fs-5 text-blue">{{ $cert->title }}</h4>
          <p>{!! $cert->content !!}</p>
        </div>
      </div>
    </div>
@endforeach
@endif
