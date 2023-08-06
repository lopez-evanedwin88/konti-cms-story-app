<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Story;
use App\Models\User;

class StorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Story::truncate();

        Story::factory()->count(15)->create()->each(function ($story) {
            $story->users()->attach([
                User::inRandomOrder()->first()->id,
                User::inRandomOrder()->first()->id,
            ]);
        });
    }
}
