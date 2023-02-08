@extends('webmin.layouts.formbase')
@section('formelement')
	<x-webmin.input type="text" name="title" value="{!! isset($slider->title)? $slider->title : '' !!}" required="required" />
	<x-webmin.input-file name="image" type="1" value="{{ isset($slider->image)? $slider->image : '' }}" required="{{ $page['method'] == 'PUT'?'':'required' }}" />
	<input type="hidden" name="position" value="bottom" />
@endsection