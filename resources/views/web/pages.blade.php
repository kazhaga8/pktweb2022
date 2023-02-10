@extends('web.layouts.base')

@section('content')
@foreach ($pages as $page)
{!! renderPage($page, $locale) !!}
@endforeach
@endsection