@extends('webmin.layouts.base')
@section('content')
<div class="row">
  <div class="col-sm-12">
    <iframe class="i-files" src="{{ url('public') }}/plugins/responsivefilemanager/filemanager/dialog.php?user_acc={{ Auth::user()->id }}" frameborder="0" width="100%" height="100%"></iframe>
  </div>
</div>
@endsection

@section('css')
<style>
  .i-files {
    height: 800px;
    width: 100%;
    border: none;
    overflow: hidden;
  }
</style>
@endsection

@section('js')
@endsection

@section('javascript')
@endsection