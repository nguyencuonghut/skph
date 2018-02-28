@extends('layouts.master')
    @section('content')
    @include('partials.userheader')
<div class="col-sm-12">
    <br>
    <div class="col-sm-6 removeleft">
        <div class="panel panel-primary">
            <div class="panel-heading">Ticket tôi tạo</div>
            <div class="panel-body">
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
        </div>

        <div class="panel panel-primary">
            <div class="panel-heading">Hành động khắc phục của tôi</div>
            <div class="panel-body">
                <table class="table table-hover " id="my-troubleshootactions-table">
                    <thead>
                    <tr>
                        <th>{{ __('Tiêu đề') }}</th>
                        <th>{{ __('Thời gian tạo') }}</th>
                        <th>{{ __('Thời hạn') }}</th>
                        <th>{{ __('Sửa') }}</th>
                        <th>{{ __('Đóng') }}</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>

        <div class="panel panel-primary">
            <div class="panel-heading">Tất cả ticket</div>
            <div class="panel-body">
                @foreach($descriptions as $description)
                <div class="media">
                    <div class="media-left">
                        <a href="{{route('descriptions.show', $description->id)}}">
                            <img class="media-object" style="width: 50px;" src={{url('/upload/' . $description->image)}} alt="...">
                        </a>
                    </div>
                    <div class="media-body">
                        <a href="{{route('descriptions.show', $description->id)}}"><h5 class="media-heading">{{str_limit($description->title, 50)}}</h5></a>
                        <i class="fa fa-check-circle" style="color:green">
                            <i style="color: #333333">
                                Tạo
                                @if(date_diff(new DateTime('now'), $description->created_at)->y)
                                    {{ date_diff(new DateTime('now'), $description->created_at)->y }} năm
                                @endif
                                @if(date_diff(new DateTime('now'), $description->created_at)->m)
                                    {{ date_diff(new DateTime('now'), $description->created_at)->m }} tháng
                                @endif
                                @if(date_diff(new DateTime('now'), $description->created_at)->d)
                                    {{ date_diff(new DateTime('now'), $description->created_at)->d }} ngày
                                @endif
                                @if(date_diff(new DateTime('now'), $description->created_at)->h)
                                    {{ date_diff(new DateTime('now'), $description->created_at)->h }} giờ
                                @endif
                                @if(date_diff(new DateTime('now'), $description->created_at)->i)
                                    {{ date_diff(new DateTime('now'), $description->created_at)->i }} phút
                                @else
                                    0 phút
                                @endif
                                trước bởi <b>{{$description->user->name}}</b>
                            </i>
                        </i>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-sm-6 removeright">
        <div class="panel panel-primary">
            <div class="panel-heading">Ticket tôi xác nhận</div>
            <div class="panel-body">
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
        </div>

        <div class="panel panel-primary">
            <div class="panel-heading">Hành động phòng ngừa của tôi</div>
            <div class="panel-body">
                <table class="table table-hover " id="my-preventionactions-table">
                    <thead>
                    <tr>
                        <th>{{ __('Tiêu đề') }}</th>
                        <th>{{ __('Thời gian tạo') }}</th>
                        <th>{{ __('Thời hạn') }}</th>
                        <th>{{ __('Sửa') }}</th>
                        <th>{{ __('Đóng') }}</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
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

        $('#my-troubleshootactions-table').DataTable({
            processing: true,
            serverSide: true,

            ajax: '{!! route('troubleshootactions.myactionsdata') !!}',
            columns: [
                {data: 'action', name: 'action'},
                {data: 'deadline', name: 'deadline'},
                {data: 'status', name: 'status'},
                { data: 'edit', name: 'edit', orderable: false, searchable: false},
                { data: 'markCompleted', name: 'markCompleted', orderable: false, searchable: false},
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

        $('#my-preventionactions-table').DataTable({
            processing: true,
            serverSide: true,

            ajax: '{!! route('preventionactions.myactionsdata') !!}',
            columns: [
                {data: 'action', name: 'action'},
                {data: 'when', name: 'when'},
                {data: 'status', name: 'status'},
                { data: 'edit', name: 'edit', orderable: false, searchable: false},
                { data: 'markCompleted', name: 'markCompleted', orderable: false, searchable: false},
            ]
        });
    });
</script>
@endpush


