<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class TagFactory extends Factory
{
    protected $model = Tag::class;

    public function definition(): array
    {
        $faker = \Faker\Factory::create('en_US');
        return [
            'tag_name' => $faker->unique()->word(),
            'group_id' => null,
        ];
    }
} 