@extends('web.layouts.base')

@section('content')

<section>
    <div class="container" data-aos="fade-up">
        <div class="row content">
            <div class="col-lg-12 pt-4 pt-lg-0">
                <h3 class="fs-4 fw-lighter mb-3">
                    {{ __('web.search-result') }} : {{ request()->get('keyword') }}
                </h3>
                <div class="box-categories-news">
                    <ul class="categories-news d-flex p-0 m-0">
                        @foreach(array_keys($result) as $key => $value)
                        <li data-category="{{ $value }}" class="toggle-category {{ $key == 0 ? 'active' : '' }}">{{ $value }} ({{ $result[$value] }})</li>
                        @endforeach
                    </ul>
                </div>
                <ul id="search-result" class="p-0 mt-5" style="list-style: none"></ul>
                <div class="text-center">
                    <button type="button" data-page="2" class="btn btn-primary btn-animate mt-4" id="load-more-search">{{ __('web.load-more') }}</button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


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

    function getSearch($page = '', $cat = '') {
        $.ajax({
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            method: "POST",
            url: "{{ route('web.get-search', [$locale]) }}",
            data: JSON.stringify({
                "locale": "{{ $locale }}",
                "keyword": "{{ request()->get('keyword') }}",
                "category": $cat,
                "limit": 9,
                "page": $page,
            })
        }).then((response) => {
            const {
                data: result,
                blade,
            } = response;
            const {
                current_page,
                next_page_url
            } = result;
            if (current_page === 1) {
                $('#search-result').html(blade);
            } else {
                $('#search-result').append(blade);
            }
            if (next_page_url) {
                const searchParams = getQueryParams(next_page_url);
                $('#load-more-search').show();
                $('#load-more-search').attr('data-page', searchParams.page)
            } else {
                $('#load-more-search').hide();
            }

        }).catch((error) => {
            console.log(error)
        });
    }
    $(document).ready(function() {
        var cat = $('.toggle-category.active').attr('data-category');
        getSearch("1", cat);

        $('.toggle-category').on('click', function() {
            $('.toggle-category').removeClass('active');
            $(this).addClass('active');
            var cat = $(this).attr('data-category');
            getSearch(1, cat);
        });
        $('#load-more-search').on('click', function() {
            var page = $(this).attr('data-page');
            var cat = $('.toggle-category.active').attr('data-category');
            getSearch(page, cat);
        });
    });
</script>
@endpush
