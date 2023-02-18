<div class="box-report-investor as-is-it">
  @if(isset($ebook))
  @foreach($ebook as $item)
    <div class="report-investor text-center">
      <img class="border-dark w-100" src="{{ url('public') }}{{ $item->image }}" alt="{{ $item->title }}" />
      <p class="fs-5 my-2">{{ $item->title }}</p>
      <div class="d-flex justify-content-center">
        <div class="zoom-pdf btn-pdf">
          <a href="{{ url('public') }}{{ $item->file }}" target="_blank">
            <i class="ri-zoom-in-line text-white"></i>
          </a>
        </div>
        <div class="download-pdf btn-pdf">
          <a href="{{ url('public') }}{{ $item->file }}">
            <i class="ri-file-download-line text-white"></i>
          </a>
        </div>
      </div>
    </div>
  @endforeach
  @endif
</div>
