<div class="row content text-center d-flex justify-content-center">
  @foreach($data as $key => $item)
  <div data-bs-toggle="offcanvas" data-bs-target="#offcanvas{{ $item->board }}{{ $key }}" aria-controls="offcanvas{{ $item->board }}{{ $key }}" class="card-employee">
    <img src="{{ url('public') }}{{ $item->profile_pic }}" alt="..." />
    <div class="caption">
      <p class="mb-1">{{ $item->name }}</p>
      <label>{{ $item->position }}</label>
    </div>
    <div class="card-employee-bg"></div>
  </div>
  @if ($key % 3 == 0)
</div>
<div class="row content text-center d-flex justify-content-center">
  @endif
  @endforeach
</div>
@push('content-support')
@foreach($data as $key => $item)
<div class="offcanvas offcanvas-end sidebar-directors bg-blue" tabindex="-1" id="offcanvas{{ $item->board }}{{ $key }}" aria-labelledby="offcanvasExampleLabel" style="background-image: url(<?php echo url('public') . ($item->image ? $item->image : '/assets/files/img/profil-bisnis-color.png') ?>); background-size: cover;">
  <div class="offcanvas-header justify-content-between p-4">
    <p class="section-title text-white"></p>
    <div data-bs-dismiss="offcanvas" aria-label="Close" class="hvrbtn"><i class="ri-close-line fs-1 text-white"></i></div>
  </div>
  <div class="offcanvas-body">
    <div class="row content">
      <div class="col-lg-6">
        <div class="view-profile">
          <div class="card-employee">
            <img src="{{ url('public') }}{{ $item->profile_pic }}" alt="..." />
            <div class="card-employee-bg"></div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="text-white w-75">
          <h4 class="fw-bold">{{ $item->name }}</h4>
          <small class="">{{ $item->position }}</small>
          <br />
          <br />
          <br />
          {!! $item->description !!}
        </div>
        <br />
        <br />
        <br />
        <br />
        <br />
        <div class="w-75">
          <ul class="other-directors p-0">
            @foreach($data as $key_thum => $item_thumb)
            @if($key_thum != $key)
            <li><a href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas{{ $item_thumb->board }}{{ $key_thum }}" aria-controls="offcanvas{{ $item_thumb->board }}{{ $key_thum }}"><img src="{{ url('public') }}{{ $item_thumb->profile_pic }}" alt="..." /></a></li>
            @endif
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
@endforeach
@endpush