<?php

namespace App\Services;

use App\Models\Category;
use Carbon\Carbon;

class CategoryService
{
    public function getAll()
    {
        return Category::all();
    }

    public function getById($id)
    {
        return Category::findOrFail($id);
    }

    public function create(array $data, string $userId)
    {
        return Category::create([
            'name' => $data['name'],
            'parent_id' => $data['parent_id'] ?? null,
            'created_by' => $userId,
            'updated_by' => $userId,
            'created_at' => Carbon::now('UTC')->format('Y-m-d\TH:i:s.u\Z'),
        ]);
    }

    public function update(Category $category, array $data, string $userId)
    {
        $category->update([
            'name' => $data['name'],
            'parent_id' => $data['parent_id'] ?? null,
            'updated_by' => $userId,
            'updated_at' => Carbon::now('UTC')->format('Y-m-d\TH:i:s.u\Z'),
        ]);

        return $category;
    }

    public function delete(Category $category)
    {
        return $category->delete();
    }
}
