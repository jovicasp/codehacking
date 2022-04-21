@extends('layouts.admin')
@section('content')
    <h1>Edit User</h1>
    <div class="col-sm-3">
        <img src="{{$user->photos->first() ? ($user->photos->first())['path'] : 'https://via.placeholder.com/300x300'}}" alt="" lass="img-responsive img-rounded">

    </div>
    <div class="col-sm-9">
        {{--//MODEL BINDOVANA FORMA, UKLJUCUJE PROMENLJIVU $USER KAO PRVI PARAMETAR, METHOD JE PUT, ACTION JE METHOD UPDATE I PARAMETAR ID U NIZU, ENCTYPE FILES-TRUE ZBOG FILEFOERMFIELD.--}}
        {!! Form::model($user, ['method'=>"PUT", 'action'=>["App\Http\Controllers\AdminUsersController@update", $user->id], 'files'=>true]) !!}
        <div class="form-group">
            {!! Form::label('name', 'Name') !!}
            {!! Form::text('name', $user->name, ['class'=>'form-control']) !!}
        </div>
        {!! '</br>' !!}
        <div class="form-group">
            {!! Form::label('email', 'Email') !!}
            {!! Form::email('email', $user->email, ['class'=>'form-control']) !!}
        </div>
        {{--//PASSWORD NE UKLJUCUJEMO U EDIT, ako ga ukljucimo, imacemo poseban psw condition u update metodi controllera--}}
        {!! '</br>' !!}
        <div class="form-group">
        {!! Form::label('password', 'Password') !!}
        {!! Form::password('password', ['class'=>'form-control']) !!}
        </div>
        {!! '</br>' !!}
        <div class="form-group">
            {!! Form::label('role_id', 'Role') !!}
            {!! Form::select('role_id', [''=>'Choose Option'] + $roles, $user->role_id, ['class'=>'form-control']) !!}
        </div>
        {!! '</br>' !!}
        <div class="form-group">
            {!! Form::label('is_active', 'Status') !!}
            {!! Form::select('is_active', [1=>'Active', 0=>'Not Active'], $user->is_active, ['class'=>'form-control']) !!}
        </div>
        {!! '</br>' !!}
        <div class="form-group">
            {!! Form::label('photo', 'Upload Photo') !!}
            {!! Form::file('photo', null, ['class'=>'form-control']) !!}
            <div class="image-container" style="margin: -30px 0px 0px 310px;">
                <td><img height="40" src="{{$user->photos->first() ? ($user->photos->first())['path'] : 'https://via.placeholder.com/200x200'}}"></td>
                {{--//dodatni PRIKAZ SLIKE--}}
            </div>
        </div>
        {!! '</br>' !!}{!! '</br>' !!}
        <div class="form-group">
            {!! Form::submit('Update User',['class'=>'btn btn-primary']) !!}
            {!! Form::close() !!}
            {{--//svaka forma se zatvara zasebno--}}
            {!! '</br>' !!}

            {{--//DELETE FORM--}}
            {!! Form::open(['method'=>'DELETE',
            'action'=>['App\Http\Controllers\AdminUsersController@destroy', $user->id]]) !!}
            {!! Form::submit('Delete this User',
                ['class'=>'btn btn-danger', 'style'=>'float: right; margin-top: -20px;']) !!}
            {!! Form::close() !!}
            {{--//svaka forma se zatvara zasebno--}}
        </div>
        @include('includes.display-form-errors')
        {{--//greske cemo ukljuciti ili ovako u samom divu sa slikom i formom ili u zasebnom divu class =row ako je van ovog diva,a divove sa slikom i formom ubaciti u zaseban div class=row.--}}
    </div>
@endsection
