@extends('webmin.layouts.formbase')
@section('formelement')
<x-webmin.input type="text" name="title" value="{!! isset($shortcut->title)? $shortcut->title : '' !!}" required="required" />
<x-webmin.input type="text" name="link" value="{!! isset($shortcut->href)? $shortcut->href : '' !!}" required="required" />
<x-webmin.input type="text" name="icon" value="{!! isset($shortcut->icon)? $shortcut->icon : '' !!}" required="required" />
<a id="icon-link"  class="text-muted font-10" href="{{ route('icons.index') }}" target="_blank"> List Icon <i class="ri-external-link-line"></i></a>

@endsection

@section('javascript')
<script>
    $(document).ready(function() {
        const link = $('#icon-link');
        const btnLink = link.clone();
        $('#groupicon').find("label").append(btnLink);
        link.remove();
    });
</script>
@endsection

@section('css')
<link href="{{ url('public') }}/assets/web/vendor/remixicon/remixicon.css" rel="stylesheet" type="text/css">
@endsection
