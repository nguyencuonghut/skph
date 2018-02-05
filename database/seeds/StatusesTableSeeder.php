<?php

use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('statuses')->delete();

        \DB::table('statuses')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'name' => 'Đang chờ xác nhận bởi trưởng bộ phận',
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            1 =>
                array (
                    'id' => 2,
                    'name' => 'Trưởng bộ phận đã xác nhận',
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            2 =>
                array (
                    'id' => 3,
                    'name' => 'Đang thực hiện khắc phục SKPH',
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            3 =>
                array (
                    'id' => 4,
                    'name' => 'Đang phân tích nguyên nhân',
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            4 =>
                array (
                    'id' => 5,
                    'name' => 'Đang đề xuất hoạt động xử lý không phù hợp',
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            5 =>
                array (
                    'id' => 6,
                    'name' => 'Đang thẩm tra đề xuất hoạt động xử lý không phù hợp',
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            6 =>
                array (
                    'id' => 7,
                    'name' => 'Đang xử lý sự không phù hợp',
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            7 =>
                array (
                    'id' => 8,
                    'name' => 'Đang xem xét mức độ sự không phù hợp',
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            8=>
                array (
                    'id' => 9,
                    'name' => 'Phiếu C.A.R đã được xử lý',
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),

        ));
    }
}
