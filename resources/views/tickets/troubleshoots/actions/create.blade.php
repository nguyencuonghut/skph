<div class="row">
    <div class="col-md-12">
        <h5><b style="float: left">Biện pháp khắc phục:</b></h5>
        @if(\Auth::id() == $troubleshoot->troubleshooter_id)
            <span>
                <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#troubleshootaction"><i class="fa fa-plus-circle"><b> Thêm biện pháp khắc phục</b></i></button>
            </span>
            <div class="modal fade" id="troubleshootaction" tabindex="-1" role="dialog" aria-labelledby="TroubleshootModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="TroubleshootModalLabel"><b>Thêm biện pháp khắc phục</b></h4>
                        </div>
                        <div class="modal-body">
                            {!! Form::open([
                                'route' => ['troubleshootactions.store', $subject->id],
                                ]) !!}
                                {!! Form::label('action', __('Biện pháp khắc phục'), ['class' => 'control-label']) !!}
                                {!! Form::text('action', null, ['class' => 'form-control', 'id' => 'action']) !!}
                                <div class="form-inline">
                                    <div class="form-group col-sm-6 removeleft ">
                                        {!! Form::label('user_id', __('Người thực hiện'), ['class' => 'control-label']) !!}
                                        <select name="user_id" id="user_id" class="form-control" style="width:100%">
                                            <option disabled selected value> {{ __('Chọn') }} </option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-6 removeright ">
                                        {!! Form::label('deadline', __('Thời hạn'), ['class' => 'control-label']) !!}
                                        {!! Form::date('deadline', \Carbon\Carbon::now()->addDays(3), ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                {!! Form::submit( __('Thêm') , ['class' => 'btn btn-primary']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if($actions->count())
            <h5><b style="float: left">Tiến độ:</b></h5>
            <span style="float: left">&nbsp;</span>
            <span>
                <div class="progress">
                    <div class="progress-bar-success" role="progressbar" aria-valuenow="{{($completed_actions->count()/$actions->count()) * 100}}" aria-valuemin="0" aria-valuemax="100" style="width: {{($completed_actions->count()/$actions->count()) * 100}}%;">
                        {{(int)(($completed_actions->count()/$actions->count()) * 100)}}%
                    </div>
                </div>
            </span>
            <table class="table" style="font-size: 12px">
                <thead>
                <th>Hành động khắc phục</th>
                <th>Người thực hiện</th>
                <th>Thời gian tạo</th>
                <th>Thời hạn</th>
                <th>Trạng thái</th>
                <th>Sửa</th>
                <th>Đánh dấu hoàn thành</th>
                </thead>

                <tbody>
                <?php $i = 1 ?>
                @foreach($actions as $action)
                    <tr>
                        @if($action->is_on_time == true)
                            <td><i class="fa fa-check-circle" style="color:green"></i> {{ $action->action }}</td>
                        @else
                            <td><i class="fa fa-clock-o" style="color:red"></i> {{ $action->action }}</td>
                        @endif
                        <td>{{ $action->user->name }}</td>
                        <td>{{date('d, F Y', strTotime($action->created_at))}}</td>
                        <td>{{date('d, F Y', strTotime($action->deadline))}}</td>
                        <td style="color: {{'Open' == $action->status ? "green": "black"}}">{{ $action->status}}</td>
                        <td style="text-align: center">
                            <a class="btn btn-small btn-warning" href="{{ URL::to('troubleshootactions/' . $action->id . '/edit') }}"><i class="fa fa-edit"></i></a>
                        </td>
                        <td style="text-align: center">
                            <span>
                                <form action="{{ route('troubleshootActionMarkComplete', $action->id) }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('PATCH') }}
                                    <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i></button>
                                </form>
                            </span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        $("#user_id").select2({
            placeholder: "Chọn",
            allowClear: true
        });
    </script>
@endpush