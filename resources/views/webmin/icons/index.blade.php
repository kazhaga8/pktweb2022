@extends('webmin.layouts.base')
@section('content')

<div class="row m-t-20 m-b-20">
    <div class="col-sm-6 col-sm-offset-3">
        <div class="form-group search-box">
            <input type="text" id="search-input" class="form-control product-search" placeholder="Search here...">
            <button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="">

            <div class="card-box">

                <h4 class="m-t-0 header-title">Examples</h4>
                <p class="text-muted m-b-30 font-13">
                    Use <code>&lt;i class="ri-account-box-fill"&gt;&lt;/i&gt;</code>.
                </p>
                <div class="row icon-list-demo icons-container" id="icon-list">
                    <div class="col-sm-6 col-md-4 col-lg-3 text-danger" id="no-matching-result">
                        Sorry, no match found for given name
                    </div>
                </div>
                <!-- End row -->
            </div> <!-- end panel-body -->
        </div> <!-- Panel-default-->
    </div> <!-- col-->
</div> <!-- End row -->

@endsection

@section('css')
<link href="{{ url('public') }}/assets/web/vendor/remixicon/remixicon.css" rel="stylesheet" type="text/css">
@endsection

@section('js')

<script src="{{ url('public') }}/assets/js/jquery.icons.js"></script>
@endsection

@section('javascript')
<script>
    $(document).ready(function() {
        var icons = [];
        var cssRules = document.styleSheets[1].cssRules;
        for (var i = 0; i < cssRules.length; i++) {
            var icon = document.createElement("i");
            var selectorText = cssRules[i].selectorText;
            if (selectorText && selectorText.match(/^\.ri-[a-z_-]+::before+$/)) {
                icons.push(selectorText.replace('::before', ''));
                icon.className = selectorText.replace('::before', '').substring(1);
                var iconList = '<div class="col-sm-6 col-md-4 col-lg-3">' +
                    '<i class="' + icon.className + '"></i> ' + icon.className + '' +
                    '</div>';
                $("#icon-list").append(iconList);
            }
        }
    });
</script>
@endsection
