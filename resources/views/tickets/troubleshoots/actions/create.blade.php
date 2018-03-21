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
                <th>Biện pháp khắc phục</th>
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
                            @if(\Auth::id() == $action->user_id)
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#TroubleshootActionEditModal-{{$action->id}}"
                                    data-id="{{ $action->id }}"><i class="fa fa-edit"></i>
                            </button>
                            @else
                                <button type="button" class="btn btn-warning btn-sm"><i class="fa fa-lock"></i></button>
                            @endif
                            <div class="modal fade" id="TroubleshootActionEditModal-{{$action->id}}" tabindex="-1" role="dialog" aria-labelledby="TroubleshootActionEditModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="TroubleshootActionEditModalLabel">Sửa biện pháp khắc phục</h4>
                                        </div>
                                        <div class="modal-body" style="text-align: left">
                                            {!! Form::model($action, [
                                                'method' => 'PATCH',
                                                'route' => ['troubleshootactions.update', $action->id],
                                                'files'=>true,
                                                'enctype' => 'multipart/form-data'
                                                ]) !!}

                                            {!! Form::label('action', __('Biện pháp khắc phục'), ['class' => 'control-label']) !!}
                                            {!! Form::text('action', null, ['class' => 'form-control', 'id' => 'action']) !!}

                                            <div class="form-inline">
                                                <div class="form-group col-sm-4 removeleft ">
                                                    {!! Form::label('user_id', __('Người thực hiện'), ['class' => 'control-label']) !!}
                                                    {!! Form::select('user_id', $approvers, null, ['placeholder' => '', 'id'=>'user_id', 'name'=>'user_id','class'=>'form-control', 'style' => 'width:100%']) !!}
                                                </div>
                                                <div class="form-group col-sm-4 removeright ">
                                                    {!! Form::label('deadline', __('Thời hạn'), ['class' => 'control-label']) !!}
                                                    {!! Form::date('deadline', \Carbon\Carbon::parse($action->deadline), ['class' => 'form-control']) !!}
                                                </div>
                                                <div class="form-group col-sm-4 removeright ">
                                                    {!! Form::label('status', __('Trạng thái'), ['class' => 'control-label']) !!}
                                                    <select name="status" id="status" class="form-control" style="width:100%">
                                                        <option <?php if($action->status == 'Open'){echo("selected");}?> > {{ __('Open') }} </option>
                                                        <option <?php if($action->status == 'Closed'){echo("selected");}?> > {{ __('Closed') }} </option>
                                                    </select>
                                                </div>
                                            </div>
                                            {!! Form::submit('Cập nhật', ['class' => 'btn btn-primary']) !!}

                                            {!! Form::close() !!}
                                        </div>
                                        <div class="modal-footer">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td style="text-align: center">
                            <span>
                                @if(\Auth::id() == $action->user_id)
                                    <form action="{{ route('troubleshootActionMarkComplete', $action->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('PATCH') }}
                                        <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-check-circle"></i></button>
                                    </form>
                                @else
                                    <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-lock"></i></button>
                                @endif
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