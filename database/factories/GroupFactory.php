<?php

namespace Database\Factories;

use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class GroupFactory extends Factory
{
    protected $model = Group::class;

    public function definition(): array
    {
        $faker = \Faker\Factory::create('en_US');
        return [
            'name' => $faker->unique()->word(),
            'description' => $faker->sentence(),
            'image' => 'images/Default_image.jpg',
            'status' => $faker->randomElement([0, 1]),
            'status_show' => 1,
        ];
    }
} 