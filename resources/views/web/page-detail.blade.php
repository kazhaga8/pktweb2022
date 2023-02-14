@extends('web.layouts.base')

@section('content')
<section>
  <div class="container news" data-aos="fade-up">

    <div class="row content">
      <div class="col-lg-12">
        <h3 class="fs-3 fw-bold mb-4">{{ $news->title }}</h3>
        <p class="text-blue my-4 fw-semibold">{{ date("d M Y", strtotime($news->active_date)) }} {{ ($news->exp_date) ? "s/d " . date("d M Y", strtotime($news->exp_date)) : "" }}</p>
        <img class="w-100" src="{{  url('public') }}{{ $news->image }}" alt="{{ $news->title }}" />
        <br />
        <br />
        <p class="fs-6 fw-lighter lh-md">
          @if ($news->embed)
          <iframe width="100%" height="500" src="https://www.youtube.com/embed/{{ $news->embed }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          @endif

          {!! $news->content !!}

        </p>
      </div>
    </div>

    <div class="text-center">
    <a href="{{ url()->previous() }}"><button type="button" class="btn btn-primary btn-animate mt-4">Kembali</button></a>
    </div>
  </div>
</section>
@endsection