@extends('layouts.master')
@section('heading')

@stop

@section('content')

    <table class="table table-hover " id="tickets-table">
        <thead>
        <tr>
            <th>{{ __('Tiêu đề') }}</th>
            <th>{{ __('Mô tả') }}</th>
            <th>{{ __('Người tạo') }}</th>
            <th>{{ __('Ngày tạo') }}</th>
            <th></th>
        </tr>
        </thead>
    </table>

@stop

@push('scripts')
<script>
    $(function () {
        var table = $('#tickets-table').DataTable({
            processing: true,
            serverSide: true,

            ajax: '{!! route('descriptions.data') !!}',
            columns: [
                {data: 'titlelink', name: 'title'},
                {data: 'description', name: 'description'},
                {data: 'user_created', name: 'creator.name'},
                {data: 'created_at', name: 'created_at'},
                {data: 'edit', name: 'edit'},
            ]
        });
    });
</script>
@endpush
