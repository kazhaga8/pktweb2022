<div class="as-is-it col-lg-6 pt-4 pt-lg-0">
    <div class="d-flex justify-content-between">
        @if(isset($ebook))
        @foreach($ebook as $key => $item)
        <div class="box-book-investor">
            <div class="report-investor text-center">
                <img class="border-dark w-100" src="{{ url('public') }}{{ $item->image }}" alt="{{ $item->title }}" />
                <p class="fs-5 my-2">{{ $item->title }}</p>
                <div class="d-flex justify-content-center">
                    <div class="zoom-pdf btn-pdf act-ebooks-preview">
                        <a href="{{ url('public') }}{{ $item->file }}" target="_blank">
                            <i class="ri-zoom-in-line text-white"></i>
                        </a>
                    </div>
                    <div class="download-pdf btn-pdf act-files-download">
                        <a href="{{ url('public') }}{{ $item->file }}">
                            <i class="ri-file-download-line text-white"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @if($key % 3 == 0)
    </div>
    <div class="d-flex justify-content-between">
    @endif
    @endforeach
    @endif
    </div>
</div>
