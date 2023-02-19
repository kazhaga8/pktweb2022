@extends('webmin.layouts.formbase')
@section('formelement')
<x-webmin.input-file name="image" label="{{ __('form.image') }}" type="2" value="{{ isset($program_empowerment->image)? $program_empowerment->image : '' }}" required="required" />
<x-webmin.input type="text" name="title" value="{!! isset($program_empowerment->title)? $program_empowerment->title : '' !!}" required="required" />
<x-webmin.texteditor name="content" value="{!! isset($program_empowerment->content)? $program_empowerment->content : '' !!}" required="required" />
@endsection
