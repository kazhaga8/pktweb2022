<section>
  <div class="container" data-aos="fade-up">
    <div class="px-4">
      <p class="section-title d-flex align-items-center">
        <span class="me-3">{{ __('web.award') }}</span>
      </p>
      <div class="box-categories-news">
        <ul class="categories-news d-flex p-0 m-0">
          <li data-year="" class="toggle-year active">{{ __('web.all') }}</li>
          @if(isset($year))
          @foreach($year as $item)
          <li data-year="{{ $item->year }}" class="toggle-year">{{ $item->year }}</li>
          @endforeach
          @endif
        </ul>
      </div>
    </div>
    <br />
    <div class="row content" id="certificate-card">
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

  function getAward($page = '', $year = '') {
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
    getAward("1", "");

    $('.toggle-year').on('click', function() {
      $('.toggle-year').removeClass('active');
      $(this).addClass('active');
      var year = $(this).attr('data-year');
      getAward(1, year);
    });
    $('#load-more-certificate').on('click', function() {
      var page = $(this).attr('data-page');
      var year = $('.toggle-year.active').attr('data-year');
      getAward(page, year);
    });
  });
</script>
@endpush