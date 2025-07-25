<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $tags = [
            ['tag_name' => 'Laravel'],
            ['tag_name' => 'ASP'],
            ['tag_name' => 'C#'],
            ['tag_name' => 'C++'],
            ['tag_name' => 'Java'],
            ['tag_name' => 'SQL'],
        ];

        foreach ($tags as $tag) {
            Tag::create($tag);
        }
    }
}
