<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleId = DB::table('roles')
            ->where('name', 'super_admin')
            ->value('id');

        DB::table('users')->updateOrInsert([
            'name'       => 'Super Admin',
            'email'      => 'superadmin@example.com',
            'password'   => Hash::make('password'),
            'role_id'    => $roleId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
