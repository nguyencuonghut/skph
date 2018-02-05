@extends('layouts.master')
<style>
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }
    th, td {
        padding: 5px;
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
                        <el-tabs active-name="description" style="width:100%">
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
                                <h5><b style="color:blue">1. Mô tả vấn đề:</b>
                                    <span>
                                        <a href="{{ route("descriptions.edit", $description->id) }}"><i class="fa fa-pencil-square" aria-hidden="true"></i></a>
                                    </span>
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
                                @if(isset($troubleshoot))
                                    <h5><b style="color:blue">2. Xác định trách nhiệm:</b></h5>
                                    <h5><b>Lý do:</b><i> {!! $troubleshoot->reason !!}</i></h5>
                                @endif
                                <h5><b style="color:blue">3. Thực hiện khắc phục sự không phù hợp trước khi tìm nguyên nhân gốc rễ:</b></h5>
                                <div class="col-md-12">
                                    <div class="contactleft">
                                        <p><b>Mức độ SKPH:</b> xxx</p>
                                        <p><b>Thời hạn:</b> {{date('d F, Y', strtotime($description->created_at))}}</p>
                                    </div>
                                    <div class="contactright">
                                        <p><b>Người thực hiện:</b> xxx</p>
                                            <p><b>Phê duyệt: <b style="color: {{$description->confirmation_troubleshootsaction_id == 1 ? "blue" : "red"}}">xxx</b></b> (bởi xxx vào
                                                @if(date_diff($description->created_at, $description->updated_at)->y)
                                                    {{ date_diff($description->created_at, $description->updated_at)->y }} năm
                                                @endif
                                                @if(date_diff($description->created_at, $description->updated_at)->m)
                                                    {{ date_diff($description->created_at, $description->updated_at)->m }} tháng
                                                @endif
                                                @if(date_diff($description->created_at, $description->updated_at)->d)
                                                    {{ date_diff($description->created_at, $description->updated_at)->d }} ngày
                                                @endif
                                                @if(date_diff($description->created_at, $description->updated_at)->h)
                                                    {{ date_diff($description->created_at, $description->updated_at)->h }} giờ
                                                @endif
                                                @if(date_diff($description->created_at, $description->updated_at)->i)
                                                    {{ date_diff($description->created_at, $description->updated_at)->i }} phút
                                                @endif
                                                trước)
                                            </p>
                                    </div>
                                </div>
                                <p>xxx</p>
                            </el-tab-pane>
                            <el-tab-pane label="Phòng ngừa" name="prevents">
                                <h5><b style="color:blue">4. Hoạt động xử lý</b></h5>
                                <div class="col-md-12">
                                    <div class="contactleft">
                                        <p><b>Người đề xuất xử lý:</b> xxx</p>
                                    </div>
                                    <div class="contactright">
                                        <p><b>Thẩm tra đề xuất xử lý:</b><b style="color: blue;"> Đạt</b> (Bởi <b>xxx</b>) vào
                                            @if(date_diff($description->created_at, $description->updated_at)->y)
                                                {{ date_diff($description->created_at, $description->updated_at)->y }} năm
                                            @endif
                                            @if(date_diff($description->created_at, $description->updated_at)->m)
                                                {{ date_diff($description->created_at, $description->updated_at)->m }} tháng
                                            @endif
                                            @if(date_diff($description->created_at, $description->updated_at)->d)
                                                {{ date_diff($description->created_at, $description->updated_at)->d }} ngày
                                            @endif
                                            @if(date_diff($description->created_at, $description->updated_at)->h)
                                                {{ date_diff($description->created_at, $description->updated_at)->h }} giờ
                                            @endif
                                            @if(date_diff($description->created_at, $description->updated_at)->i)
                                                {{ date_diff($description->created_at, $description->updated_at)->i }} phút
                                            @endif
                                            trước</p>
                                    </div>
                                </div>
                                <table class="table">
                                    <tr>
                                        <th>#</th>
                                        <th>Mô tả hành động</th>
                                        <th>Ngân sách dự kiến</th>
                                        <th>Ai làm ?</th>
                                        <th>Làm ở đâu ?</th>
                                        <th>Làm khi nào ?</th>
                                        <th>Làm như thế nào ?</th>
                                        <th>Đánh giá tình trạng</th>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A beatae, debitis dolorem doloremque dolorum enim impedit in, ipsa laudantium magni minima modi quo quod, repellat rerum tempore temporibus tenetur voluptatibus.</td>
                                        <td>50,000,000 VNĐ</td>
                                        <td>xxx</td>
                                        <td>Nhà máy</td>
                                        <td>{{$description->created_at}}</td>
                                        <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A beatae, debitis dolorem doloremque dolorum enim impedit in, ipsa laudantium magni minima modi quo quod, repellat rerum tempore temporibus tenetur voluptatibus.</td>
                                        <td style="color:blue"><b>Đúng thời hạn</b></td>
                                    </tr>
                                </table>
                                <hr style="color:#337ab7; border-color:#337ab7; background-color:#337ab7">
                                <h5><b style="color:blue">5. Xem xét mức độ sự không phù hợp</b></h5>
                                <p><b>Không nghiêm trọng => Dừng</b> (Bởi <b>xxx</b>) vào
                                    @if(date_diff($description->created_at, $description->updated_at)->y)
                                        {{ date_diff($description->created_at, $description->updated_at)->y }} năm
                                    @endif
                                    @if(date_diff($description->created_at, $description->updated_at)->m)
                                        {{ date_diff($description->created_at, $description->updated_at)->m }} tháng
                                    @endif
                                    @if(date_diff($description->created_at, $description->updated_at)->d)
                                        {{ date_diff($description->created_at, $description->updated_at)->d }} ngày
                                    @endif
                                    @if(date_diff($description->created_at, $description->updated_at)->h)
                                        {{ date_diff($description->created_at, $description->updated_at)->h }} giờ
                                    @endif
                                    @if(date_diff($description->created_at, $description->updated_at)->i)
                                        {{ date_diff($description->created_at, $description->updated_at)->i }} phút
                                    @endif
                                    trước
                                </p>
                                <hr style="color:#337ab7; border-color:#337ab7; background-color:#337ab7">
                                <h5><b style="color:blue">6. Đánh giá hiệu quả</b></h5>
                                <p>Ticket được đánh giá  hiệu quả <b style="color:red">Trung bình</b> (Bởi <b>xxx</b>) vào
                                    @if(date_diff($description->created_at, $description->updated_at)->y)
                                        {{ date_diff($description->created_at, $description->updated_at)->y }} năm
                                    @endif
                                    @if(date_diff($description->created_at, $description->updated_at)->m)
                                        {{ date_diff($description->created_at, $description->updated_at)->m }} tháng
                                    @endif
                                    @if(date_diff($description->created_at, $description->updated_at)->d)
                                        {{ date_diff($description->created_at, $description->updated_at)->d }} ngày
                                    @endif
                                    @if(date_diff($description->created_at, $description->updated_at)->h)
                                        {{ date_diff($description->created_at, $description->updated_at)->h }} giờ
                                    @endif
                                    @if(date_diff($description->created_at, $description->updated_at)->i)
                                        {{ date_diff($description->created_at, $description->updated_at)->i }} phút
                                    @endif
                                    trước
                                </p>
                            </el-tab-pane>
                        </el-tabs>
                    </div>
                    <!-- ~ Tab for each ticket-->

                </div>
            </div>


        </div>
        <div class="col-md-3">
            <div class="sidebarheader" style="margin-top: 0px; background-color:#337ab7;">
                <p>{{ __('Cập nhật Ticket') }}</p>
            </div>

            {!! Form::model($description, [
                'method' => 'PATCH',
                'url' => ['descriptions/leaderconfirm', $description->id],
            ]) !!}
            <select id="leader_confirmation_result" name="leader_confirmation_result" style="width:100%">
                <option disabled selected value> -- select an option -- </option>
                <option>Xác nhận</option>
                <option>Không xác nhận</option>
            </select>
            {!! Form::submit(__('TBP xác nhận'), ['class' => 'btn btn-primary form-control closebtn']) !!}
            <br>
            <br>
            <a href="{{route("troubleshoots.create", $description->id)}}"
               class="btn btn-primary form-control closebtn" style="width:100%">Cập nhật biện pháp
            </a>
        </div>
    </div>
@stop

@push('scripts')
    <script type="text/javascript">
        $("#leader_confirmation_result").select2({
            placeholder: "Chọn",
            allowClear: true
        });
    </script>
    <script type="text/javascript">
        $("#confirmation_troubleshootsaction_id").select2({
            placeholder: "Duyệt",
            allowClear: true
        });
    </script>
@endpush