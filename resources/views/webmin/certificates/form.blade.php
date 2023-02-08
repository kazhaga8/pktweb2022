@extends('webmin.layouts.formbase')
@section('formelement')
<x-webmin.input type="number" name="year" value="{!! isset($certificate->year)? $certificate->year : '' !!}" required="required" />
<x-webmin.input-file name="image" label="{{ __('form.image') }}" type="2" value="{{ isset($certificate->image)? $certificate->image : '' }}" required="required" />
<x-webmin.input type="text" name="title" value="{!! isset($certificate->title)? $certificate->title : '' !!}" required="required" />
<x-webmin.texteditor name="content" value="{!! isset($certificate->content)? $certificate->content : '' !!}" />
@endsection