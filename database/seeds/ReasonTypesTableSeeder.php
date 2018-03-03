<?php

use Illuminate\Database\Seeder;

class ReasonTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('reason_types')->delete();

        \DB::table('reason_types')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'name' => 'Con người',
                    'description' => 'Đào tạo nhân viên, trình độ chuyên môn, giáo dục, bí quyết, động lực, sự chú ý, kỷ luật, sự cống hiến, sự cam kết',
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            1 =>
                array (
                    'id' => 2,
                    'name' => 'Máy móc',
                    'description' => 'Thiết bị, dụng cụ, áp suất, độ chính xác, bôi trơn, rò rỉ, bảo trì, điều chỉnh, thiết bị đo đạc, sửa chữa, vận tốc, làm sạch',
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            2 =>
                array (
                    'id' => 3,
                    'name' => 'Nguyên liệu',
                    'description' => 'Kích thước, thành phần, tính chất cơ học, bảo quản, đóng gói, vận chuyển',
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            3 =>
                array (
                    'id' => 4,
                    'name' => 'Phương pháp',
                    'description' => 'Đặc điểm kỹ thuật, thủ tục, hướng dẫn, thiết kế, chương trình',
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            4 =>
                array (
                    'id' => 5,
                    'name' => 'Đo lường',
                    'description' => 'Độ chính xác của thiết bị đo, phương pháp đo',
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            5 =>
                array (
                    'id' => 6,
                    'name' => 'Môi trường',
                    'description' => 'Không gian, nhiệt độ, ánh sáng, độ rung, độ ẩm',
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
        ));
    }
}
