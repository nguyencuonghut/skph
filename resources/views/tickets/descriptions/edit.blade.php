@extends('layouts.master')
@section('heading')
    <h1>Sửa ticket</h1>
@stop

@section('content')


@section('content')
    {!! Form::model($description, [
            'method' => 'PATCH',
            'route' => ['descriptions.update', $description->id],
            'files'=>true,
            'enctype' => 'multipart/form-data'
            ]) !!}
    @include('tickets.descriptions.form', ['submitButtonText' => __('Cập nhật')])
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
