@extends('layouts.master')
@section('heading')
    <h1>Sửa hành động phòng ngừa</h1>
@stop

@section('content')


@section('content')
    {!! Form::model($preventionaction, [
            'method' => 'PATCH',
            'route' => ['preventiontactions.update', $preventionaction->id],
            'files'=>true,
            'enctype' => 'multipart/form-data'
            ]) !!}

    {!! Form::label('action', __('Hành động phòng ngừa'), ['class' => 'control-label']) !!}
    {!! Form::text('action', null, ['class' => 'form-control', 'id' => 'action']) !!}

    <div class="form-inline">
        <div class="form-group col-sm-4 removeleft ">
            {!! Form::label('budget', __('Ngân sách'), ['class' => 'control-label']) !!}
            {!! Form::text('budget', null, ['class' => 'form-control', 'id' => 'action']) !!}

            {!! Form::label('user_id', __('Ai làm ?'), ['class' => 'control-label']) !!}
            {!! Form::select('user_id', $users, null, ['placeholder' => '', 'id'=>'user_id', 'name'=>'user_id','class'=>'form-control', 'style' => 'width:100%']) !!}
        </div>
        <div class="form-group col-sm-4 removeright ">
            {!! Form::label('where', __('Làm ở đâu ?'), ['class' => 'control-label']) !!}
            {!! Form::text('where', null, ['class' => 'form-control', 'id' => 'action']) !!}

            {!! Form::label('when', __('Làm khi nào ?'), ['class' => 'control-label']) !!}
            {!! Form::date('when', \Carbon\Carbon::parse($preventionaction->when), ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-sm-4 removeright ">
            {!! Form::label('status', __('Trạng thái'), ['class' => 'control-label']) !!}
            <select name="status" id="status" class="form-control" style="width:100%">
                <option <?php if($preventionaction->status == 'Open'){echo("selected");}?> > {{ __('Open') }} </option>
                <option <?php if($preventionaction->status == 'Closed'){echo("selected");}?> > {{ __('Closed') }} </option>
            </select>
            <br>
            <br>
            <br>
            <br>
            <br>
        </div>
    </div>
    {!! Form::label('how', __('Làm như thế nào ?'), ['class' => 'control-label']) !!}
    {!! Form::text('how', null, ['class' => 'form-control', 'id' => 'action']) !!}
    <br>
    {!! Form::submit('Cập nhật', ['class' => 'btn btn-primary']) !!}

    {!! Form::close() !!}

@stop
@push('scripts')
    <script type="text/javascript">
        $("#area_id").select2({
            placeholder: "Chọn nơi phát hành",
            allowClear: true
        });
    </script>
    <script type="text/javascript">
        $("#source_id").select2({
            placeholder: "Chọn nguồn gốc",
            allowClear: true
        });
    </script>
    <script type="text/javascript">
        $("#action_id").select2({
            placeholder: "Chọn hành động",
            allowClear: true
        });
    </script>
    <script type="text/javascript">
        $("#leader_id").select2({
            placeholder: "Chọn trưởng bộ phận",
            allowClear: true
        });
    </script>
@endpush
