@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @elseif(session('not_authorized'))
                        <div class="alert alert-warning " role="alert">
                            {{ session('not_authorized') }}
                        </div>
                    @endif

                    {{ __('You are logged in  ').Auth::user()->name }}
                        {!! link_to_route('users.index', $title='Go to admin.users page',
                       '<i class="fa fa-building"></i> Button',
                       ['type'=>'button','class'=>'btn btn-primary', 'style'=>'float: right; margin-top: 0px;'])  !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
