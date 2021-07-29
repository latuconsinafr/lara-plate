<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* Define roles */
        $roles = getApplicationRoles();

        /* Init roles and its permissions */
        foreach ($roles as $role) {
            $createdRole =  Role::create(['name' => $role]);
            $createdPermission = Permission::create(['name' => getApplicationPermission($role)]);
            $createdPermission->assignRole($createdRole);
        }
    }
}
