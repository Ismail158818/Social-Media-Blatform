<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition(): array
    {
        static $roles = [
            ['name' => 'SuperAdmin'],
            ['name' => 'Admin'],
            ['name' => 'Coach'],
            ['name' => 'Trainer'],
            
        ];
        static $index = 0;
        if ($index >= count($roles)) {
            $index = 0;
        }
        return $roles[$index++];
    }
} 