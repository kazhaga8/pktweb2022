<section>
  <div class="container" data-aos="fade-up">
    <div class="px-4">
      <p class="section-title d-flex align-items-center">
        <span class="me-3">{{ __('web.title-tjsl') }}</span>
      </p>
    </div>
    <div class="row content" id="tjsl-card">
    </div>
    <div class="text-center">
      <button type="button" id="load-more-tjsl" data-page="2" class="btn btn-primary btn-animate mt-4">{{ __('web.load-more') }}</button>
    </div>
  </div>
</section>
<div id="tjsl-card-detail"></div>

@push('javascript')
<script>
  function getQueryParams(url) {
    const paramArr = url.slice(url.indexOf('?') + 1).split('&');
    const params = {};
    paramArr.map(param => {
      const [key, val] = param.split('=');
      params[key] = decodeURIComponent(val);
    })
    return params;
  }

  function getTjsl($page = '') {
    $.ajax({
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      method: "POST",
      url: "{{ url('get-tjsl') }}",
      data: JSON.stringify({
        "locale": "{{ $locale }}",
        "limit": 9,
        "page": $page,
      })
    }).then((response) => {
      const {
        data: result,
        card,
        'card-detail': cardDetail
      } = response;
      const {
        current_page,
        next_page_url
      } = result;

      if (current_page === 1) {
        $('#tjsl-card').html(card);
        $('#tjsl-card-detail').html(cardDetail);
      } else {
        $('#tjsl-card').append(card);
        $('#tjsl-card-detail').append(cardDetail);
      }
      if ($('.act-ebooks-preview').length) {
        $('.act-ebooks-preview').each(function() {
          const btn = $(this).find('a');
          const href = btn.attr('href');
          if (href !== '' && href !== '#') {
            const files = href.split('/').slice(-1)[0]
            const dir = href.replace("{{ url('public') }}", "").replace("../../public", "").replace(files, "");
            const ebook = "{{ route('ebook.index') }}";
            const newHref = ebook + '/' + files + '?v=' + btoa(dir);
            btn.attr('href', newHref);
          }
        })
      }
      if ($('.act-files-download').length) {
        $('.act-files-download').each(function() {
          const btn = $(this).find('a');
          const href = btn.attr('href');
          if (href !== '' && href !== '#') {
            const files = href.split('/').slice(-1)[0]
            const dir = href.replace("{{ url('public') }}", "").replace("../../public", "").replace(files, "");
            const download = "{{ route('download-file.index') }}";
            const newHref = download + '/' + files + '?v=' + btoa(dir);
            btn.attr('href', newHref);
          }
        })
      }
      if (next_page_url) {
        const searchParams = getQueryParams(next_page_url);
        $('#load-more-tjsl').show();
        $('#load-more-tjsl').attr('data-page', searchParams.page)
      } else {
        $('#load-more-tjsl').hide();
      }

    }).catch((error) => {
      console.log(error)
    });
  }
  $(document).ready(function() {
    getTjsl("1");
    $('#load-more-tjsl').on('click', function() {
      var page = $(this).attr('data-page');
      getTjsl(page);
    });
  });
</script>
@endpush
