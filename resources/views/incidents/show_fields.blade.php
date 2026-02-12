<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $incidents->id !!}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{!! $incidents->name !!}</p>
</div>

<!-- Description Field -->
<div class="form-group">
    {!! Form::label('description', 'Description:') !!}
    <p>{!! $incidents->description !!}</p>
</div>

<!-- Ticket Field -->
<div class="form-group">
    {!! Form::label('ticket', 'Ticket:') !!}
    <p>{!! $incidents->ticket !!}</p>
</div>

<!-- Complaint Field -->
<div class="form-group">
    {!! Form::label('complaint', 'Complaint:') !!}
    <p>{!! $incidents->complaint !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $incidents->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $incidents->updated_at !!}</p>
</div>

<!-- Deleted At Field -->
<div class="form-group">
    {!! Form::label('deleted_at', 'Deleted At:') !!}
    <p>{!! $incidents->deleted_at !!}</p>
</div>

