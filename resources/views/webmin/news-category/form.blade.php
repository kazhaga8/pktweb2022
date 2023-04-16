@extends('webmin.layouts.formbase')
@section('formelement')
<x-webmin.input type="text" name="title" value="{!! isset($news_category->title)? $news_category->title : '' !!}" required="required" />
@endsection
