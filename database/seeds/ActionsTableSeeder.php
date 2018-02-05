<?php

use Illuminate\Database\Seeder;

class ActionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { \DB::table('actions')->delete();

        \DB::table('actions')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'name' => 'Khắc phục',
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            1 =>
                array (
                    'id' => 2,
                    'name' => 'Cải tiến',
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                )
        ));
    }
}
