@extends('layouts.admin')

@section('content')
    <h1>Edit Post</h1>
    {{--{{$post->id}}--}}
    <div class="col-sm-3">
        <img src="{{$post->photos->first() ? ($post->photos->first())['path'] : 'https://via.placeholder.com/400x400'}}"
             alt=""
             class="img-responsive img-rounded">
    </div>
    <div class="col-sm-9">
        {!! '</br>' !!}
        {!! Form::model($post,['method'=>"PUT", 'action'=>["App\Http\Controllers\AdminPostsController@update",$post->id], 'files'=>true]) !!}
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
            {!! Form::select('categories[]', [''=>'Choose All That Apply'] + $categories,  null, ['class' => 'form-control', 'multiple']) !!}
        </div>
        {!! '</br>' !!}
        <div class="form-group">
            {!! Form::label('photo', 'Photo') !!}
            {!! Form::file('photo', null, ['class'=>'form-control']) !!}
        </div>
        {!! '</br>' !!}{!! '</br>' !!}
        {{--//ZA SNIPET SUBMIT ////////////--}}
        <div class="form-group">
            {!! Form::submit('Update Post',['class'=>'btn btn-primary']) !!}
            {!! Form::close() !!}
            {!! '</br>' !!}
            {{--//DELETE FORM--}}
            {!! Form::open(['method'=>'DELETE',
            'action'=>['App\Http\Controllers\AdminPostsController@destroy', $post->id]]) !!}
            {!! Form::submit('Delete this Post',
                ['class'=>'btn btn-danger', 'style'=>'float: right; margin-top: -20px;']) !!}
            {{--['class'=>'btn btn-danger', 'style'=>'float: right;margin-top: -40px;']) !!}--}}
            {!! Form::close() !!}
        </div>
        {{--/////////////////////////////--}}
        @include('includes.display-form-errors')
    </div>
@endsection