<?php

use Illuminate\Database\Seeder;

class AreasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { \DB::table('areas')->delete();

        \DB::table('areas')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'name' => 'Bộ phận',
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            1 =>
                array (
                    'id' => 2,
                    'name' => 'Khách hàng',
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            2 =>
                array (
                    'id' => 3,
                    'name' => 'Nhà cung cấp',
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                )
        ));
    }
}
