@extends('layouts.master')
<style>
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        font-size: 12px;
    }
    th, td {
        padding: 2px;
        padding-top: 2px;
        padding-bottom: 2px;
        text-align: left;
    }
</style>

@section('heading')

@stop

@section('content')
    @push('scripts')
        <script>
            $(document).ready(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
    @endpush

    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-primary shadow">
                <div class="panel-heading"><h3><b><i class="glyphicon glyphicon-tags" aria-hidden="true"></i>  Ticket #{{$description->id}}: {{$description->title}}</b></h3></div>
                <div class="panel-body">

                    <!-- Tab for each ticket -->
                    <div class="col-md-12">
                        <el-tabs active-name=<?php
                                switch (Session::get('tab')) {
                                    case 'description':
                                        echo("description");
                                        break;
                                    case 'troubleshoot':
                                        echo("troubleshoot");
                                        break;
                                    case 'prevents':
                                        echo("prevents");
                                        break;
                                    default:
                                        echo("description");
                                        break;
                                }
                        ?> style="width:100%">
                            <el-tab-pane label="Mô tả vấn đề" name="description">
                                <div class="col-md-12 col-md-6"></div>
                                <div class="contactleft">
                                    <p><b>Ngày phát hành:</b> {{date('d F, Y', strtotime($description->issue_date))}}</p>
                                    <p><b>Thời hạn trả lời:</b> {{date('d F, Y', strtotime($description->answer_date))}}</p>
                                    <p><b>Hành động:</b> {{$description->action->name}}</p>
                                </div>
                                <div class="contactright col-md-6">
                                    <p><b>Phát hành tới:</b> {{$description->area->name}}</p>
                                    <p><b>Nguồn gốc:</b> {{$description->source->name}}</p>
                                    <br>
                                    <br>
                                </div>
                                <h5><b style="color:blue;float: left;">1. Mô tả vấn đề:</b>
                                    @if(\Auth::id() == $description->user_id && !('Xác nhận' == $description->leader_confirmation_result))
                                        <span>
                                            <a style="float: left;" href="{{ route("descriptions.edit", $description->id) }}">
                                                <button type="button" class="btn btn-warning btn-xs"><i class="fa fa-edit"><b> Cập nhật</b></i></button>
                                            </a>
                                        </span>
                                    @endif
                                    @if(\Auth::id() == $description->leader_id)
                                        <span>
                                            <form style="float: left;" action="{{ route('leaderConfirm', [$description->id, 'Xác nhận']) }}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('PATCH') }}
                                                <button type="submit" class="btn btn-success btn-xs"><i class="fa fa-check-circle"> Chấp nhận</i></button>
                                            </form>
                                        </span>
                                        <span>
                                            <form action="{{ route('leaderConfirm', [$description->id, 'Không xác nhận']) }}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('PATCH') }}
                                                <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-times-circle"> Từ chối</i></button>
                                            </form>
                                        </span>
                                    @endif
                                </h5>
                                <table style="width:100%">
                                    <tr>
                                        <th class="col-md-3">Có gì đã xảy ra?</th>
                                        <td class="col-md-4">{{$description->title}}</td>
                                        <th rowspan="5"><img class="img-responsive" src={{url('/upload/' . $description->image)}}></th>
                                    </tr>
                                    <tr>
                                        <th class="col-md-3">Tại sao đây là một vấn đề?</th>
                                        <td class="col-md-4">{{$description->why}}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-md-3">Nó xảy ra khi nào?</th>
                                        <td class="col-md-4">{{date('d F, Y', strtotime($description->when))}}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-md-3">Ai phát hiện ra?</th>
                                        <td class="col-md-4">{{$description->who}}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-md-3">Phát hiện ra ở đâu?</th>
                                        <td class="col-md-4">{{$description->where}}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-md-3">Bằng cách nào?</th>
                                        <td class="col-md-4">{{$description->how_1}}</td>
                                        @if(NULL != $description->leader_confirmation_result)
                                            <th rowspan="2">{{$description->leader->name}} <b style="color:{{$description->leader_confirmation_result == 'Xác nhận' ? "blue" : "red"}}">
                                                    {{$description->leader_confirmation_result}}</b></th>
                                        @else
                                            <th rowspan="2">{{$description->leader->name}}:<b style="color:red"> Chưa xác nhận!</b></th>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th class="col-md-3">Có bao nhiêu sự không phù hợp?</th>
                                        <td class="col-md-4">{{$description->how_2}}</td>
                                    </tr>
                                </table>
                            </el-tab-pane>
                            <el-tab-pane label="Khắc phục" name="troubleshoot">
                                <h5><b style="color:blue;float: left;">2. Thực hiện biện pháp khắc phục:</b></h5>
                                @if(\Auth::id() == $troubleshoot->approver_id)
                                    <span>
                                        <form style="float: left;" action="{{ route('approve', [$troubleshoot->id, 'Đồng ý']) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('PATCH') }}
                                            <button type="submit" class="btn btn-success btn-xs"><i class="fa fa-check-circle"> Chấp nhận</i></button>
                                        </form>
                                    </span>
                                    <span style="float: left;">&nbsp; </span>
                                    <span>
                                        <form action="{{ route('approve', [$troubleshoot->id, 'Không đồng ý']) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('PATCH') }}
                                            <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-times-circle"> Từ chối</i></button>
                                        </form>
                                    </span>
                                @endif

                                <div class="col-md-12">
                                    <div class="contactleft">
                                        @if($troubleshoot->troubleshooter)
                                            <p><b>Người thực hiện:</b> {{$troubleshoot->troubleshooter->name}}</p>
                                            @if($troubleshoot->approve_result)
                                                <p><b>Phê duyệt: <b style="color: {{("Đồng ý" == $troubleshoot->approve_result) ? "blue":"red"}}"> {{$troubleshoot->approve_result}}</b></b> (bởi {{$troubleshoot->approver->name}})</p>
                                            @else
                                                <p><b>Phê duyệt: <b style="color: {{("Đồng ý" == $troubleshoot->approve_result) ? "blue":"red"}}"> Chưa phê duyệt</b></b>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="contactright">
                                        @if($troubleshoot->level)
                                            <p><b>Mức độ SKPH:</b> {{$troubleshoot->level->name}}</p>
                                        @endif
                                        @if($troubleshoot->deadline != 0)
                                            <p><b>Thời hạn:</b> {{date('d F, Y', strtotime($troubleshoot->deadline))}}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    @if($troubleshoot->approver)
                                        @include('tickets.troubleshoots.actions.create', ['subject' => $description])
                                    @endif
                                </div>

                                <h5><b style="color:blue; float: left;">3. Xác định trách nhiệm:</b></h5>
                                @if(\Auth::id() == $troubleshoot->troubleshooter_id && ('Đồng ý' != $troubleshoot->approve_result))
                                    <span>
                                        <a href="{{ route("troubleshoots.edit", $description->id) }}">
                                            <button type="button" class="btn btn-warning btn-xs"><i class="fa fa-edit"><b> Cập nhật</b></i></button>
                                        </a>
                                    </span>
                                @endif
                                @if(isset($troubleshoot))
                                    <div class="col-md-12">
                                        @if($troubleshoot->responsibility)
                                            <h5><b>Trách nhiệm:</b> {{$troubleshoot->responsibility->name}}</h5>
                                        @endif
                                        @if($troubleshoot->reason)
                                            <h5><b>Lý do:</b></h5>
                                            <p><i>{!! $troubleshoot->reason !!}</i></p>
                                        @endif
                                    </div>
                                @endif
                            </el-tab-pane>
                            <el-tab-pane label="Phòng ngừa" name="prevents">
                                <h5><b style="color:blue; float: left">4. Xem xét mức độ sự không phù hợp:</b></h5>
                                <span style="float: left;">&nbsp; </span>
                                @if(\Auth::user()->userRole->role_id == 1)
                                    <span>
                                        <form style="float: left;" action="{{ route('evaluate', [$troubleshoot->id, 'Nghiêm trọng']) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('PATCH') }}
                                            <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-exclamation-triangle"> Nghiêm trọng</i></button>
                                        </form>
                                    </span>
                                    <span style="float: left;">&nbsp; </span>
                                    <span>
                                        <form action="{{ route('evaluate', [$troubleshoot->id, 'Không nghiêm trọng']) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('PATCH') }}
                                            <button type="submit" class="btn btn-success btn-xs"><i class="fa fa-stop-circle"> Không nghiêm trọng</i></button>
                                        </form>
                                    </span>
                                @endif

                                <div class="col-md-12">
                                    <p><b>
                                            @if('Không nghiêm trọng' == $troubleshoot->evaluate_result)
                                                <b style="color:green">{{$troubleshoot->evaluate_result}}</b> => Dừng
                                            @elseif('Nghiêm trọng' == $troubleshoot->evaluate_result)
                                                <b style="color:red">Nghiêm trọng => Phân tích nguyên nhân gốc rễ và đưa ra giải pháp phòng ngừa</b>
                                            @endif
                                        </b>
                                        @if(isset($troubleshoot->evaluater))
                                            (Bởi <b>{{$troubleshoot->evaluater->name}}</b>)
                                        @endif
                                    </p>
                                        <p><b>Nguyên nhân gốc rễ:</b>
                                            @if((\Auth::id() == $prevention->proposer_id) && ('Không đồng ý' == $prevention->root_cause_approve_result))
                                                <span>
                                                    <a href="{{ route("preventions.edit", $prevention->id) }}">
                                                        <button type="button" class="btn btn-warning btn-xs"><i class="fa fa-edit"><b> Cập nhật</b></i></button>
                                                    </a>
                                                </span>
                                            @endif
                                            @if($prevention->root_cause)
                                                <i>{!! $prevention->root_cause !!}</i>
                                            @endif
                                        </p>

                                    <p><b style="float: left;">Thẩm tra nguyên nhân gốc rễ:</b>
                                        <span style="float: left;">
                                            @if($prevention->root_cause_approve_result)
                                                <b style="color: {{'Đồng ý' == $prevention->root_cause_approve_result ? "blue":"red"}}">&nbsp; {{$prevention->root_cause_approve_result}}</b> (Bởi {{$prevention->root_cause_approver->name}})&nbsp;
                                            @else
                                                <p style="float: left;"><b style="color:red"> Chưa thẩm tra</b></p>
                                            @endif
                                        </span>
                                        <span style="float: left;">&nbsp; </span>
                                        @if(\Auth::id() == $prevention->approver_id)
                                            <span>
                                                <form style="float: left;" action="{{ route('approveRootcause', [$prevention->id, 'Đồng ý']) }}" method="POST">
                                                    {{ csrf_field() }}
                                                    {{ method_field('PATCH') }}
                                                    <button type="submit" class="btn btn-success btn-xs"><i class="fa fa-check-circle"> Chấp nhận</i></button>
                                                </form>
                                            </span>
                                            <span style="float: left;">&nbsp; </span>
                                            <span>
                                                <form action="{{ route('approveRootcause', [$prevention->id, 'Không đồng ý']) }}" method="POST">
                                                    {{ csrf_field() }}
                                                    {{ method_field('PATCH') }}
                                                    <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-times-circle"> Từ chối</i></button>
                                                </form>
                                            </span>
                                        @endif
                                    </p>
                                </div>

                                <br>
                                <hr style="color:#337ab7; border-color:#337ab7; background-color:#337ab7">
                                <h5><b style="color:blue">5. Hoạt động phòng ngừa</b></h5>
                                <div class="col-md-12">
                                    @if($prevention->proposer)
                                        <p><b>Người đề xuất xử lý:</b> {{$prevention->proposer->name}}</p>
                                    @else
                                        <p><b>Người đề xuất xử lý:</b> <b style="color:red">Chưa được giao</b></p>
                                    @endif
                                    @if($preventionactions->count())
                                        <p><b style="float: left;">Thẩm tra đề xuất xử lý:</b>
                                            <span style="float: left;">
                                                @if($prevention->approve_result)
                                                    <b style="color: {{'Đồng ý' == $prevention->approve_result ? "blue":"red"}}">&nbsp; {{$prevention->approve_result}}</b> (Bởi {{$prevention->approver->name}})&nbsp;
                                                @else
                                                    <p style="float: left;"><b style="color:red"> Chưa thẩm tra</b></p>
                                                @endif
                                            </span>
                                            <span style="float: left;">&nbsp; </span>
                                            @if(\Auth::id() == $prevention->approver_id)
                                                <span>
                                                    <form style="float: left;" action="{{ route('approvePrevention', [$prevention->id, 'Đồng ý']) }}" method="POST">
                                                        {{ csrf_field() }}
                                                        {{ method_field('PATCH') }}
                                                        <button type="submit"  class="btn btn-success btn-xs"><i class="fa fa-check-circle"> Chấp nhận</i></button>
                                                    </form>
                                                </span>
                                                <span style="float: left;">&nbsp; </span>
                                                <span>
                                                    <form action="{{ route('approvePrevention', [$prevention->id, 'Không đồng ý']) }}" method="POST">
                                                        {{ csrf_field() }}
                                                        {{ method_field('PATCH') }}
                                                        <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-times-circle"> Từ chối</i></button>
                                                    </form>
                                                </span>
                                            @endif
                                        </p>
                                    @else
                                        <p><b>Thẩm tra đề xuất xử lý:</b> <b style="color: red"> Chưa thẩm tra</b></p>
                                    @endif
                                </div>

                                <div class="col-md-12">
                                    @if($prevention->proposer)
                                        @include('tickets.preventions.actions.create', ['subject' => $prevention])
                                    @endif
                                </div>
                                <hr style="color:#337ab7; border-color:#337ab7; background-color:#337ab7">
                                <h5><b style="color:blue;float: left;">6. Đánh giá hiệu quả: &nbsp;</b></h5>
                                @if(\Auth::id() == $prevention->approver_id)
                                    <span>
                                        <form style="float: left;" action="{{ route('effectivenessAsset', [$description->id, 'Cao']) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('PATCH') }}
                                            <button type="submit"  class="btn btn-success btn-xs"><i class="fa fa-thumbs-up"> Cao</i></button>
                                        </form>
                                    </span>
                                    <span style="float: left;">&nbsp; </span>
                                    <span>
                                        <form  style="float: left;" action="{{ route('effectivenessAsset', [$description->id, 'Trung bình']) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('PATCH') }}
                                            <button type="submit" class="btn btn-warning btn-xs"><i class="fa fa-hand-o-right"> Trung bình</i></button>
                                        </form>
                                    </span>
                                    <span style="float: left;">&nbsp; </span>
                                    <span>
                                        <form action="{{ route('effectivenessAsset', [$description->id, 'Thấp']) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('PATCH') }}
                                            <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-thumbs-down"> Thấp</i></button>
                                        </form>
                                    </span>
                                @endif

                                <div class="col-md-12">
                                    @if($description->effectiveness)
                                        <p><b>Ticket được đánh giá hiệu quả <b style="color: {{("Thấp" == $description->effectiveness) ? "red":"blue"}}"> {{$description->effectiveness}}</b></b> (bởi {{$description->effectiveness_user->name}} vào
                                            @if(date_diff(new DateTime('now'), $description->updated_at)->y)
                                                {{ date_diff(new DateTime('now'), $description->updated_at)->y }} năm
                                            @endif
                                            @if(date_diff(new DateTime('now'), $description->updated_at)->m)
                                                {{ date_diff(new DateTime('now'), $description->updated_at)->m }} tháng
                                            @endif
                                            @if(date_diff(new DateTime('now'), $description->updated_at)->d)
                                                {{ date_diff(new DateTime('now'), $description->updated_at)->d }} ngày
                                            @endif
                                            @if(date_diff(new DateTime('now'), $description->updated_at)->h)
                                                {{ date_diff(new DateTime('now'), $description->updated_at)->h }} giờ
                                            @endif
                                            @if(date_diff(new DateTime('now'), $description->updated_at)->i)
                                                {{ date_diff(new DateTime('now'), $description->updated_at)->i }} phút
                                            @else
                                                0 phút
                                            @endif
                                            trước)</p>
                                    @else
                                        <p><b>Ticket <b style="color: red">chưa</b> được đánh giá hiệu quả.</b>
                                    @endif
                                </div>
                            </el-tab-pane>
                        </el-tabs>
                    </div>
                    <!-- ~ Tab for each ticket-->

                </div>
            </div>

            @include('partials.comments', ['subject' => $description])
        </div>
        <div class="col-md-3">
            <div class="sidebarheader" style="margin-top: 0px; background-color:#337ab7;">
                <p>{{ __('Cập nhật Ticket') }}</p>
            </div>

            @if(\Auth::id() == $description->leader_id)
                {!! Form::model($troubleshoot, [
                    'method' => 'PATCH',
                    'url' => ['troubleshoots/assigntroubeshooter', $troubleshoot->id],
                ]) !!}
                <select name="troubleshooter_id" id="troubleshooter_id" class="form-control" style="width:100%">
                    <option disabled selected value> {{ __('Select a user') }} </option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                {!! Form::submit(__('Chuyển cho người khắc phục'), ['class' => 'btn btn-primary form-control closebtn']) !!}
                {!! Form::close() !!}
            @endif

            @if(\Auth::user()->userRole->role_id == 1)
                {!! Form::model($prevention, [
                    'method' => 'PATCH',
                    'url' => ['preventions/assignproposer', $prevention->id],
                ]) !!}
                <select name="proposer_id" id="proposer_id" class="form-control" style="width:100%">
                    <option disabled selected value> {{ __('Select a user') }} </option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                {!! Form::submit(__('Người đề xuất HĐ phòng ngừa'), ['class' => 'btn btn-primary form-control closebtn']) !!}
                {!! Form::close() !!}

                {!! Form::model($prevention, [
                                'method' => 'PATCH',
                                'url' => ['preventions/assignapprover', $prevention->id],
                            ]) !!}
                <select name="approver_id" id="approver_id" class="form-control" style="width:100%">
                    <option disabled selected value> {{ __('Select a user') }} </option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                {!! Form::submit(__('Người duyệt HĐ phòng ngừa'), ['class' => 'btn btn-primary form-control closebtn']) !!}
                {!! Form::close() !!}
            @endif

            <div class="activity-feed movedown">
                @foreach($description->activity as $activity)
                    @if($activity->action != 'effectiveness_asset')
                        <div class="feed-item">
                            <div class="activity-date">{{date('d, F Y H:i', strTotime($activity->created_at))}}</div>
                            <div class="activity-text">{{$activity->text}}</div>
                        </div>
                    @endif
                @endforeach

                @foreach($troubleshoot->activity as $activity)
                    <div class="feed-item">
                        <div class="activity-date">{{date('d, F Y H:i', strTotime($activity->created_at))}}</div>
                        <div class="activity-text">{{$activity->text}}</div>
                    </div>
                @endforeach

                @foreach($prevention->activity as $activity)
                    <div class="feed-item">
                        <div class="activity-date">{{date('d, F Y H:i', strTotime($activity->created_at))}}</div>
                        <div class="activity-text">{{$activity->text}}</div>
                    </div>
                @endforeach

                @foreach($description->activity as $activity)
                    @if($activity->action == 'effectiveness_asset')
                        <div class="feed-item">
                            <div class="activity-date">{{date('d, F Y H:i', strTotime($activity->created_at))}}</div>
                            <div class="activity-text">{{$activity->text}}</div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@stop

@push('scripts')
    <script type="text/javascript">
        $("#troubleshooter_id").select2({
            placeholder: "Chọn",
            allowClear: true
        });
    </script>
    <script type="text/javascript">
        $("#proposer_id").select2({
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
    <script type="text/javascript">
        $("#evaluate_result").select2({
            placeholder: "Chọn",
            allowClear: true
        });
    </script>
    <script type="text/javascript">
        $("#effectiveness").select2({
            placeholder: "Chọn",
            allowClear: true
        });
    </script>
@endpush