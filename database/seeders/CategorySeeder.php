<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Arr;
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

        $numCategories = rand(30, 50);
        $insertedIds = [];

        for ($i = 0; $i < $numCategories; $i++) {
            $id = (string) Str::uuid();

            $parentId = (!empty($insertedIds) && rand(0, 1))
                ? Arr::random($insertedIds)
                : null;

            DB::table('categories')->insert([
                'id'         => $id,
                'name'       => ucfirst($faker->unique()->word),
                'parent_id'  => $parentId,
                'created_by' => Arr::random($userIds),
                'updated_by' => Arr::random($userIds),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $insertedIds[] = $id;
        }
    }
}
