@if (count($data))
@foreach($data as $key => $cert)
<div class="col-lg-4">
  <div data-bs-toggle="offcanvas" data-bs-target="#offcanvasTJSL{{ $cert->id }}" aria-controls="offcanvasTJSL" class="card-cerficate">
    <div class="image">
      <img src="{{ $cert->image }}" alt="{{ $cert->title }}" />
    </div>
    <div class="caption">
      <p>{{ $cert->title }}</p>
      <label>{{ __('web.more') }}</label>
    </div>
  </div>
</div>
@endforeach
@endif
