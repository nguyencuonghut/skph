@extends('layouts.master')
@section('heading')
    <h1>Mô tả ticket</h1>
@stop

@section('content')

    {!! Form::open([
            'route' => 'descriptions.store',
            'files'=>true,
            'enctype' => 'multipart/form-data'
    ]) !!}

    <div class="form-group">
        {!! Form::label('title', __('Tiêu đề') , ['class' => 'control-label']) !!}
        {!! Form::text('title', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-inline">
        <div class="form-group col-sm-6 removeleft ">
            {!! Form::label('issue_date', __('Ngày phát hành'), ['class' => 'control-label']) !!}
            {!! Form::date('issue_date', \Carbon\Carbon::now(), ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-sm-6 removeright ">
            {!! Form::label('answer_date', __('Thời hạn trả lời'), ['class' => 'control-label']) !!}
            {!! Form::date('answer_date', \Carbon\Carbon::now()->addDays(7), ['class' => 'form-control']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('area_id', __('Phát hành tới') , ['class' => 'control-label']) !!}
        {!! Form::select('area_id', $areas, null, ['placeholder' => '', 'id'=>'area_id', 'name'=>'area_id','class'=>'form-control', 'style' => 'width:100%']) !!}

    </div>

    <div class="form-group">
        {!! Form::label('source_id', __('Nguồn gốc') , ['class' => 'control-label']) !!}
        {!! Form::select('source_id', $sources, null, ['placeholder' => '', 'id'=>'source_id', 'name'=>'source_id','class'=>'form-control', 'style' => 'width:100%']) !!}

    </div>

    <div class="form-group">
        {!! Form::label('action_id', __('Hành động') , ['class' => 'control-label']) !!}
        {!! Form::select('action_id', $actions, null, ['placeholder' => '', 'id'=>'action_id', 'name'=>'action_id','class'=>'form-control', 'style' => 'width:100%']) !!}

    </div>

    <div class="form-group">
        {!! Form::label('what', __('Cái gì đã xảy ra ?'), ['class' => 'control-label']) !!}
        {!! Form::text('what', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('why', __('Tại sao đây là một vấn đề ?'), ['class' => 'control-label']) !!}
        {!! Form::text('why', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('when', __('Nó xảy ra khi nào ?'), ['class' => 'control-label']) !!}
        {!! Form::date('when', \Carbon\Carbon::now(), ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('who', __('Ai phát hiện ra ?'), ['class' => 'control-label']) !!}
        {!! Form::text('who', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('where', __('Phát hiện ra ở đâu ?'), ['class' => 'control-label']) !!}
        {!! Form::text('where', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('how_1', __('Bằng cách nào ?'), ['class' => 'control-label']) !!}
        {!! Form::text('how_1', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('how_2', __('Có bao nhiêu sự không phù hợp'), ['class' => 'control-label']) !!}
        {!! Form::text('how_2', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {{ Form::label('image', __('Ảnh'), ['class' => 'control-label']) }}
        {!! Form::file('image',  null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group form-inline">
        {!! Form::label('leader_id', __('Trưởng bộ phận'), ['class' => 'control-label']) !!}
        {!! Form::select('leader_id', $users, null, ['placeholder' => '', 'id'=>'leader_id', 'name'=>'leader_id','class'=>'form-control', 'style' => 'width:100%']) !!}
    </div>

    {!! Form::submit(__('Tạo mới'), ['class' => 'btn btn-primary']) !!}

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
