@extends('layouts.admin')

@section('content')
    <h1>Create User</h1>
    <div class="row">
    {!! Form::open(['method'=>"POST", 'action'=>"App\Http\Controllers\AdminUsersController@store", 'files'=>true]) !!}
    <div class="form-group">
        {!! Form::label('name', 'Name') !!}
        {!! Form::text('name', null, ['class'=>'form-control']) !!}
    </div>
    {!! '</br>' !!}
    <div class="form-group">
        {!! Form::label('email', 'Email') !!}
        {!! Form::email('email', null, ['class'=>'form-control']) !!}
    </div>
    {!! '</br>' !!}
    <div class="form-group">
        {!! Form::label('password', 'Password') !!} {!! '</br>' !!}
        {!! Form::password('password', null, ['class'=>'form-control']) !!}
    </div>
    {!! '</br>' !!}
    <div class="form-group">
        {!! Form::label('role_id', 'Role') !!}{!! '</br>' !!}
        {{--MOZE I OVAKO ALI JE BOLJE KAO OVO NIZE--}}
        {{--{!! Form::select('role_id', array(1=>'Administrator', 2=>'Author', 3=>'Subscriber'), null, ['class'=>'form-control']) !!}--}}
        {!! Form::select('role_id', [''=>'Choose Options'] + $roles, ['class'=>'form-control']) !!}
    </div>
    {!! '</br>' !!}
    <div class="form-group">
        {!! Form::label('is_active', 'Status') !!}
        {!! Form::select('is_active', array(1=>'Active', 0=>'Not Active'), 0, ['class'=>'form-control']) !!}
    </div>
    {!! '</br>' !!}
    <div class="form-group">
        {!! Form::label('photo','Upload picture') !!}
        {!! Form::file('photo', null, ['class'=>'form-control']) !!}
    </div>
    {!! '</br>' !!}{!! '</br>' !!}
    <div class="form-group">
        {!! Form::submit('Create User',['class'=>'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
{!! '</br>' !!}
    </div>
    <div class="row">
   @include('includes.display-form-errors')
    </div>
@stop