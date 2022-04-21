@extends('layouts.admin')

@section('content')
    @if(session('deleted_user'))
        <div class="alert alert-warning " role="alert">
            <h4>{{ session('deleted_user') }}</h4>
        </div>
    @endif
    <h1>Users</h1>
    {{--BUTTON FOR RANDOM USER CREATION--}}
    <a href="{{ url('/cru') }}">
        <button class="btn btn-success" style="margin-left: 500px; margin-top: -40px; padding: 10px;font-size:12px">
            {{ "Create random user" }}
        </button>
    </a>

    @if(session('updated_user'))
        <div class="alert alert-success  " role="alert">
            <h4>{{ session('updated_user') }}</h4>
        </div>
    @endif
    @if(session('created_user'))
        <div class="alert alert-success  " role="alert">
            <h4>{{ session('created_user') }}</h4>
        </div>
    @endif

    <table class="table table-hover">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Image</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Created</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        @if($users)
            @foreach($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td><a href="{{route('users.edit', $user->id)}}">{{$user->name}}</a></td>
                    <div class="image-continer">
                        <td>
                            {{--UZIMANJE SAMO PRVE SLIKE OD USERA koji je u PM RELACIJI SA PHOTO--}}
                        <img height="40" src="{{$user->photos->first() ? ($user->photos->first())['path'] : 'https://via.placeholder.com/400x400'}}">
                        </td>
                    </div>
                    <td>{{$user->email}}</td>
                    <td>{{$user->role->name}}</td>
                    <td>{{$user->is_active==1 ? 'Active' : 'Not Active'}}</td>
                    <td>{{$user->created_at->diffForHumans()}}</td>
                    <td>{!! link_to_route('users.edit', $title='Edit this user',
                    $parameters=[$user->id, '<i class="fa fa-building"></i> Button'],
                    ['type'=>'button', 'class'=>'btn btn-primary']) !!}
                    </td>
                    <div class="form-group">
                        <td>
                            {!! Form::open(['method'=>'DELETE','action'=>['App\Http\Controllers\AdminUsersController@destroy', $user->id]]) !!}
                            {!! Form::submit('Delete this User',
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