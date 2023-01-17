@extends('webmin.layouts.formbase')
@section('formelement')
<x-webmin.select2 name="id_menu" label="{{ __('form.menu') }}" placeholder="{{ __('form.select_menu') }}" value="{!! isset($pages->id_menu)? $pages->id_menu : '' !!}" :items="$parent" />
<x-webmin.input type="text" name="title" value="{!! isset($pages->title)? $pages->title : '' !!}" required="required" />
<x-webmin.texteditor name="content" value="{!! isset($pages->content)? $pages->content : '' !!}" />
<x-webmin.input type="text" name="meta_title" value="{!! isset($pages->meta_title)? $pages->meta_title : '' !!}"/>
<x-webmin.input type="text" name="meta_desc" value="{!! isset($pages->meta_desc)? $pages->meta_desc : '' !!}"/>
<x-webmin.input type="text" name="meta_keyword" value="{!! isset($pages->meta_keyword)? $pages->meta_keyword : '' !!}"/>
@endsection