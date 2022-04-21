@extends('layouts.admin');
@section('content')
    @if(Session::has('deleted_category'))
        <div class="alert alert-warning " role="alert">
            <p class="bg-danger" style="color:white;font-size:15px;">{{Session::get('deleted_category')}}</p>
        </div>
    @endif

    <h1>Categories</h1>
    @if(Session::has('created_category'))
        <div class="alert alert-warning " role="alert">
            <p class="bg-primary" style="color:white;font-size:15px;">{{Session::get('created_category')}}</p>
        </div>
    @endif
    @if(Session::has('updated_category'))
        <div class="alert alert-warning " role="alert">
            <p class="bg-primary" style="color:white;font-size:15px;">{{Session::get('updated_category')}}</p>
        </div>
    @endif
    <div class="col-sm-6">
        {!! Form::open(['method'=>"POST", 'action'=>"App\Http\Controllers\AdminCategoriesController@store"]) !!}
        <div class="form-group">
            {!! Form::label('name', 'Name') !!}
            {!! Form::text('name', null, ['class'=>'form-control']) !!}
        </div>
        {{--//ZA SNIPET SUBMIT ////////////--}}
        <div class="form-group">
            {!! Form::submit('Create Category',['class'=>'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>
    <div class="col-sm-6">
        @if($categories)
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Created date</th>
                </tr>
                </thead>
                @foreach($categories as $category)
                    <tbody>
                    <tr>
                        <td>{{$category->id}}</td>
                        <td><a href="{{route('categories.edit', $category->id)}}">{{$category->name}}</a></td>
                        <td>{{$category->created_at ? $category->created_at->diffForHumans() : "no date"}}</td>
                    </tr>
                    </tbody>
                @endforeach
            </table>
        @endif
    </div>
@endsection
