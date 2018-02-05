@extends('layouts.master')
@section('heading')
    <h1>Sửa ticket</h1>
@stop

@section('content')


@section('content')
    {!! Form::model($ticket, [
            'method' => 'PATCH',
            'route' => ['descriptions.update', $ticket->id],
            'files'=>true,
            'enctype' => 'multipart/form-data'
            ]) !!}

    <div class="form-group">
        {!! Form::label('title', __('Tiêu đề') , ['class' => 'control-label']) !!}
        {!! Form::text('title', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('description', __('Mô tả'), ['class' => 'control-label']) !!}
        {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
    </div>

    {!! Form::submit(__('Cập nhật'), ['class' => 'btn btn-primary']) !!}

    {!! Form::close() !!}

@stop
