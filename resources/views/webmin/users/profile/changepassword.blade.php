
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
                @input(['type'=>'email','name'=>'email','value'=>(isset($user->email))?$user->email:'','required'=>true,'disabled'=>true])
                @input(['type'=>'password','name'=>'password_current','value'=>'','required'=>true])
                @input(['type'=>'password','name'=>'password','value'=>'','required'=>true])
                @input(['type'=>'password','name'=>'password_confirmation','value'=>'','required'=>true])
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary waves-effect waves-light"><i class="fa fa-check"></i> Save</button>
                    <a href="{{ route('dashboard') }}" class="btn btn-default waves-effect waves-light"><i class="fa fa-close"></i> Discard</a>
                </div>
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