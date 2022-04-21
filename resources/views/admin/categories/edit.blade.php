@extends('layouts.admin');
@section('content')
    <h1>Edit/Delete Category</h1>
    <div class="col-sm-6">
        {!! Form::model($category,['method'=>"PUT",
        'action'=>["App\Http\Controllers\AdminCategoriesController@update",$category->id]]) !!}
        <div class="form-group">
            {!! Form::label('name', 'Name') !!}
            {!! Form::text('name', null, ['class'=>'form-control']) !!}
        </div>
        {{--//ZA SNIPET SUBMIT ////////////--}}
        <div class="form-group">
            {!! Form::submit('Update Category',['class'=>'btn btn-primary coll-sm-3']) !!}
        </div>
        {!! Form::close() !!}

        {{--DELETE FORM--}}
        <div class="form-group">
            {!! Form::open(['method'=>'DELETE',
            'action'=>['App\Http\Controllers\AdminCategoriesController@destroy', $category->id]]) !!}
            {!! Form::submit('Delete Category',
            ['class'=>'btn btn-danger coll-sm-3', 'style'=>'float: right;margin-top: -40px;']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
