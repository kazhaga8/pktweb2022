@extends('webmin.layouts.formbase')
@section('formelement')
<x-webmin.input type="text" name="title" value="{!! isset($shortcut->title)? $shortcut->title : '' !!}" required="required" />
<x-webmin.input type="text" name="link" value="{!! isset($shortcut->href)? $shortcut->href : '' !!}" required="required" />

@endsection