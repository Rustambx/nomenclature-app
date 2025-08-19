<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $userIds = DB::table('users')->pluck('id')->toArray();
        $categories = [];

        $numCategories = rand(30, 50);

        for ($i = 0; $i < $numCategories; $i++) {
            $parentId = null;
            if (!empty($categories) && rand(0, 1)) {
                $parentId = $faker->randomElement(array_column($categories, 'id'));
            }

            $categories[] = [
                'id' => (string) Str::uuid(),
                'name' => ucfirst($faker->word),
                'parent_id' => $parentId ?? Str::uuid(),
                'created_by' => $faker->randomElement($userIds),
                'updated_by' => $faker->randomElement($userIds),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('categories')->insert($categories);
    }
}
