<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('UsersTableSeeder');
        $this->call('IndustriesTableSeeder');
        $this->call('DepartmentsTableSeeder');
        $this->call('SettingsTableSeeder');
        $this->call('PermissionsTableSeeder');
        $this->call('RolesTablesSeeder');
        $this->call('RolePermissionTableSeeder');
        $this->call('UserRoleTableSeeder');
        $this->call('ActionsTableSeeder');
        $this->call('AreasTableSeeder');
        $this->call('SourcesTableSeeder');
        $this->call('StatusesTableSeeder');
        $this->call('LevelsTableSeeder');
        $this->call('ResponsibilitiesTableSeeder');
        $this->call('ReasonTypesTableSeeder');
    }
}
