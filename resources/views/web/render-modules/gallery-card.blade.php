@if (count($data))
@foreach($data as $key => $item)
<div class="col-lg-4">
  <a href="{{ $item->media }}" title="{{ $item->title }}" data-gallery="dataGallery" class="card-cerficate galery-lightbox">
    <div class="image">
      <img src="{{ $item->image }}" alt="{{ $item->title }}" />
    </div>
    <div class="caption">
      <p>{{ $item->title }}</p>
      <label>{{ $item->year }}</label>
    </div>
  </a>
</div>
@endforeach
@endif

<script>
  GLightbox({
    selector: '.galery-lightbox'
  });
</script>