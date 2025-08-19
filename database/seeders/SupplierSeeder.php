<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $userIds = DB::table('users')->pluck('id')->toArray();

        $suppliers = [];
        for ($i = 0; $i < 100; $i++) {
            $suppliers[] = [
                'id' => (string) Str::uuid(),
                'name' => $faker->company,
                'phone' => $faker->phoneNumber,
                'contact_name' => $faker->name,
                'website' => $faker->url,
                'description' => $faker->text(200),
                'created_by' => $faker->randomElement($userIds),
                'updated_by' => $faker->randomElement($userIds),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('suppliers')->insert($suppliers);
    }
}
