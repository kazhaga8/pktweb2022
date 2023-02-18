@extends('web.layouts.base')

@section('content')
@foreach ($pages as $page)
{!! renderPage($page, $locale) !!}
@endforeach
@endsection

@push('javascript')
<script>
  if($('.act-ebooks-preview').length) {
    $('.act-ebooks-preview').each(function() {
        const btn = $(this).find('a');
        const href = btn.attr('href');
        if(href !== '' && href !== '#'){
            const files = href.split('/').slice(-1)[0]
            const dir = href.replace("{{ url('public') }}", "").replace(files, "");
            const ebook = "{{ route('ebook.index') }}";
            const newHref = ebook + '/' + files + '?v='+btoa(dir);
            btn.attr('href', newHref);
        }
    })
  }
  if($('.act-files-download').length) {
    $('.act-files-download').each(function() {
        const btn = $(this).find('a');
        const href = btn.attr('href');
        if(href !== '' && href !== '#'){
            const files = href.split('/').slice(-1)[0]
            const dir = href.replace("{{ url('public') }}", "").replace(files, "");
            const download = "{{ route('download-file.index') }}";
            const newHref = download + '/' + files + '?v='+btoa(dir);
            btn.attr('href', newHref);
        }
    })
  }
</script>
@endpush
