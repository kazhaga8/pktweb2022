<section>
  <div class="container" data-aos="fade-up">
    <div class="py-2 mb-4">
      <select id="select-category" class="form-select w-25">
        <option value="">Semua Tahun</option>
        @if(isset($year))
        @foreach($year as $item)
        <option value="{{ $item->year }}">{{ $item->year }}</option>
        @endforeach
        @endif
      </select>
    </div>

    <div class="box-categories-news">
      <ul class="categories-news d-flex p-0 m-0">
        <li data-category="" class="toggle-category active">Semua Gallery</li>
        @if(isset($category))
        @foreach($category as $item)
        <li data-category="{{ $item->id }}" class="toggle-category">{{ $item->title }}</li>
        @endforeach
        @endif
      </ul>
    </div>
    <br />
    <div class="row content" id="gallery-card">
    </div>
    <div class="text-center">
      <button type="button" id="load-more-gallery" data-page="2" class="btn btn-primary btn-animate mt-4">{{ __('web.load-more') }}</button>
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

  function getCategory($page = '', $year = '', $cat = '') {
    $.ajax({
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      method: "POST",
      url: "{{ url('get-gallery') }}",
      data: JSON.stringify({
        "locale": "{{ $locale }}",
        "year": $year,
        "category": $cat,
        "limit": 9,
        "page": $page,
      })
    }).then((response) => {
      const {
        data: result,
        card,
      } = response;
      const {
        current_page,
        next_page_url
      } = result;
      if (current_page === 1) {
        $('#gallery-card').html(card);
      } else {
        $('#gallery-card').append(card);
      }
      if (next_page_url) {
        const searchParams = getQueryParams(next_page_url);
        $('#load-more-gallery').show();
      } else {
        $('#load-more-gallery').hide();
      }

    }).catch((error) => {
      console.log(error)
    });
  }
  $(document).ready(function() {
    getCategory("1", "", "");

    $('#select-category').on('change', function() {
      console.log('select-category');
      var year = $(this).val();
      var cat = $('.toggle-category.active').attr('data-category');
      getCategory(1, year, cat);
    });
    $('.toggle-category').on('click', function() {
      $('.toggle-category').removeClass('active');
      $(this).addClass('active');
      var year = $('#select-category').val();
      var cat = $(this).attr('data-category');
      getCategory(1, year, cat);
    });
    $('#load-more-gallery').on('click', function() {
      var page = $(this).attr('data-page');
      var year = $('#select-category').val();
      var cat = $('.toggle-category.active').attr('data-category');
      getCategory(page, year, cat);
    });
  });
</script>
@endpush