<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'superAdmin'
            ],
            [
                'name' => 'admin'
            ],
            [
                'name' => 'coach'
            ],
            [
                'name' => 'trainee'
            ]
        ];
        foreach ($roles as $role)
        {
            Role::create($role);
        }
    }
}
