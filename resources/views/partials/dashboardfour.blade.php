<br/><br/>
<div class="col-sm-6">
        <div class="panel panel-primary">
            <div class="panel-heading"><b>Tỷ lệ theo từng Phòng/Ban</b></div>
            <div class="panel-body">
                <table class="table">
                    <thead>
                    <th>STT</th>
                    <th>Phòng/Ban</th>
                    <th>Phiếu có HĐ khắc phục</th>
                    <th>Phiếu thực hiện đúng yêu cầu</th>
                    </thead>

                    <tbody>
                    <?php $i = 1 ; $start_val = 10?>
                        <tr>
                            <td>{{$i}}</td>
                            <td>HCNS</td>
                            <td>{{$allTroubleshootableRateTickets[0]}} %</td>
                            <td>{{$start_val + $i}} %</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
</div>
<div class="col-sm-6">

    <div class="panel panel-primary">
        <div class="panel-heading"><b>Tỷ lệ theo từng Phòng/Ban</b></div>
        <div class="panel-body">
            <table class="table">
                <thead>
                <th>STT</th>
                <th>Phòng/Ban</th>
                <th>Phiếu có HĐ khắc phục</th>
                <th>Phiếu thực hiện đúng yêu cầu</th>
                </thead>

                <tbody>
                <?php $i = 1; $start_val = 30 ?>
                <tr>
                    <td>{{$i}}</td>
                    <td>HCNS</td>
                    <td>{{$allPreventionableRateTickets[0]}} %</td>
                    <td>{{$start_val + $i}} %</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- /.info-box -->
    
