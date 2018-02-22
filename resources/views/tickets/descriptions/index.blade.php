@extends('layouts.master')
@section('heading')

@stop

@section('content')

    <table class="table table-hover " id="descriptions-table">
        <thead>
        <tr>
            <th>{{ __('Tiêu đề') }}</th>
            <th>{{ __('Ngày tạo') }}</th>
            <th>{{ __('Hạn trả lời') }}</th>
            <th>{{ __('Nguồn gốc') }}</th>
            <th>{{ __('Người tạo') }}</th>
        </tr>
        </thead>
    </table>

@stop

@push('scripts')
<script>
    $(function () {
        var table = $('#descriptions-table').DataTable({
            processing: true,
            serverSide: true,

            ajax: '{!! route('descriptions.data') !!}',
            columns: [
                {data: 'titlelink', name: 'title'},
                {data: 'issue_date', name: 'issue_date'},
                {data: 'answer_date', name: 'answer_date'},
                {data: 'source_id', name: 'source_id', searchable: false},
                {data: 'user_id', name: 'user_id', searchable: false},
            ]
        });
    });
</script>
@endpush
