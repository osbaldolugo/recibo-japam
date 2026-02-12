@extends('layouts.app')

@section('content')
        <div class="row">
            <div class="col-sm-12">
                <h1 class="pull-left">Edit App User</h1>
            </div>
        </div>

        @include('core-templates::common.errors')

        <div class="row">
            {!! Form::model($appUser, ['route' => ['appUsers.update', $appUser->id], 'method' => 'patch']) !!}

            @include('app_users.fields')

            {!! Form::close() !!}
        </div>
@endsection
