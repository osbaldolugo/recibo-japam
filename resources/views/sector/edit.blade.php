@extends('layouts.app')

@section('content')
        <div class="row">
            <div class="col-sm-12">
                <h1 class="pull-left">Editar Sector</h1>
            </div>
        </div>
        @include('core-templates::common.errors')
        <div class="row">
            @include('sector.fields')
        </div>
@endsection
