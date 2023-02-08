@extends('webmin.layouts.base')

@section('content')

<div class="row">
    <div class="col-lg-12">

        <div class="card-box">
            <div class="row">
                <div id="icon-list"></div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('css')
<link href="{{ url('public') }}/assets/web/vendor/remixicon/remixicon.css" rel="stylesheet" type="text/css">
@endsection

@section('js')
@endsection

@section('javascript')
<script>
    $(document).ready(function() {
        var icons = [];
        var cssRules = document.styleSheets[1].cssRules; // your bootstrap.css

        var divs = document.createElement("div");
        divs.className = "list-icon-styled"
        $("#icon-list").html(divs);
        for (var i = 0; i < cssRules.length; i++) {
            var icon = document.createElement("i");
            var selectorText = cssRules[i].selectorText;
            if (selectorText && selectorText.match(/^\.ri-[a-z_-]+::before+$/)) {
                icons.push(selectorText.replace('::before', ''));
                icon.className = selectorText.replace('::before', '').substring(1)
                // divs.appendChild(icon);
            }
        }
    });
</script>
@endsection