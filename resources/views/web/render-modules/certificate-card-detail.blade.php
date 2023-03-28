@if (count($data))
@foreach($data as $key => $cert)
<?php
preg_match("/<p[^>]*class=\"p-5\">(.*?)<\\/p>/si", $cert->content, $match);
if (count($match) > 0) {
    $content = $match[1];
} else {
    $content = $cert->content;
}
?>
<div class="offcanvas offcanvas-end sidebar-cert" tabindex="-1" id="offcanvasCert{{ $cert->id }}" aria-labelledby="offcanvasExampleLabel">
  <div class="offcanvas-header justify-content-end py-0 bg-grey">
    <div data-bs-dismiss="offcanvas" aria-label="Close" class="hvrbtn"><i class="ri-close-line fs-1 text-grey"></i></div>
  </div>
  <div class="offcanvas-body p-0">
    <div class="top-cert d-flex w-full align-items-center py-3">
      <img src="{{ $cert->image }}" width="200" alt="{{ $cert->title }}" />
      <div>
        <label class="fs-6 text-blue mb-2 d-block">{{ $cert->year }}</label>
        <h4 class="fs-5 text-blue">{{ $cert->title }}</h4>
      </div>
    </div>
    <div class="p-5">
        {!! $content !!}
    </div>
  </div>
</div>
@endforeach
@endif
