@extends('webmin.layouts.formbase')
@section('formelement')
<x-webmin.select2 name="id_category" label="{{ __('form.category') }}" placeholder="{{ __('form.select_category') }}" value="{!! isset($news->id_category)? $news->id_category : '' !!}" :items="$parent" />
<x-webmin.input type="text" name="title" value="{!! isset($news->title)? $news->title : '' !!}" required="required" />
<x-webmin.texteditor name="content" value="{!! isset($news->content)? $news->content : '' !!}" />
<x-webmin.input-file name="image" type="1" value="{{ isset($news->image)? $news->image : '' }}" required="{{ $page['method'] == 'PUT'?'':'required' }}" />
<x-webmin.datepicker label="{{ __('form.active_date') }}" name="active_date" value="{{ isset($news->active_date)? $news->active_date : '' }}" required="required"  />
<x-webmin.datepicker label="{{ __('form.exp_date') }}" name="exp_date" value="{{ isset($news->exp_date)? $news->exp_date : '' }}" />
<x-webmin.input type="text" label="{{ __('form.embed_yt') }}" name="embed" value="{!! isset($news->embed)? $news->embed : '' !!}" />
<x-webmin.input type="text" name="meta_title" value="{!! isset($news->meta_title)? $news->meta_title : '' !!}" />
<x-webmin.input type="text" name="meta_desc" value="{!! isset($news->meta_desc)? $news->meta_desc : '' !!}" />
<x-webmin.input type="text" name="meta_keyword" value="{!! isset($news->meta_keyword)? $news->meta_keyword : '' !!}" />
@endsection