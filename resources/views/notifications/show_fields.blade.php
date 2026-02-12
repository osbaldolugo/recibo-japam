<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $notification->id !!}</p>
</div>

<!-- Title Field -->
<div class="form-group">
    {!! Form::label('title', 'Title:') !!}
    <p>{!! $notification->title !!}</p>
</div>

<!-- Description Field -->
<div class="form-group">
    {!! Form::label('description', 'Description:') !!}
    <p>{!! $notification->description !!}</p>
</div>

<!-- Url Image Field -->
<div class="form-group">
    {!! Form::label('url_image', 'Url Image:') !!}
    <p>{!! $notification->url_image !!}</p>
</div>

<!-- Url Info Field -->
<div class="form-group">
    {!! Form::label('url_info', 'Url Info:') !!}
    <p>{!! $notification->url_info !!}</p>
</div>

<!-- Begin Date Field -->
<div class="form-group">
    {!! Form::label('begin_date', 'Begin Date:') !!}
    <p>{!! $notification->begin_date !!}</p>
</div>

<!-- End Date Field -->
<div class="form-group">
    {!! Form::label('end_date', 'End Date:') !!}
    <p>{!! $notification->end_date !!}</p>
</div>

