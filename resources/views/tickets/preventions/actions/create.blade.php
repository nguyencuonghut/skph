
    <div class="row">
        <div class="col-md-12">
            <h5><b style="float: left">Biện pháp phòng ngừa:</b></h5>
            @if(\Auth::id() == $subject->proposer_id)
                <span>
                    <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#prevention"><i class="fa fa-plus-circle"><b> Thêm biện pháp phòng ngừa</b></i></button>
                </span>
                <div class="modal fade" id="prevention" tabindex="-1" role="dialog" aria-labelledby="PreventionModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="PreventionModalLabel"><b>Thêm biện pháp phòng ngừa</b></h4>
                            </div>
                            <div class="modal-body">
                                {!! Form::open([
                                        'route' => ['preventionactions.store', $subject->id],
                                        ]) !!}
                                    {!! Form::label('action', __('Hành động phòng ngừa'), ['class' => 'control-label']) !!}
                                    {!! Form::text('action', null, ['class' => 'form-control', 'id' => 'action']) !!}
                                    <div class="form-inline">
                                        <div class="form-group col-sm-6 removeleft ">
                                            {!! Form::label('budget', __('Ngân sách'), ['class' => 'control-label']) !!}
                                            {!! Form::number('budget', null, ['class' => 'form-control', 'id' => 'action']) !!}

                                            {!! Form::label('user_id', __('Ai làm ?'), ['class' => 'control-label']) !!}
                                            <select name="user_incharge_id" id="user_incharge_id" class="form-control" style="width:100%">
                                                <option disabled selected value> {{ __('Chọn') }} </option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-6 removeright ">
                                            {!! Form::label('where', __('Làm ở đâu ?'), ['class' => 'control-label']) !!}
                                            {!! Form::text('where', null, ['class' => 'form-control', 'id' => 'action']) !!}

                                            {!! Form::label('when', __('Làm khi nào ?'), ['class' => 'control-label']) !!}
                                            {!! Form::date('when', \Carbon\Carbon::now()->addDays(3), ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                    {!! Form::label('how', __('Làm như thế nào ?'), ['class' => 'control-label']) !!}
                                    {!! Form::text('how', null, ['class' => 'form-control', 'id' => 'action']) !!}

                                    <br>
                                    {!! Form::submit( __('Thêm') , ['class' => 'btn btn-primary']) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if($preventionactions->count())
                <h5><b style="float: left">Tiến độ:</b></h5>
                <span style="float: left">&nbsp;</span>
                <span>
                    <div class="progress">
                        <div class="progress-bar-success" role="progressbar" aria-valuenow="{{($completed_preventions->count()/$preventionactions->count()) * 100}}" aria-valuemin="0" aria-valuemax="100" style="width: {{($completed_preventions->count()/$preventionactions->count()) * 100}}%;">
                            {{(int)(($completed_preventions->count()/$preventionactions->count()) * 100)}}%
                        </div>
                    </div>
                </span>
                <table class="table">
                    <thead>
                    <th>Hành động phòng ngừa</th>
                    <th>Ngân sách dự kiến</th>
                    <th>Ai làm ?</th>
                    <th>Làm ở đâu ?</th>
                    <th>Làm khi nào ?</th>
                    <th>Làm như thế nào ?</th>
                    <th>Trạng thái</th>
                    <th>Sửa</th>
                    <th>Đánh dấu hoàn thành</th>
                    </thead>

                    <tbody>
                    <?php $i = 1 ?>
                    @foreach($preventionactions as $prevention)
                        <tr>
                            @if($prevention->is_on_time == true)
                                <td><i class="fa fa-check-circle" style="color:green"></i> {{ $prevention->action }}</td>
                            @else
                                <td><i class="fa fa-clock-o" style="color:red"></i> {{ $prevention->action }}</td>
                            @endif
                            <td align="right">{{ number_format($prevention->budget, 0, ',', ',') . ' ' . 'VNĐ'}}</td>
                            <td>{{ $prevention->user->name }}</td>
                            <td>{{ $prevention->where }}</td>
                            <td>{{date('d, F Y', strTotime($prevention->when))}}</td>
                            <td>{{ $prevention->how }}</td>
                            <td style="color: {{'Open' == $prevention->status ? "green": "black"}}">{{ $prevention->status}}</td>
                            <td style="text-align: center">
                                <a class="btn btn-small btn-warning" href="{{ URL::to('preventionactions/' . $prevention->id . '/edit') }}"><i class="fa fa-edit"></i></a>
                            </td>
                            <td style="text-align: center">
                                <span>
                                    <form action="{{ route('preventionActionMarkComplete', $prevention->id) }}" method="POST">
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
        $("#user_incharge_id").select2({
            placeholder: "Chọn",
            allowClear: true
        });
    </script>
@endpush