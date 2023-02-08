@extends('webmin.layouts.formbase')
@section('formelement')
<x-webmin.select2 name="board" label="{{ __('form.board') }}" placeholder="{{ __('form.select_board') }}" value="{!! isset($management->board)? $management->board : '' !!}" :items="$boards" />
	<x-webmin.input type="text" name="name" value="{!! isset($management->name)? $management->name : '' !!}" required="required" />
	<x-webmin.input type="text" name="position" value="{!! isset($management->position)? $management->position : '' !!}" required="required" />
	<x-webmin.texteditor name="description" value="{!! isset($management->description)? $management->description : '' !!}" />
	<x-webmin.input-file name="profile_pic" type="1" value="{{ isset($management->profile_pic)? $management->profile_pic : '' }}" required="{{ $page['method'] == 'PUT'?'':'required' }}" />
	<x-webmin.input-file name="image" type="1" value="{{ isset($management->image)? $management->image : '' }}" />
@endsection