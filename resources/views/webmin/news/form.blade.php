@extends('webmin.layouts.formbase')
@section('formelement')
<x-webmin.select2 name="id_category" label="{{ __('form.category') }}" placeholder="{{ __('form.select_category') }}" value="{!! isset($news->id_category)? $news->id_category : '' !!}" :items="$parent" />
<x-webmin.input type="text" name="title" value="{!! isset($news->title)? $news->title : '' !!}" required="required" />
<x-webmin.texteditor name="content" value="{!! isset($news->content)? $news->content : '' !!}" />
<x-webmin.input type="text" name="meta_title" value="{!! isset($news->meta_title)? $news->meta_title : '' !!}" />
<x-webmin.input type="text" name="meta_desc" value="{!! isset($news->meta_desc)? $news->meta_desc : '' !!}" />
<x-webmin.input type="text" name="meta_keyword" value="{!! isset($news->meta_keyword)? $news->meta_keyword : '' !!}" />
@endsection