<section>
  <div class="container news" data-aos="fade-up" id="e-magazine">
    <div class="px-2">
      <p class="section-title d-flex align-items-center">
        <span class="me-3">E-MAGAZINE</span>
      </p>
    </div>
    <div class="row content justify-content-center" id="emags-card"></div>
    <div class="text-center">
      <button type="button" id="load-more-emags" class="btn btn-primary btn-animate mt-4">{{ __('web.load-more') }}</button>
    </div>
  </div>
</section>
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

  function getEMagazine($page = '') {
    $.ajax({
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      method: "POST",
      url: "{{ url('get-e-magazine') }}",
      data: JSON.stringify({
        "locale": "{{ $locale }}",
        "limit": 9,
        "page": $page,
      })
    }).then((response) => {
      const { data: result, blade } = response;
      const { current_page, next_page_url } = result;
      if (current_page === 1) {
        $('#emags-card').html(blade);
      } else {
        $('#emags-card').append(blade);
      }
      if (next_page_url) {
        const searchParams = getQueryParams(next_page_url);
        $('#load-more-emags').show();
        $('#load-more-emags').attr('data-page', searchParams.page)
      } else {
        $('#load-more-emags').hide();
      }

    }).catch((error) => {
      console.log(error)
    });
  }
  $(document).ready(function() {
    getEMagazine("1");
    $('#load-more-emags').on('click', function() {
      var page = $(this).attr('data-page');
      getEMagazine(page);
    });
  });
</script>
@endpush
