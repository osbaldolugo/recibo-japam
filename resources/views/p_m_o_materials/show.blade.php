@extends('layouts.app')

@section('content')
    @include('p_m_o_materials.show_fields')

    <div class="form-group">
           <a href="{!! route('pMOMaterials.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
