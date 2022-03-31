@extends('layouts.admin')

@section('content')
    <h1>Users</h1>

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
                        <img height="40" src="{{$user->photo ? $user->photo->path : 'https://via.placeholder.com/400x400'}}">
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
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
@stop

div.
