<section>
  <div class="container" data-aos="fade-up">
    <div class="px-4">
      <p class="section-title d-flex align-items-center">
        <span class="me-3">{{ __('web.title-empowerment') }}</span>
      </p>
    </div>
    <div class="row content justify-content-center" id="empowerment-card">
    </div>
    <div class="text-center">
      <button type="button" id="load-more-empowerment" data-page="2" class="btn btn-primary btn-animate mt-4">{{ __('web.load-more') }}</button>
    </div>
  </div>
</section>
<div id="empowerment-card-detail"></div>

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

  function getEmpo($page = '') {
    $.ajax({
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      method: "POST",
      url: "{{ url('get-empowerment') }}",
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
        $('#empowerment-card').html(card);
        $('#empowerment-card-detail').html(cardDetail);
      } else {
        $('#empowerment-card').append(card);
        $('#empowerment-card-detail').append(cardDetail);
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
        $('#load-more-empowerment').show();
        $('#load-more-empowerment').attr('data-page', searchParams.page)
      } else {
        $('#load-more-empowerment').hide();
      }

    }).catch((error) => {
      console.log(error)
    });
  }
  $(document).ready(function() {
    getEmpo("1");
    $('#load-more-empowerment').on('click', function() {
      var page = $(this).attr('data-page');
      getEmpo(page);
    });
  });
</script>
@endpush
