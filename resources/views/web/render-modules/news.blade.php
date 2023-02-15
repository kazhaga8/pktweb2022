<section>
  <div class="container news" data-aos="fade-up" id="berita">
    <div class="p-2">
      <select class="form-select w-25" id="select-news">
        <option value="">{{ __('web.all') }}</option>
        @foreach($category as $cat)
        <option value="{{ $cat->id }}">{{ $cat->title }}</option>
        @endforeach
      </select>
    </div>
    <div id="news-card" class="row content justify-content-center"></div>
    <div class="text-center">
      <button type="button" id="load-more-news" data-page="2" class="btn btn-primary btn-animate mt-4">{{ __('web.load-more') }}</button>
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

  function getNews($page = '', $category = '') {
    $.ajax({
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      method: "POST",
      url: "{{ url('get-news') }}",
      data: JSON.stringify({
        "locale": "{{ $locale }}",
        "category": $category,
        "limit": 9,
        "page": $page,
      })
    }).then((response) => {
      const { data: result, blade } = response;
      const { current_page, next_page_url } = result;
      if (current_page === 1) {
        $('#news-card').html(blade);
      } else {
        $('#news-card').append(blade);
      }
      if (next_page_url) {
        const searchParams = getQueryParams(next_page_url);
        $('#load-more-news').show();
        $('#load-more-news').attr('data-page', searchParams.page)
      } else {
        $('#load-more-news').hide();
      }

    }).catch((error) => {
      console.log(error)
    });
  }
  $(document).ready(function() {
    getNews("1", "");

    $('#select-news').on('change', function() {
      var cat = $(this).val();
      getNews(1, cat);
    });
    $('#load-more-news').on('click', function() {
      var page = $(this).attr('data-page');
      var cat = $('#select-news').val();
      getNews(page, cat);
    });
  });
</script>
@endpush