@extends('webmin.layouts.formbase')
@section('formelement')
<x-webmin.input type="text" name="title" value="{!! isset($contact_us_to->title)? $contact_us_to->title : '' !!}" required="required" />
<x-webmin.input type="text" name="email" value="{!! isset($contact_us_to->email)? $contact_us_to->email : '' !!}" required="required" />
@endsection
