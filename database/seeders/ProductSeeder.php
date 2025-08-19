<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $userIds = DB::table('users')->pluck('id')->toArray();
        $supplierIds = DB::table('suppliers')->pluck('id')->toArray();
        $categoryIds = DB::table('categories')->pluck('id')->toArray();

        $products = [];
        for ($i = 0; $i < 5000; $i++) {
            $fileName = $faker->uuid . '.jpg';
            $fileUrl = "https://minio.example.com/products/{$fileName}";

            $products[] = [
                'id' => (string) Str::uuid(),
                'name' => ucfirst($faker->words(rand(2, 5), true)),
                'description' => $faker->text(200),
                'category_id' => $faker->randomElement($categoryIds),
                'supplier_id' => $faker->randomElement($supplierIds),
                'price' => $faker->randomFloat(2, 1, 1000),
                'file_url' => $fileUrl,
                'is_active' => true,
                'created_by' => $faker->randomElement($userIds),
                'updated_by' => $faker->randomElement($userIds),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('products')->insert($products);
    }
}
