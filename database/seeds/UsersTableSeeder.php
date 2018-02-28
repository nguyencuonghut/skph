<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('users')->delete();

        \DB::table('users')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'name' => 'Admin',
                    'email' => 'nguyenvancuong@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'address' => '',
                    'work_number' => 0,
                    'personal_number' => 0,
                    'image_path' => '',
                    'remember_token' => null,
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            1 =>
                array (
                    'id' => 2,
                    'name' => 'Tạ Văn Toại',
                    'email' => 'tavantoai@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'address' => '',
                    'work_number' => 0,
                    'personal_number' => 0,
                    'image_path' => '',
                    'remember_token' => null,
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            2 =>
                array (
                    'id' => 3,
                    'name' => 'Hoàng Liên Sơn',
                    'email' => 'hoanglienson@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'address' => '',
                    'work_number' => 0,
                    'personal_number' => 0,
                    'image_path' => '',
                    'remember_token' => null,
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            3 =>
                array (
                    'id' => 4,
                    'name' => 'Dương Xuân Sơn',
                    'email' => 'duongxuanson@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'address' => '',
                    'work_number' => 0,
                    'personal_number' => 0,
                    'image_path' => '',
                    'remember_token' => null,
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            4 =>
                array (
                    'id' => 5,
                    'name' => 'Ngô Duy Thạo',
                    'email' => 'ngoduythao@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'address' => '',
                    'work_number' => 0,
                    'personal_number' => 0,
                    'image_path' => '',
                    'remember_token' => null,
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            5 =>
                array (
                    'id' => 6,
                    'name' => 'Phạm Thành Thứ',
                    'email' => 'phamthanhthu@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'address' => '',
                    'work_number' => 0,
                    'personal_number' => 0,
                    'image_path' => '',
                    'remember_token' => null,
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            6 =>
                array (
                    'id' => 7,
                    'name' => 'Phạm Thị Trang',
                    'email' => 'phamthitrang@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'address' => '',
                    'work_number' => 0,
                    'personal_number' => 0,
                    'image_path' => '',
                    'remember_token' => null,
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
        ));
    }
}