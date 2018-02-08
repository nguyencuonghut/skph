@extends('layouts.master')
@section('heading')
    <h1>Cập nhật biện pháp</h1>
@stop

@section('content')


@section('content')
    {!! Form::model($troubleshoot, [
            'method' => 'PATCH',
            'route' => ['troubleshoots.update', $troubleshoot->id],
            'files'=>true,
            'enctype' => 'multipart/form-data'
            ]) !!}
    <div class="form-inline">
        <div class="form-group col-sm-3 removeleft ">
            {!! Form::label('responsibility_id', __('Xác định trách nhiệm'), ['class' => 'control-label']) !!}
            {!! Form::select('responsibility_id', $responsibilities, null, ['placeholder' => '', 'id'=>'responsibility_id', 'name'=>'responsibility_id','class'=>'form-control', 'style' => 'width:100%']) !!}

        </div>
        <div class="form-group col-sm-3 removeright ">
            {!! Form::label('level_id', __('Mức độ'), ['class' => 'control-label']) !!}
            {!! Form::select('level_id', $levels, null, ['placeholder' => '', 'id'=>'level_id', 'name'=>'level_id','class'=>'form-control', 'style' => 'width:100%']) !!}
        </div>
        <div class="form-group col-sm-3 removeright ">
            {!! Form::label('approver_id', __('Người phê duyệt'), ['class' => 'control-label']) !!}
            {!! Form::select('approver_id', $users, null, ['placeholder' => '', 'id'=>'approver_id', 'name'=>'approver_id','class'=>'form-control', 'style' => 'width:100%']) !!}

        </div>
        <div class="form-group col-sm-3 removeright ">
            {!! Form::label('deadline', __('Thời hạn trả lời'), ['class' => 'control-label']) !!}
            {!! Form::date('deadline', \Carbon\Carbon::now(), ['class' => 'form-control']) !!}
        </div>
    </div>
    <br>
    <br>
    <br>
    <div class="form-group form-inline">
        {!! Form::label('reason', __('Lý do'), ['class' => 'control-label']) !!}
        {!! Form::textarea('reason', null, ['class' => 'form-control',  'id' => 'troubleshoot_action']) !!}
    </div>

    {!! Form::submit(__('Cập nhật'), ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}

@stop

@push('scripts')
    <script type="text/javascript">
        $("#responsibility_id").select2({
            placeholder: "Chọn",
            allowClear: true
        });
    </script>
    <script type="text/javascript">
        $("#level_id").select2({
            placeholder: "Chọn",
            allowClear: true
        });
    </script>
    <script type="text/javascript">
        $("#approver_id").select2({
            placeholder: "Chọn",
            allowClear: true
        });
    </script>
@endpush
