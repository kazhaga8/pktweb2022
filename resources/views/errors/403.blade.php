@extends('webmin.layouts.base')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="error-page m-t-40">
            <div>
                <h1 data-h1="403">403</h1>
                <p data-p="FORBIDDEN">FORBIDDEN</p>
                <p>{{ $exception->getMessage() }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')

<link href="{{ url('public') }}/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="{{ url('public') }}/assets/css/core.css" rel="stylesheet" type="text/css" />
<link href="{{ url('public') }}/assets/css/errorpage.min.css" rel="stylesheet" type="text/css" />

@endsection

@section('js')
@endsection

@section('javascript')
@endsection
