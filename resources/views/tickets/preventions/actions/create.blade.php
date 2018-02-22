@if($preventionactions->count())
    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <thead>
                <th>STT</th>
                <th>Hành động phòng ngừa</th>
                <th>Ngân sách dự kiến</th>
                <th>Ai làm ?</th>
                <th>Làm ở đâu ?</th>
                <th>Làm khi nào ?</th>
                <th>Làm như thế nào ?</th>
                <th>Trạng thái</th>
                </thead>

                <tbody>
                <?php $i = 1 ?>
                @foreach($preventionactions as $prevention)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{ $prevention->action }}</td>
                        <td align="right">{{ number_format($prevention->budget, 0, ',', ',') . ' ' . 'VNĐ'}}</td>                        <td>{{ $prevention->user->name }}</td>
                        <td>{{ $prevention->where }}</td>
                        <td>{{ $prevention->when }}</td>
                        <td>{{ $prevention->how }}</td>
                        <td>{{ $prevention->status}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

    <button type="button" class="btn btn-success" data-toggle="collapse" data-target="#prevention_id"><span class="glyphicon glyphicon-plus"></span> Thêm biện pháp phòng ngừa</button>
    {!! Form::open([
            'route' => ['preventionactions.store', $subject->id],
            ]) !!}
    <div class="form-group panel-collapse collapse" id="prevention_id">
        {!! Form::label('action', __('Hành động phòng ngừa'), ['class' => 'control-label']) !!}
        {!! Form::text('action', null, ['class' => 'form-control', 'id' => 'action']) !!}
        <div class="form-inline">
            <div class="form-group col-sm-6 removeleft ">
                {!! Form::label('budget', __('Ngân sách'), ['class' => 'control-label']) !!}
                {!! Form::number('budget', null, ['class' => 'form-control', 'id' => 'action']) !!}

                {!! Form::label('user_id', __('Ai làm ?'), ['class' => 'control-label']) !!}
                <select name="user_id" id="user_id" class="form-control" style="width:100%">
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