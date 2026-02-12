@extends('layouts.app')

@section('content')
    @include('p_m_o_specialities.show_fields')

    <div class="form-group">
           <a href="{!! route('pMOSpecialities.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
