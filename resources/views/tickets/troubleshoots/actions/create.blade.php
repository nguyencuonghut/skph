@if($actions->count())
    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <thead>
                <th>STT</th>
                <th>Hành động khắc phục</th>
                <th>Người thực hiện</th>
                <th>Thời gian tạo</th>
                <th>Thời hạn</th>
                <th>Trạng thái</th>
                </thead>

                <tbody>
                <?php $i = 1 ?>
                @foreach($actions as $action)
                    <tr>
                        <th>{{$i++}}</th>
                        <th>{{ $action->action }}</th>
                        <td>{{ $action->user->name }}</td>
                        <td>{{date('d, F Y H:i', strTotime($action->created_at))}}</td>
                        <td>{{date('d, F Y', strTotime($action->deadline))}}</td>
                        <td>{{ $action->status}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

    <button type="button" class="btn btn-success" data-toggle="collapse" data-target="#action_id"><span class="glyphicon glyphicon-plus"></span> Thêm biện pháp</button>
    {!! Form::open([
            'route' => ['troubleshootactions.store', $subject->id],
            ]) !!}
    <div class="form-group panel-collapse collapse" id="action_id">
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
    </div>
    {!! Form::close() !!}


@push('scripts')
    <script type="text/javascript">
        $("#user_id").select2({
            placeholder: "Chọn",
            allowClear: true
        });
    </script>
@endpush