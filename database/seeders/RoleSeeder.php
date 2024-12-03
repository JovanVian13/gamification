<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::insert([
            ['name' => 'admin', 'description' => 'Administrator with full access', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'editor', 'description' => 'Can edit and manage tasks', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'viewer', 'description' => 'Can view tasks and reports', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
