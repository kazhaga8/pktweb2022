@if (count($data))
@foreach($data as $key => $emag)
<div class="col-lg-4">
  <div class="card-cerficate">
    <a href="{{ $emag->file }}" target="_blank">
      <div class="image">
        <img src="{{ $emag->image }}" alt="{{ $emag->title }}" />
      </div>
      <div class="caption">
        <p>{{ $emag->title }}</p>
      </div>
    </a>
  </div>
</div>
@endforeach
@endif
