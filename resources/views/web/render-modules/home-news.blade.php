<div class="box-categories-news as-it-is">
  <ul class="categories-news d-flex p-0 m-0">
    <li data-category="" class="toggle-category active">{{ __('web.all') }}</li>
    @if(isset($category))
    @foreach($category as $item)
    <li data-category="{{ $item->id }}" class="toggle-category">{{ $item->title }}</li>
    @endforeach
    @endif
  </ul>
</div>
<div class="box-news-slide mt-4" id="news-card">
</div>


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

  function destroyCarousel() {
    if ($('.box-news-slide').hasClass('slick-initialized')) {
      $('.box-news-slide').slick('destroy');
    }
  }

  function slickNews() {
    $('.box-news-slide').slick({
      dots: true,
      infinite: false,
      speed: 300,
      autoplay: true,
      slidesToShow: 3,
      responsive: [{
          breakpoint: 768,
          settings: {
            arrows: false,
            centerMode: true,
            centerPadding: '20px',
            slidesToShow: 1
          }
        },
        {
          breakpoint: 480,
          settings: {
            arrows: false,
            centerMode: true,
            centerPadding: '20px',
            slidesToShow: 1
          }
        }
      ]
    });
  }

  function getCategory($page = '', $cat = '') {
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
        "placement": "home",
        "category": $cat,
        "limit": 9,
        "page": $page,
      })
    }).then((response) => {
      destroyCarousel();
      const {
        data: result,
        blade,
      } = response;
      const {
        current_page,
        next_page_url
      } = result;
      if (current_page === 1) {
        $('#news-card').html(blade);
      } else {
        $('#news-card').append(blade);
      }
      slickNews();
    }).catch((error) => {
      console.log(error)
    });
  }
  $(document).ready(function() {
    getCategory("1", "");

    $('.toggle-category').on('click', function() {
      $('.toggle-category').removeClass('active');
      $(this).addClass('active');
      var cat = $(this).attr('data-category');
      getCategory(1, cat);
    });
  });
</script>
@endpush
