<?php

use Illuminate\Database\Seeder;

class SourcesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { \DB::table('sources')->delete();

        \DB::table('sources')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'name' => 'Đánh giá bên ngoài',
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            1 =>
                array (
                    'id' => 2,
                    'name' => 'Đánh giá nội bộ',
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            2 =>
                array (
                    'id' => 3,
                    'name' => 'Quá trình (trong NM)',
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            3 =>
                array (
                    'id' => 4,
                    'name' => 'Khiếu nại khách hàng',
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                )
        ));
    }
}
