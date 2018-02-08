<?php

use Illuminate\Database\Seeder;

class ResponsibilitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { \DB::table('responsibilities')->delete();

        \DB::table('responsibilities')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'name' => 'Công ty',
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            1 =>
                array (
                    'id' => 2,
                    'name' => 'Đơn vị thi công',
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            2 =>
                array (
                    'id' => 3,
                    'name' => 'Khách hàng/Đơn vị sử dụng',
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            3 =>
                array (
                    'id' => 4,
                    'name' => 'Khác',
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                )
        ));
    }
}
