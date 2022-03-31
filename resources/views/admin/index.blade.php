@extends("layouts.admin")

@section("content")
    <h1>Admin index page</h1>

    @if(session('not_authorized'))
        <div class="alert alert-warning " role="alert">
            <h4>{{ session('not_authorized') }}</h4>
        </div>
    @endif
@stop