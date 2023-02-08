@extends('webmin.layouts.base')

@section('content')

<div class="card-box">
	<div class="row m-t-50">
		<div class="col-sm-2"></div>
		<div class="col-sm-8">
			@if ($errors->any())
			<div class="alert alert-danger">
				<ul>
					@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
			@endif
			<form action="{{ $page['action'] }}" method="POST" enctype="multipart/form-data">
				@csrf
				@method($page['method'])
				@yield('formelement')
				<x-webmin.input-file name="main_logo" label="{{ __('form.main_logo') }}" type="2" value="{{ isset($config->main_logo)? $config->main_logo : '' }}" />
				<x-webmin.input-file name="secondary_logo" label="{{ __('form.secondary_logo') }}" type="2" value="{{ isset($config->secondary_logo)? $config->secondary_logo : '' }}" />
				<x-webmin.texteditor name="content_footer_en" label="{{ __('form.content_footer') }} EN" value="{!! isset($config->content_footer_en)? $config->content_footer_en : '' !!}" equired="required" />
				<x-webmin.texteditor name="content_footer_id" label="{{ __('form.content_footer') }} ID" value="{!! isset($config->content_footer_id)? $config->content_footer_id : '' !!}" equired="required" />
				<x-webmin.texteditor name="content_shortcut_en" label="{{ __('form.content_shortcut') }} EN" value="{!! isset($config->content_shortcut_en)? $config->content_shortcut_en : '' !!}" equired="required" />
				<x-webmin.texteditor name="content_shortcut_id" label="{{ __('form.content_shortcut') }} ID" value="{!! isset($config->content_shortcut_id)? $config->content_shortcut_id : '' !!}" equired="required" />
				<x-webmin.input type="text" name="meta_title" value="{!! isset($config->meta_title)? $config->meta_title : '' !!}" />
				<x-webmin.input type="text" name="meta_desc" value="{!! isset($config->meta_desc)? $config->meta_desc : '' !!}" />
				<x-webmin.input type="text" name="meta_keyword" value="{!! isset($config->meta_keyword)? $config->meta_keyword : '' !!}" />
				@if(!strpos($__env->yieldContent('formelement'),'type="submit"'))
				<div class="form-group mt-4">
					<button type="submit" class="btn btn-primary waves-effect waves-light"><i class="fa fa-check"></i> Save</button>
				</div>
				@endif
			</form>
		</div>
		<div class="col-sm-2"></div>
	</div>
</div>
@endsection

@section('css')
@endsection
@section('js')
<!-- Jquery validation js -->
<script type="text/javascript" src="{{ url('public') }}/plugins/parsleyjs/parsley.min.js"></script>
@endsection
@section('javascript')
<script type="text/javascript">
	$(document).ready(function() {
		$('form').parsley();
	});
</script>
@endsection