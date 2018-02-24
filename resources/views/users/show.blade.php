@extends('layouts.master')
    @section('content')
    @include('partials.userheader')
<div class="col-sm-12">
    <div class="col-sm-6 removeleft">
        <h3>Ticket tôi tạo</h3>
        <table class="table table-hover " id="my-created-table">
            <thead>
            <tr>
                <th>{{ __('Tiêu đề') }}</th>
                <th>{{ __('Ngày tạo') }}</th>
                <th>{{ __('Hạn trả lời') }}</th>
                <th>{{ __('Nguồn gốc') }}</th>
            </tr>
            </thead>
        </table>
    </div>
    <div class="col-sm-6 removeright">
        <h3>Ticket tôi xác nhận</h3>
        <table class="table table-hover " id="my-confirmed-table">
            <thead>
            <tr>
                <th>{{ __('Tiêu đề') }}</th>
                <th>{{ __('Ngày tạo') }}</th>
                <th>{{ __('Hạn trả lời') }}</th>
                <th>{{ __('Nguồn gốc') }}</th>
                <th>{{ __('Kết quả') }}</th>
            </tr>
            </thead>
        </table>
    </div>
    <hr style="color:#337ab7; border-color:#337ab7; background-color:#337ab7">


</div>

   @stop 
@push('scripts')
<script>
    $(function () {
        $('#my-created-table').DataTable({
            processing: true,
            serverSide: true,

            ajax: '{!! route('descriptions.mycreateddata') !!}',
            columns: [
                {data: 'titlelink', name: 'title'},
                {data: 'issue_date', name: 'issue_date'},
                {data: 'answer_date', name: 'answer_date'},
                {data: 'source_id', name: 'source_id', searchable: false},
            ]
        });


        $('#my-confirmed-table').DataTable({
            processing: true,
            serverSide: true,

            ajax: '{!! route('descriptions.myconfirmeddata') !!}',
            columns: [
                {data: 'titlelink', name: 'title'},
                {data: 'issue_date', name: 'issue_date'},
                {data: 'answer_date', name: 'answer_date'},
                {data: 'source_id', name: 'source_id', searchable: false},
                {data: 'confirmation_result', name: 'confirmation_result'},
            ]
        });
    });
</script>
@endpush


