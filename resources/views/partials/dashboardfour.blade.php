<br/><br/>
<div class="col-sm-12">
    <div class="panel panel-primary">
        <div class="panel-heading"><b>Tỷ lệ theo từng Phòng/Ban</b></div>
        <div class="panel-body">
            <table class="table">
                <tr>
                    <th rowspan="2">Bộ phận</th>
                    <th rowspan="2">Tổng số phiếu C.A.R</th>
                    <th colspan="4" style="text-align: center">Số lượng phiếu C.A.R</th>
                    <th colspan="6" style="text-align: center">Phân loại nguyên nhân</th>
                </tr>
                <tr><strong>
                        <td><strong>Chưa được chỉ định người phân tích nguyên nhân và đề xuất hành động KPPN</strong></td>
                        <td><strong>Chưa được duyệt nguyên nhân gốc rễ</strong></td>
                        <td><strong>Chưa đc duyệt hành động KPPN</strong></td>
                        <td><strong>Chưa hoàn thành hành động KPPN gồm cả chưa đến hạn, quá hạn</strong></td>
                        <td><strong>Con người</strong></td>
                        <td><strong>Máy móc</strong></td>
                        <td><strong>Nguyên liệu</strong></td>
                        <td><strong>Phương pháp</strong></td>
                        <td><strong>Đo lường</strong></td>
                        <td><strong>Môi trường</strong></td>
                    </strong>
                </tr>
                <tr>
                    <td>HCNS</td>
                    <td>{{$allDepartmentStatusTickets[0]->sum()}}</td>
                    <td>{{$allDepartmentStatusTickets[0][0]}} <i>({{$allDepartmentStatusTickets[0]->sum() ? (int)(100 * $allDepartmentStatusTickets[0][0]/$allDepartmentStatusTickets[0]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStatusTickets[0][1]}} <i>({{$allDepartmentStatusTickets[0]->sum() ? (int)(100 * $allDepartmentStatusTickets[0][1]/$allDepartmentStatusTickets[0]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStatusTickets[0][2]}} <i>({{$allDepartmentStatusTickets[0]->sum() ? (int)(100 * $allDepartmentStatusTickets[0][2]/$allDepartmentStatusTickets[0]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStatusTickets[0][3]}} <i>({{$allDepartmentStatusTickets[0]->sum() ? (int)(100 * $allDepartmentStatusTickets[0][3]/$allDepartmentStatusTickets[0]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[0][0]}} <i>({{$allDepartmentStatusTickets[0]->sum() ? (int)(100 * $allDepartmentReasonTickets[0][0]/$allDepartmentStatusTickets[0]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[0][1]}} <i>({{$allDepartmentStatusTickets[0]->sum() ? (int)(100 * $allDepartmentReasonTickets[0][1]/$allDepartmentStatusTickets[0]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[0][2]}} <i>({{$allDepartmentStatusTickets[0]->sum() ? (int)(100 * $allDepartmentReasonTickets[0][2]/$allDepartmentStatusTickets[0]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[0][3]}} <i>({{$allDepartmentStatusTickets[0]->sum() ? (int)(100 * $allDepartmentReasonTickets[0][3]/$allDepartmentStatusTickets[0]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[0][4]}} <i>({{$allDepartmentStatusTickets[0]->sum() ? (int)(100 * $allDepartmentReasonTickets[0][4]/$allDepartmentStatusTickets[0]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[0][5]}} <i>({{$allDepartmentStatusTickets[0]->sum() ? (int)(100 * $allDepartmentReasonTickets[0][5]/$allDepartmentStatusTickets[0]->sum()) : 0}} %)</i></td>
                </tr>
                <tr>
                    <td>Sale Admin</td>
                    <td>{{$allDepartmentStatusTickets[1]->sum()}}</td>
                    <td>{{$allDepartmentStatusTickets[1][0]}} <i>({{$allDepartmentStatusTickets[1]->sum() ? (int)(100 * $allDepartmentStatusTickets[1][0]/$allDepartmentStatusTickets[1]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStatusTickets[1][1]}} <i>({{$allDepartmentStatusTickets[1]->sum() ? (int)(100 * $allDepartmentStatusTickets[1][1]/$allDepartmentStatusTickets[1]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStatusTickets[1][2]}} <i>({{$allDepartmentStatusTickets[1]->sum() ? (int)(100 * $allDepartmentStatusTickets[1][2]/$allDepartmentStatusTickets[1]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStatusTickets[1][3]}} <i>({{$allDepartmentStatusTickets[1]->sum() ? (int)(100 * $allDepartmentStatusTickets[1][3]/$allDepartmentStatusTickets[1]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[1][0]}} <i>({{$allDepartmentStatusTickets[1]->sum() ? (int)(100 * $allDepartmentReasonTickets[1][0]/$allDepartmentStatusTickets[1]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[1][1]}} <i>({{$allDepartmentStatusTickets[1]->sum() ? (int)(100 * $allDepartmentReasonTickets[1][1]/$allDepartmentStatusTickets[1]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[1][2]}} <i>({{$allDepartmentStatusTickets[1]->sum() ? (int)(100 * $allDepartmentReasonTickets[1][2]/$allDepartmentStatusTickets[1]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[1][3]}} <i>({{$allDepartmentStatusTickets[1]->sum() ? (int)(100 * $allDepartmentReasonTickets[1][3]/$allDepartmentStatusTickets[1]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[1][4]}} <i>({{$allDepartmentStatusTickets[1]->sum() ? (int)(100 * $allDepartmentReasonTickets[1][4]/$allDepartmentStatusTickets[1]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[1][5]}} <i>({{$allDepartmentStatusTickets[1]->sum() ? (int)(100 * $allDepartmentReasonTickets[1][5]/$allDepartmentStatusTickets[1]->sum()) : 0}} %)</i></td>
                </tr>
                <tr>
                    <td>Kế Toán</td>
                    <td>{{$allDepartmentStatusTickets[2]->sum()}}</td>
                    <td>{{$allDepartmentStatusTickets[2][0]}} <i>({{$allDepartmentStatusTickets[2]->sum() ? (int)(100 * $allDepartmentStatusTickets[2][0]/$allDepartmentStatusTickets[2]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStatusTickets[2][1]}} <i>({{$allDepartmentStatusTickets[2]->sum() ? (int)(100 * $allDepartmentStatusTickets[2][1]/$allDepartmentStatusTickets[2]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStatusTickets[2][2]}} <i>({{$allDepartmentStatusTickets[2]->sum() ? (int)(100 * $allDepartmentStatusTickets[2][2]/$allDepartmentStatusTickets[2]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStatusTickets[2][3]}} <i>({{$allDepartmentStatusTickets[2]->sum() ? (int)(100 * $allDepartmentStatusTickets[2][3]/$allDepartmentStatusTickets[2]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[2][0]}} <i>({{$allDepartmentStatusTickets[2]->sum() ? (int)(100 * $allDepartmentReasonTickets[2][0]/$allDepartmentStatusTickets[2]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[2][1]}} <i>({{$allDepartmentStatusTickets[2]->sum() ? (int)(100 * $allDepartmentReasonTickets[2][1]/$allDepartmentStatusTickets[2]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[2][2]}} <i>({{$allDepartmentStatusTickets[2]->sum() ? (int)(100 * $allDepartmentReasonTickets[2][2]/$allDepartmentStatusTickets[2]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[2][3]}} <i>({{$allDepartmentStatusTickets[2]->sum() ? (int)(100 * $allDepartmentReasonTickets[2][3]/$allDepartmentStatusTickets[2]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[2][4]}} <i>({{$allDepartmentStatusTickets[2]->sum() ? (int)(100 * $allDepartmentReasonTickets[2][4]/$allDepartmentStatusTickets[2]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[2][5]}} <i>({{$allDepartmentStatusTickets[2]->sum() ? (int)(100 * $allDepartmentReasonTickets[2][5]/$allDepartmentStatusTickets[2]->sum()) : 0}} %)</i></td>
                </tr>
                <tr>
                    <td>KSNB</td>
                    <td>{{$allDepartmentStatusTickets[3]->sum()}}</td>
                    <td>{{$allDepartmentStatusTickets[3][0]}} <i>({{$allDepartmentStatusTickets[3]->sum() ? (int)(100 * $allDepartmentStatusTickets[3][0]/$allDepartmentStatusTickets[3]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStatusTickets[3][1]}} <i>({{$allDepartmentStatusTickets[3]->sum() ? (int)(100 * $allDepartmentStatusTickets[3][1]/$allDepartmentStatusTickets[3]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStatusTickets[3][2]}} <i>({{$allDepartmentStatusTickets[3]->sum() ? (int)(100 * $allDepartmentStatusTickets[3][2]/$allDepartmentStatusTickets[3]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStatusTickets[3][3]}} <i>({{$allDepartmentStatusTickets[3]->sum() ? (int)(100 * $allDepartmentStatusTickets[3][3]/$allDepartmentStatusTickets[3]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[3][0]}} <i>({{$allDepartmentStatusTickets[3]->sum() ? (int)(100 * $allDepartmentReasonTickets[3][0]/$allDepartmentStatusTickets[3]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[3][1]}} <i>({{$allDepartmentStatusTickets[3]->sum() ? (int)(100 * $allDepartmentReasonTickets[3][1]/$allDepartmentStatusTickets[3]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[3][2]}} <i>({{$allDepartmentStatusTickets[3]->sum() ? (int)(100 * $allDepartmentReasonTickets[3][2]/$allDepartmentStatusTickets[3]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[3][3]}} <i>({{$allDepartmentStatusTickets[3]->sum() ? (int)(100 * $allDepartmentReasonTickets[3][3]/$allDepartmentStatusTickets[3]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[3][4]}} <i>({{$allDepartmentStatusTickets[3]->sum() ? (int)(100 * $allDepartmentReasonTickets[3][4]/$allDepartmentStatusTickets[3]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[3][5]}} <i>({{$allDepartmentStatusTickets[3]->sum() ? (int)(100 * $allDepartmentReasonTickets[3][5]/$allDepartmentStatusTickets[3]->sum()) : 0}} %)</i></td>
                </tr>
                <tr>
                    <td>Bảo Trì</td>
                    <td>{{$allDepartmentStatusTickets[4]->sum()}}</td>
                    <td>{{$allDepartmentStatusTickets[4][0]}} <i>({{$allDepartmentStatusTickets[4]->sum() ? (int)(100 * $allDepartmentStatusTickets[4][0]/$allDepartmentStatusTickets[4]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStatusTickets[4][1]}} <i>({{$allDepartmentStatusTickets[4]->sum() ? (int)(100 * $allDepartmentStatusTickets[4][1]/$allDepartmentStatusTickets[4]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStatusTickets[4][2]}} <i>({{$allDepartmentStatusTickets[4]->sum() ? (int)(100 * $allDepartmentStatusTickets[4][2]/$allDepartmentStatusTickets[4]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStatusTickets[4][3]}} <i>({{$allDepartmentStatusTickets[4]->sum() ? (int)(100 * $allDepartmentStatusTickets[4][3]/$allDepartmentStatusTickets[4]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[4][0]}} <i>({{$allDepartmentStatusTickets[4]->sum() ? (int)(100 * $allDepartmentReasonTickets[4][0]/$allDepartmentStatusTickets[4]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[4][1]}} <i>({{$allDepartmentStatusTickets[4]->sum() ? (int)(100 * $allDepartmentReasonTickets[4][1]/$allDepartmentStatusTickets[4]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[4][2]}} <i>({{$allDepartmentStatusTickets[4]->sum() ? (int)(100 * $allDepartmentReasonTickets[4][2]/$allDepartmentStatusTickets[4]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[4][3]}} <i>({{$allDepartmentStatusTickets[4]->sum() ? (int)(100 * $allDepartmentReasonTickets[4][3]/$allDepartmentStatusTickets[4]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[4][4]}} <i>({{$allDepartmentStatusTickets[4]->sum() ? (int)(100 * $allDepartmentReasonTickets[4][4]/$allDepartmentStatusTickets[4]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[4][5]}} <i>({{$allDepartmentStatusTickets[4]->sum() ? (int)(100 * $allDepartmentReasonTickets[4][5]/$allDepartmentStatusTickets[4]->sum()) : 0}} %)</i></td>
                </tr>
                <tr>
                    <td>Sản Xuất</td>
                    <td>{{$allDepartmentStatusTickets[5]->sum()}}</td>
                    <td>{{$allDepartmentStatusTickets[5][0]}} <i>({{$allDepartmentStatusTickets[5]->sum() ? (int)(100 * $allDepartmentStatusTickets[5][0]/$allDepartmentStatusTickets[5]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStatusTickets[5][1]}} <i>({{$allDepartmentStatusTickets[5]->sum() ? (int)(100 * $allDepartmentStatusTickets[5][1]/$allDepartmentStatusTickets[5]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStatusTickets[5][2]}} <i>({{$allDepartmentStatusTickets[5]->sum() ? (int)(100 * $allDepartmentStatusTickets[5][2]/$allDepartmentStatusTickets[5]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStatusTickets[5][3]}} <i>({{$allDepartmentStatusTickets[5]->sum() ? (int)(100 * $allDepartmentStatusTickets[5][3]/$allDepartmentStatusTickets[5]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[5][0]}} <i>({{$allDepartmentStatusTickets[5]->sum() ? (int)(100 * $allDepartmentReasonTickets[5][0]/$allDepartmentStatusTickets[5]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[5][1]}} <i>({{$allDepartmentStatusTickets[5]->sum() ? (int)(100 * $allDepartmentReasonTickets[5][1]/$allDepartmentStatusTickets[5]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[5][2]}} <i>({{$allDepartmentStatusTickets[5]->sum() ? (int)(100 * $allDepartmentReasonTickets[5][2]/$allDepartmentStatusTickets[5]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[5][3]}} <i>({{$allDepartmentStatusTickets[5]->sum() ? (int)(100 * $allDepartmentReasonTickets[5][3]/$allDepartmentStatusTickets[5]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[5][4]}} <i>({{$allDepartmentStatusTickets[5]->sum() ? (int)(100 * $allDepartmentReasonTickets[5][4]/$allDepartmentStatusTickets[5]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[5][5]}} <i>({{$allDepartmentStatusTickets[5]->sum() ? (int)(100 * $allDepartmentReasonTickets[5][5]/$allDepartmentStatusTickets[5]->sum()) : 0}} %)</i></td>
                </tr>
                <tr>
                    <td>Thu Mua</td>
                    <td>{{$allDepartmentStatusTickets[6]->sum()}}</td>
                    <td>{{$allDepartmentStatusTickets[6][0]}} <i>({{$allDepartmentStatusTickets[6]->sum() ? (int)(100 * $allDepartmentStatusTickets[6][0]/$allDepartmentStatusTickets[6]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStatusTickets[6][1]}} <i>({{$allDepartmentStatusTickets[6]->sum() ? (int)(100 * $allDepartmentStatusTickets[6][1]/$allDepartmentStatusTickets[6]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStatusTickets[6][2]}} <i>({{$allDepartmentStatusTickets[6]->sum() ? (int)(100 * $allDepartmentStatusTickets[6][2]/$allDepartmentStatusTickets[6]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStatusTickets[6][3]}} <i>({{$allDepartmentStatusTickets[6]->sum() ? (int)(100 * $allDepartmentStatusTickets[6][3]/$allDepartmentStatusTickets[6]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[6][0]}} <i>({{$allDepartmentStatusTickets[6]->sum() ? (int)(100 * $allDepartmentReasonTickets[6][0]/$allDepartmentStatusTickets[6]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[6][1]}} <i>({{$allDepartmentStatusTickets[6]->sum() ? (int)(100 * $allDepartmentReasonTickets[6][1]/$allDepartmentStatusTickets[6]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[6][2]}} <i>({{$allDepartmentStatusTickets[6]->sum() ? (int)(100 * $allDepartmentReasonTickets[6][2]/$allDepartmentStatusTickets[6]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[6][3]}} <i>({{$allDepartmentStatusTickets[6]->sum() ? (int)(100 * $allDepartmentReasonTickets[6][3]/$allDepartmentStatusTickets[6]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[6][4]}} <i>({{$allDepartmentStatusTickets[6]->sum() ? (int)(100 * $allDepartmentReasonTickets[6][4]/$allDepartmentStatusTickets[6]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[6][5]}} <i>({{$allDepartmentStatusTickets[6]->sum() ? (int)(100 * $allDepartmentReasonTickets[6][5]/$allDepartmentStatusTickets[6]->sum()) : 0}} %)</i></td>
                </tr>
                <tr>
                    <td>Kỹ Thuật</td>
                    <td>{{$allDepartmentStatusTickets[7]->sum()}}</td>
                    <td>{{$allDepartmentStatusTickets[7][0]}} <i>({{$allDepartmentStatusTickets[7]->sum() ? (int)(100 * $allDepartmentStatusTickets[7][0]/$allDepartmentStatusTickets[7]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStatusTickets[7][1]}} <i>({{$allDepartmentStatusTickets[7]->sum() ? (int)(100 * $allDepartmentStatusTickets[7][1]/$allDepartmentStatusTickets[7]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStatusTickets[7][2]}} <i>({{$allDepartmentStatusTickets[7]->sum() ? (int)(100 * $allDepartmentStatusTickets[7][2]/$allDepartmentStatusTickets[7]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStatusTickets[7][3]}} <i>({{$allDepartmentStatusTickets[7]->sum() ? (int)(100 * $allDepartmentStatusTickets[7][3]/$allDepartmentStatusTickets[7]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[7][0]}} <i>({{$allDepartmentStatusTickets[7]->sum() ? (int)(100 * $allDepartmentReasonTickets[7][0]/$allDepartmentStatusTickets[7]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[7][1]}} <i>({{$allDepartmentStatusTickets[7]->sum() ? (int)(100 * $allDepartmentReasonTickets[7][1]/$allDepartmentStatusTickets[7]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[7][2]}} <i>({{$allDepartmentStatusTickets[7]->sum() ? (int)(100 * $allDepartmentReasonTickets[7][2]/$allDepartmentStatusTickets[7]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[7][3]}} <i>({{$allDepartmentStatusTickets[7]->sum() ? (int)(100 * $allDepartmentReasonTickets[7][3]/$allDepartmentStatusTickets[7]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[7][4]}} <i>({{$allDepartmentStatusTickets[7]->sum() ? (int)(100 * $allDepartmentReasonTickets[7][4]/$allDepartmentStatusTickets[7]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[7][5]}} <i>({{$allDepartmentStatusTickets[7]->sum() ? (int)(100 * $allDepartmentReasonTickets[7][5]/$allDepartmentStatusTickets[7]->sum()) : 0}} %)</i></td>
                </tr>
                <tr>
                    <td>QLCL</td>
                    <td>{{$allDepartmentStatusTickets[8]->sum()}}</td>
                    <td>{{$allDepartmentStatusTickets[8][0]}} <i>({{$allDepartmentStatusTickets[8]->sum() ? (int)(100 * $allDepartmentStatusTickets[8][0]/$allDepartmentStatusTickets[8]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStatusTickets[8][1]}} <i>({{$allDepartmentStatusTickets[8]->sum() ? (int)(100 * $allDepartmentStatusTickets[8][1]/$allDepartmentStatusTickets[8]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStatusTickets[8][2]}} <i>({{$allDepartmentStatusTickets[8]->sum() ? (int)(100 * $allDepartmentStatusTickets[8][2]/$allDepartmentStatusTickets[8]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStatusTickets[8][3]}} <i>({{$allDepartmentStatusTickets[8]->sum() ? (int)(100 * $allDepartmentStatusTickets[8][3]/$allDepartmentStatusTickets[8]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[8][0]}} <i>({{$allDepartmentStatusTickets[8]->sum() ? (int)(100 * $allDepartmentReasonTickets[8][0]/$allDepartmentStatusTickets[8]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[8][1]}} <i>({{$allDepartmentStatusTickets[8]->sum() ? (int)(100 * $allDepartmentReasonTickets[8][1]/$allDepartmentStatusTickets[8]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[8][2]}} <i>({{$allDepartmentStatusTickets[8]->sum() ? (int)(100 * $allDepartmentReasonTickets[8][2]/$allDepartmentStatusTickets[8]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[8][3]}} <i>({{$allDepartmentStatusTickets[8]->sum() ? (int)(100 * $allDepartmentReasonTickets[8][3]/$allDepartmentStatusTickets[8]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[8][4]}} <i>({{$allDepartmentStatusTickets[8]->sum() ? (int)(100 * $allDepartmentReasonTickets[8][4]/$allDepartmentStatusTickets[8]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[8][5]}} <i>({{$allDepartmentStatusTickets[8]->sum() ? (int)(100 * $allDepartmentReasonTickets[8][5]/$allDepartmentStatusTickets[8]->sum()) : 0}} %)</i></td>
                </tr>
                <tr>
                    <td>Kho</td>
                    <td>{{$allDepartmentStatusTickets[9]->sum()}}</td>
                    <td>{{$allDepartmentStatusTickets[9][0]}} <i>({{$allDepartmentStatusTickets[9]->sum() ? (int)(100 * $allDepartmentStatusTickets[9][0]/$allDepartmentStatusTickets[9]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStatusTickets[9][1]}} <i>({{$allDepartmentStatusTickets[9]->sum() ? (int)(100 * $allDepartmentStatusTickets[9][1]/$allDepartmentStatusTickets[9]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStatusTickets[9][2]}} <i>({{$allDepartmentStatusTickets[9]->sum() ? (int)(100 * $allDepartmentStatusTickets[9][2]/$allDepartmentStatusTickets[9]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentStatusTickets[9][3]}} <i>({{$allDepartmentStatusTickets[9]->sum() ? (int)(100 * $allDepartmentStatusTickets[9][3]/$allDepartmentStatusTickets[9]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[9][0]}} <i>({{$allDepartmentStatusTickets[9]->sum() ? (int)(100 * $allDepartmentReasonTickets[9][0]/$allDepartmentStatusTickets[9]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[9][1]}} <i>({{$allDepartmentStatusTickets[9]->sum() ? (int)(100 * $allDepartmentReasonTickets[9][1]/$allDepartmentStatusTickets[9]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[9][2]}} <i>({{$allDepartmentStatusTickets[9]->sum() ? (int)(100 * $allDepartmentReasonTickets[9][2]/$allDepartmentStatusTickets[9]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[9][3]}} <i>({{$allDepartmentStatusTickets[9]->sum() ? (int)(100 * $allDepartmentReasonTickets[9][3]/$allDepartmentStatusTickets[9]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[9][4]}} <i>({{$allDepartmentStatusTickets[9]->sum() ? (int)(100 * $allDepartmentReasonTickets[9][4]/$allDepartmentStatusTickets[9]->sum()) : 0}} %)</i></td>
                    <td>{{$allDepartmentReasonTickets[9][5]}} <i>({{$allDepartmentStatusTickets[9]->sum() ? (int)(100 * $allDepartmentReasonTickets[9][5]/$allDepartmentStatusTickets[9]->sum()) : 0}} %)</i></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<!-- /.info-box -->
    
