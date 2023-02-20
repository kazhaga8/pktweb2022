<div class="row content justify-content-center">
  @if (count($data))
  @foreach($data as $key => $news)
  <div class="col-lg-4">
    <div class="box">
      <div class="box-image w-100">
        <img class="w-100" src="{{ $news->image }}" alt="{{ $news->title }}" />
      </div>
      <div class="content">
        <div class="d-flex justify-content-between mb-2">
          <span class="tag">{{ $news->category }}</span>
          <span class="date">{{ $news->active_date }}</span>
        </div>
        <p class="fs-6 fw-semibold">{{ $news->title }}</p>
        <a href="{{ $news->url }}"><button type="button" class="btn btn-primary btn-animate mt-4">{{ __('web.more') }}</button></a>
      </div>
    </div>
  </div>
  @if (($key+1) % 3 == 0)
</div>
<div class="row content justify-content-center">
  @endif
  @endforeach
  @endif
</div>
