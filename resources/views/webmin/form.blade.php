@extends('webmin.layouts.base')
@section('content')

<div class="card-box">
    <div class="row m-t-50">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
            <div class="alert alert-warning hidden fade in">
                <h4>Oh snap!</h4>
                <p>This form seems to be invalid :(</p>
            </div>

            <div class="alert alert-info hidden fade in">
                <h4>Yay!</h4>
                <p>Everything seems to be ok :)</p>
            </div>

            <form id="demo-form" data-parsley-validate="">
            @csrf
                @input(['type'=>'text','name'=>'fullname','value'=>'','required'=>true])
                @input(['type'=>'email','name'=>'email','value'=>'','required'=>true])
                @select(['name'=>'heard','value'=>'','required'=>true, 'items'=>['male','female']])
                @select2(['name'=>'heard2','value'=>'','required'=>true, 'items'=>['male','female']])
                @radio(['name'=>'gender','value'=>'','required'=>true, 'items'=>['male','female']])
                @checkbox(['name'=>'hobbies','value'=>'','required'=>true, 'items'=>['ski','run','eat']])
                @textarea(['name'=>'message','value'=>'','required'=>false])
                @texteditor(['name'=>'editor','value'=>'','required'=>false])
                @inputfile(['type'=>'text','name'=>'email','value'=>'','required'=>true,'multiple'=>true,'dragndrop'=>true,'allowext'=>['jpg', 'jpeg', 'png', 'gif', 'psd','pdf']])
                @inputfile(['type'=>'text','name'=>'email','value'=>'','required'=>true,'multiple'=>true,'dragndrop'=>false,'allowext'=>['jpg', 'jpeg', 'png', 'gif', 'psd','pdf']])
                @datepicker(['name'=>'datepicker','value'=>'','required'=>true])
                @datepickerrange(['name'=>'datepickerrange','value'=>'21/05/2020 - 26/05/2020','required'=>true])
                <div class="form-group">
                    <input type="submit" class="btn btn-success" value="validate">
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
    $(function() {
        $('#demo-form').parsley().on('field:validated', function() {
                var ok = $('.parsley-error').length === 0;
                $('.alert-info').toggleClass('hidden', !ok);
                $('.alert-warning').toggleClass('hidden', ok);
            })
            .on('form:submit', function() {
                return false; // Don't submit form for this demo
            });
    });
</script>
@endsection
