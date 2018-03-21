<?php

use Illuminate\Database\Seeder;

use App\Models\Department;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createDep = new Department;
        $createDep->id = '1';
        $createDep->name = 'Phòng HCNS';
        $createDep->save();

        $createDep = new Department;
        $createDep->id = '2';
        $createDep->name = 'BP Sale Admin';
        $createDep->save();

        $createDep = new Department;
        $createDep->id = '3';
        $createDep->name = 'Phòng Kế Toán';
        $createDep->save();

        $createDep = new Department;
        $createDep->id = '4';
        $createDep->name = 'Phòng KSNB';
        $createDep->save();

        $createDep = new Department;
        $createDep->id = '5';
        $createDep->name = 'Phòng Bảo Trì';
        $createDep->save();

        $createDep = new Department;
        $createDep->id = '6';
        $createDep->name = 'Phòng Sản Xuất';
        $createDep->save();

        $createDep = new Department;
        $createDep->id = '7';
        $createDep->name = 'Phòng Thu Mua';
        $createDep->save();

        $createDep = new Department;
        $createDep->id = '8';
        $createDep->name = 'Phòng Kỹ Thuật';
        $createDep->save();

        $createDep = new Department;
        $createDep->id = '9';
        $createDep->name = 'Phòng QLCL';
        $createDep->save();

        $createDep = new Department;
        $createDep->id = '10';
        $createDep->name = 'BP Kho';
        $createDep->save();

        \DB::table('department_user')->insert([
            'department_id' => 1,
            'user_id' => 1
        ]);
        \DB::table('department_user')->insert([
            'department_id' => 4,
            'user_id' => 2
        ]);
        \DB::table('department_user')->insert([
            'department_id' => 1,
            'user_id' => 3
        ]);
        \DB::table('department_user')->insert([
            'department_id' => 1,
            'user_id' => 4
        ]);
        \DB::table('department_user')->insert([
            'department_id' => 4,
            'user_id' => 5
        ]);
    }
}
