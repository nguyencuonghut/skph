<br/><br/>
<div class="col-sm-6">


        <div class="panel panel-primary">
            <div class="panel-heading"><b>Tổng hợp SKPH theo Phòng/Ban </b><span style="color:blue" class="badge">{{$allDepartmentTickets->sum()}}</span></div>
            <div class="panel-body">
                <pie :statistics="{{$allDepartmentTickets}}"></pie>
            </div>
        </div>
</div>
<div class="col-sm-6">


        <div class="panel panel-primary">
            <div class="panel-heading"><b>Tổng hợp SKPH theo nguyên nhân</b></div>
            <div class="panel-body">
                <pie2 :statistics="{{$allReasonTickets}}" ></pie2>
            </div>
        </div>


</div>

<!-- /.info-box -->
    
