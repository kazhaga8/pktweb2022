@if (count($data))
@foreach($data as $key => $news)
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
        <button type="button" class="btn btn-primary btn-animate mt-4">{{ __('web.more') }}</button>
    </div>
</div>
@endforeach
@endif
