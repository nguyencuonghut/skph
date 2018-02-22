@extends('layouts.master')
@section('heading')
    <h1>Sửa hành động khắc phục</h1>
@stop

@section('content')


@section('content')
    {!! Form::model($troubleshootaction, [
            'method' => 'PATCH',
            'route' => ['troubleshootactions.update', $troubleshootaction->id],
            'files'=>true,
            'enctype' => 'multipart/form-data'
            ]) !!}

    {!! Form::label('action', __('Biện pháp khắc phục'), ['class' => 'control-label']) !!}
    {!! Form::text('action', null, ['class' => 'form-control', 'id' => 'action']) !!}

    <div class="form-inline">
        <div class="form-group col-sm-4 removeleft ">
            {!! Form::label('user_id', __('Người thực hiện'), ['class' => 'control-label']) !!}
            {!! Form::select('user_id', $users, null, ['placeholder' => '', 'id'=>'user_id', 'name'=>'user_id','class'=>'form-control', 'style' => 'width:100%']) !!}
        </div>
        <div class="form-group col-sm-4 removeright ">
            {!! Form::label('deadline', __('Thời hạn'), ['class' => 'control-label']) !!}
            {!! Form::date('deadline', \Carbon\Carbon::parse($troubleshootaction->deadline), ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-sm-4 removeright ">
            {!! Form::label('status', __('Trạng thái'), ['class' => 'control-label']) !!}
            <select name="status" id="status" class="form-control" style="width:100%">
                <option <?php if($troubleshootaction->status == 'Open'){echo("selected");}?> > {{ __('Open') }} </option>
                <option <?php if($troubleshootaction->status == 'Closed'){echo("selected");}?> > {{ __('Closed') }} </option>
            </select>
        </div>
    </div>
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
