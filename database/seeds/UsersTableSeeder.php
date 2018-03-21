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
                    'name' => 'Nguyễn Văn Cường',
                    'email' => 'nguyencuonghut55@gmail.com',
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
                    'name' => 'Lê Văn Khoa',
                    'email' => 'levankhoa@honghafeed.com.vn',
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