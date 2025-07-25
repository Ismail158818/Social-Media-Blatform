<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $faker = \Faker\Factory::create('en_US');
        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'group_id' => null, // سيتم تعيينه في Seeder لبعض المنشورات
            'title' => $faker->sentence(),
            'content' => $faker->paragraph(),
            'image' => 'images/Default_image.jpg',
            'status' => 1,
        ];
    }
} 