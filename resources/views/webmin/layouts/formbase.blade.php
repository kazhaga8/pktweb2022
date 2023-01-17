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
				@if(!strpos($__env->yieldContent('formelement'),'type="submit"'))
				<div class="form-group mt-4">
					<button type="submit" class="btn btn-primary waves-effect waves-light"><i class="fa fa-check"></i> Save</button>
					<a href="{{ route($page['page'].'.index') }}" class="btn btn-default waves-effect waves-light"><i class="fa fa-close"></i> Discard</a>
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