@extends('layouts.admin')

@section('content')

    <h1>Create Post page</h1>
    <div class="row">
    {!! Form::open(['method'=>"POST", 'action'=>"App\Http\Controllers\AdminPostsController@store", 'files'=>true]) !!}
    {!! '</br>' !!}
    <div class="form-group">
        {!! Form::label('title', 'Title') !!}
        {!! Form::text('title', null, ['class'=>'form-control']) !!}
    </div>

    {!! '</br>' !!}
    <div class="form-group">
        {!! Form::label('content', 'Content') !!}
        {!! Form::textarea('content', null, ['class'=>'form-control', 'rows'=>10, 'cols' => 10]) !!}
    </div>

    {!! '</br>' !!}
    <div class="form-group">
        {!! Form::label('categories', 'Category (Hold down the control (ctrl) button to select multiple options)') !!}
        {{--//BIRAMO SAMO JEDNU OPCIJU--}}
        {{--{!! Form::select('category_id', [''=>'Choose One Option'] + $categories,  null, ['class' => 'form-control', 'multiple']) !!}--}}
        {{--//BIRAMO VISE PONUDJENIH OPCIJA – SAMO TREBA TAJ NIZ DA UHVATIMO U STORE METODI KONTROLERA--}}
        {!! Form::select('categories[]', [''=>'Choose All That Apply'] + $categories,  null, ['class' => 'form-control', 'multiple']) !!}
    </div>

    {!! '</br>' !!}
    <div class="form-group">
        {!! Form::label('photo','Upload picture') !!}
        {!! Form::file('photo',null, ['class'=>'form-control']) !!}
    </div>

    {!! '</br>' !!}{!! '</br>' !!}
    {{--//////// SUBMIT ////////////--}}
    <div class="form-group">
        {!! Form::submit('Create Post',['class'=>'btn btn-primary']) !!}
    </div>
    {{--/////////////////////////////--}}
    {!! Form::close() !!}    {!! '</br>' !!}
    </div>
    <div class="row">
    @include('includes.display-form-errors')
    </div>
@stop


