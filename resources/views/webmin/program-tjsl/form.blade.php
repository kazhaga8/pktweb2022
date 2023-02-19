@extends('webmin.layouts.formbase')
@section('formelement')
<x-webmin.input-file name="image" label="{{ __('form.image') }}" type="2" value="{{ isset($program_tjsl->image)? $program_tjsl->image : '' }}" required="required" />
<x-webmin.input type="text" name="title" value="{!! isset($program_tjsl->title)? $program_tjsl->title : '' !!}" required="required" />
<x-webmin.texteditor name="content" value="{!! isset($program_tjsl->content)? $program_tjsl->content : '' !!}" required="required" />
@endsection
