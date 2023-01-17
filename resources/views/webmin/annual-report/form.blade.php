@extends('webmin.layouts.formbase')
@section('formelement')
<x-webmin.input type="text" name="title" label="{{ __('form.year') }}" value="{!! isset($ebook->title)? $ebook->title : '' !!}" required="required" />
<x-webmin.input-file name="image" value="{{ isset($ebook->image)? $ebook->image : '' }}" required="{{ $page['method'] == 'PUT'?'':'required' }}" />
<x-webmin.input-file name="file" value="{{ isset($ebook->file)? $ebook->file : '' }}" required="{{ $page['method'] == 'PUT'?'':'required' }}" />
<input type="hidden" name="type" value="e-magazine" />
@endsection