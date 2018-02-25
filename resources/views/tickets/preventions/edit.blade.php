@extends('layouts.master')
@section('heading')
    <h1>Cập nhật nguyên nhân gốc rễ</h1>
@stop

@section('content')


@section('content')
    {!! Form::model($prevention, [
            'method' => 'PATCH',
            'route' => ['preventions.update', $prevention->id],
            'files'=>true,
            'enctype' => 'multipart/form-data'
            ]) !!}

    <div class="form-group form-inline">
        {!! Form::label('root_cause', __('Nguyên nhân gốc rễ'), ['class' => 'control-label']) !!}
        {!! Form::textarea('root_cause', null, ['class' => 'form-control',  'id' => 'root_cause']) !!}
    </div>
    <div class="form-group form-inline">
        {!! Form::label('root_cause_approver_id', __('Người phê duyệt'), ['class' => 'control-label']) !!}
        {!! Form::select('root_cause_approver_id', $users, null, ['placeholder' => '', 'id'=>'root_cause_approver_id', 'name'=>'root_cause_approver_id','class'=>'form-control', 'style' => 'width:100%']) !!}
    </div>
    {!! Form::submit( __('Cập nhật') , ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}

@stop
@push('scripts')
    <script type="text/javascript">
        $("#root_cause_approver_id").select2({
            placeholder: "Chọn",
            allowClear: true
        });
    </script>
@endpush
