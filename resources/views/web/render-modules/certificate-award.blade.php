<section>
  <div class="container" data-aos="fade-up">
    <div class="px-4">
      <p class="section-title d-flex align-items-center">
        <span class="me-3">{{ __('web.award') }}</span>
      </p>
      <div class="p-2 mb-4">
      <select class="form-select w-25" id="select-year">
          <option value="">{{ __('web.all') }}</option>
          @foreach($year as $item)
          <option value="{{ $item->year }}">{{ $item->year }}</option>
          @endforeach
      </select>
      </div>
      <div class="box-categories-news">
        <ul class="categories-news d-flex p-0 m-0">
          <li data-year="" class="toggle-category active">{{ __('web.all') }}</li>
          <li data-category="award" class="toggle-category">{{ __('web.award') }}</li>
          <li data-category="certification" class="toggle-category">{{ __('web.certification') }}</li>

        </ul>
      </div>
    </div>
    <br />
    <div class="row content justify-content-center" id="certificate-card">
    </div>
    <div class="text-center">
      <button type="button" id="load-more-certificate" data-page="2" class="btn btn-primary btn-animate mt-4">{{ __('web.load-more') }}</button>
    </div>
  </div>
</section>
<div id="certificate-card-detail"></div>

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

  function getAward($page = '', $year = '', $category = '') {
    $.ajax({
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      method: "POST",
      url: "{{ url('get-certificate') }}",
      data: JSON.stringify({
        "locale": "{{ $locale }}",
        "year": $year,
        "category": $category,
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
        $('#certificate-card').html(card);
        $('#certificate-card-detail').html(cardDetail);
      } else {
        $('#certificate-card').append(card);
        $('#certificate-card-detail').append(cardDetail);
      }
      if (next_page_url) {
        const searchParams = getQueryParams(next_page_url);
        $('#load-more-certificate').show();
        $('#load-more-certificate').attr('data-page', searchParams.page)
      } else {
        $('#load-more-certificate').hide();
      }

    }).catch((error) => {
      console.log(error)
    });
  }
  $(document).ready(function() {
    getAward("1", "", "");

    $('#select-year').on('change', function() {
      var year = $(this).val();
      var category = $('.toggle-category.active').attr('data-category');
      getAward(1, year, category);
    });
    $('.toggle-category').on('click', function() {
      $('.toggle-category').removeClass('active');
      $(this).addClass('active');
      var category = $(this).attr('data-category');
      var year = $('#select-year').val();
      getAward(1, year, category);
    });
    $('#load-more-certificate').on('click', function() {
      var page = $(this).attr('data-page');
      var year = $('#select-year').val();
      var category = $('.toggle-category.active').attr('data-category');
      getAward(page, year, category);
    });
  });
</script>
@endpush
