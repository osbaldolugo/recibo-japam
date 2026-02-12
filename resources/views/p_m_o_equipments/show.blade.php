@extends('layouts.app')

@section('content')
    @include('p_m_o_equipments.show_fields')

    <div class="form-group">
           <a href="{!! route('pMOEquipments.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
