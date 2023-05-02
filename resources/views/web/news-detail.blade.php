@extends('web.layouts.base')

@section('content')
<section>
  <div class="container news" data-aos="fade-up">

    <div class="row content">
      <div class="col-lg-12">
        <h3 class="fs-3 fw-bold mb-4">{{ $detail->title }}</h3>
        <p class="text-blue my-4 fw-semibold">{{ date("d M Y", strtotime($detail->active_date)) }} {{ ($detail->exp_date) ? "s/d " . date("d M Y", strtotime($detail->exp_date)) : "" }}</p>
        <img class="w-100" src="{{  url('public') }}{{ $detail->image }}" alt="{{ $detail->title }}" />
        <br />
        <br />
        <p class="fs-6 fw-lighter lh-md">
          @if ($detail->embed)
          <iframe width="100%" height="500" src="https://www.youtube.com/embed/{{ $detail->embed }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          @endif

          {!! $detail->content !!}

        </p>
      </div>
    </div>

    <div class="text-center">
    <a href="{{ url()->previous() }}"><button type="button" class="btn btn-primary btn-animate mt-4">{{ __('web.back') }}</button></a>
    </div>
  </div>
</section>
@endsection
