@extends('webmin.layouts.formbase')
@section('formelement')

<x-webmin.input type="text" name="name" value="{!! isset($role->name)? $role->name : '' !!}" required="true" />

<div class="col-xs-12 col-sm-12 col-md-12 form-group m-b-20">
    <label for="inputPermission">Permission</label>
    <br>
    <div class="row">
        @foreach($akses as $key => $roles)
        <div class="col-lg-3">
            <div class="panel panel-border panel-inverse">
                <div class="panel-heading">
                    <h3 class="panel-title">{{$key}}</h3>
                </div>
                <div class="panel-body"></div>
                <ul class="list-group">
                    @foreach($roles as $value)
                    <li class="list-group-item">
                    <div class="checkbox checkbox-primary">
                        <input type="checkbox" name="permission[]" id="{{$value->name.$value->id}}" value="{{$value->id}}" {{isset($rolePermissions) && in_array($value->id, $rolePermissions) ? 'checked' : ''}} >
                        <label for="{{$value->name.$value->id}}">{{$value->name}}</label>
                    </div>

                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        @endforeach
    </div>
</div>
@endsection