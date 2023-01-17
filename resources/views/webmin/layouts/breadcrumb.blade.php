<div class="row">
    <div class="col-xs-12">
        <div class="page-title-box">
            <h4 class="page-title">{{ (isset($page['title']))?$page['title']:'' }}</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="{{ url('dashboard') }}">Dashboard</a>
                </li>
                <?php $segments = ''; ?>
                @for($i = 2; $i <= count(Request::segments()); $i++) 
                    <?php 
                    $segments .= '/' . Request::segment($i); 
                    $bctext = ucwords(Request::segment($i)) ;
                    ?> 
                    @if($i < count(Request::segments())) 
                    <li class="">
                        <a href="{{ url($segments) }}">{{ $bctext }}</a>
                    </li>
                    @else
                    <li class="active">{{ $bctext }}</li>
                    @endif
                @endfor
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- end row -->