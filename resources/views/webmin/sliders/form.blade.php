@extends('webmin.layouts.formbase')
@section('formelement')
	<x-webmin.input type="text" name="title" value="{!! isset($slider->title)? $slider->title : '' !!}" required="required" />
	<x-webmin.textarea name="description" value="{{ isset($slider->description)? $slider->description : '' }}" />
	<x-webmin.input-file name="image" value="{{ isset($slider->image)? $slider->image : '' }}" required="{{ $page['method'] == 'PUT'?'':'required' }}" />
@endsection