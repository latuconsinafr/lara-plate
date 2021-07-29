<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* Create dummy super admin */
        $superAdmin = new User([
            'name' => 'SuperAdmin',
            'email' => 'superadmin@laraplate.com',
            'email_verified_at' => now(),
            'password' => 'lara-plate@123',
            'remember_token' => Str::random(10)
        ]);

        /* Save the dummy super admin and assign related role */
        $superAdmin->save();
        $superAdmin->assignRole(getApplicationRoles()[1]); // 1 for super-admin
    }
}
