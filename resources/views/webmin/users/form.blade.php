@extends('webmin.layouts.formbase')
@section('formelement')
@input(['type'=>'text','name'=>'name','value'=>(isset($user->name))?$user->name:'','required'=>true])
@input(['type'=>'text','name'=>'username','value'=>(isset($user->username))?$user->username:'','required'=>true])
@input(['type'=>'email','name'=>'email','value'=>(isset($user->email))?$user->email:'','required'=>true])
@if($page['method']!='PUT')
@input(['type'=>'password','name'=>'password','value'=>'','required'=>(isset($page['method']) && $page['method'] == "PUT"?false:true)])
@input(['type'=>'password','name'=>'password_confirmation','value'=>'','required'=>(isset($page['method']) && $page['method'] == "PUT"?false:true)])
@endif
@select2(['items'=>$roles,'name'=>'roles','value'=>$userRole,'required'=>true])

@endsection