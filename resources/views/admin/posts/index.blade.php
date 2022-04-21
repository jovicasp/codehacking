@extends('layouts.admin')

@section('content')
    @if(session('deleted_post'))
        <div class="alert alert-warning " role="alert">
            <h4>{{ session('deleted_post') }}</h4>
        </div>
    @endif

    <h1>Posts page</h1>
    {!! '</br>' !!}
    {{--BUTTON FOR RANDOM USER CREATION--}}
    {{--<a href="{{ url('/cru') }}">--}}
    {{--<button class="btn btn-success" style="margin-left: 500px; margin-top: -40px; padding: 10px;font-size:12px">--}}
    {{--{{ "Create random user" }}--}}
    {{--</button>--}}
    {{--</a>--}}

    @if(session('updated_post'))
        <div class="alert alert-success  " role="alert">
            <h4>{{ session('updated_post') }}</h4>
        </div>
    @endif
    @if(session('created_post'))
        <div class="alert alert-success  " role="alert">
            <h4>{{ session('created_post') }}</h4>
        </div>
    @endif

    <table class="table table-hover">
        <thead>
        <tr>
            <th>ID</th>
            <th>Owner</th>
            <th>Category</th>
            <th>First Photo</th>
            <th>Title</th>
            <th>Content</th>
            <th>Created</th>
            <th>Updated</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        @if($posts)
            @foreach($posts as $post)
                <tr>
                    <td>{{$post->id}}</td>
                    <td>{{$post->user->name}}</td>
                    <td>
                        @if($post->categories->first())
                            @foreach($post->categories as $category)
                                {{$category->name}}{!! "</br>" !!}
                            @endforeach
                        @else
                            {{'Uncategorized'}}
                        @endif
                    </td>

                    <div class="image-continer">
                        <td>
                            {{--UZIMANJE SAMO PRVE SLIKE OD POSTA koji je u PM RELACIJI SA PHOTO--}}
                            <img height="40"
                                 src="{{$post->photos->first() ? ($post->photos->first())['path'] : 'https://via.placeholder.com/400x400'}}">
                        </td>
                    </div>
                    <td><a href="{{route('posts.edit', $post->id)}}">{{$post->title}}</a></td>
                    <td>{{Str::limit($post->content, 400)}}</td>
                    <td>{{$post->created_at->diffForHumans()}}</td>
                    <td>{{$post->updated_at->diffForHumans()}}</td>
                    <td>{!! link_to_route('posts.edit', $title='Edit this post',
                    $parameters=[$post->id, '<i class="fa fa-building"></i> Button'],
                    ['type'=>'button', 'class'=>'btn btn-primary']) !!}
                    </td>
                    <div class="form-group">
                        <td>
                            {!! Form::open(['method'=>'DELETE','action'=>['App\Http\Controllers\AdminPostsController@destroy', $post->id]]) !!}
                            {!! Form::submit('Delete this Post',
                            ['class'=>'btn btn-danger']) !!}
                            {{--['class'=>'btn btn-danger', 'style'=>'float: right;margin-top: -40px;']) !!}--}}
                            {!! Form::close() !!}
                        </td>
                    </div>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
@stop