@extends('web.layouts.base')

@section('content')

<section>
  <div class="container" data-aos="fade-up">
    <div class="row content">
      <div class="col-lg-12 pt-4 pt-lg-0">
        <h3 class="fs-4 fw-lighter mb-3">
          Hasil Pencarian : {{ request()->get('keyword') }}
        </h3>
        <div class="box-categories-news">
          <ul class="categories-news d-flex p-0 m-0">
            @foreach($result as $key => $value)
            <li class="tab-{{ $key }} {{ $key == 0 ? 'active' : '' }}">{{ $key }}</li>
            @endforeach
            <!-- <li>Category search 1</li>
            <li>Category search 2</li>
            <li>Category search 3</li> -->
          </ul>
        </div>
        @foreach($result as $key => $category)
        <ul class="p-0 mt-5 seaction-result seaction-{{ $key }}-result" style="list-style: none">
            @foreach($category as $value)
            <li class="pl-1 text-grey fs-6 fw-lighter lh-md mb-4" style="border-bottom: 1px solid black">
              <h5><a style="color: black" href="{{ $value->href }}" target="_blank">{!! $value->title !!}</a></h5>
              <p class="pl-1 text-grey fs-6 fw-lighter lh-md">{!! $value->content !!}</p>
            </li>
            @endforeach
        </ul>
          @endforeach
        <!-- <div class="text-center">
          <button type="button" class="btn btn-primary btn-animate mt-4">Muat Lebih</button>
        </div> -->
      </div>
    </div>
  </div>
</section>
@endsection
