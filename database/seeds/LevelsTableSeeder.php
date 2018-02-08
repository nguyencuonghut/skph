<?php

use Illuminate\Database\Seeder;

class LevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { \DB::table('levels')->delete();

        \DB::table('levels')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'name' => 'Nghiêm trọng',
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            1 =>
                array (
                    'id' => 2,
                    'name' => 'Trung bình',
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            2 =>
                array (
                    'id' => 3,
                    'name' => 'Nhẹ',
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                )
        ));
    }
}
