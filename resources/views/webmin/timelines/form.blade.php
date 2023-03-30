@extends('webmin.layouts.formbase')
@section('formelement')
<x-webmin.input type="text" name="year" value="{!! isset($timeline->year)? $timeline->year : '' !!}" required="required" />
<x-webmin.input-file name="image" label="{{ __('form.image') }}" type="2" value="{{ isset($timeline->image)? $timeline->image : '' }}" required="required" />
<x-webmin.input type="text" name="title" value="{!! isset($timeline->title)? $timeline->title : '' !!}" required="required" />
<x-webmin.texteditor name="content" value="{!! isset($timeline->content)? $timeline->content : '' !!}" />
@endsection
