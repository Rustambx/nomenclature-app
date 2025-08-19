<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        return response()->json([
            "message" => "Записи успешно получены",
            "data" => $categories,
            "timestamp" => Carbon::now('UTC')->format('Y-m-d\TH:i:s.u\Z'),
            "success" => true
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {
        $data = $request->validated();

        $category = Category::create([
            'name' => $data['name'],
            'parent_id' => $data['parent_id'] ?? null,
            'created_by' => $request->user()->id,
            'updated_by' => $request->user()->id,
            'created_at' => Carbon::now('UTC')->format('Y-m-d\TH:i:s.u\Z'),
        ]);


        return response()->json([
            "message" => "Запись успешно добавлена",
            "data" => $category,
            "timestamp" => Carbon::now('UTC')->format('Y-m-d\TH:i:s.u\Z'),
            "success" => true
        ]);


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::findOrFail($id);

        return response()->json([
            "message" => "Запись успешно получена",
            "data" => $category,
            "timestamp" => Carbon::now('UTC')->format('Y-m-d\TH:i:s.u\Z'),
            "success" => true
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, string $id)
    {
        $category = Category::findOrFail($id);

        $data = $request->validated();
        $category->update([
            'name' => $data['name'],
            'parent_id' => $data['parent_id'] ?? null,
            'updated_by' => $request->user()->id,
            'updated_at' => Carbon::now('UTC')->format('Y-m-d\TH:i:s.u\Z'),
        ]);

        return response()->json([
            "message" => "Запись успешно обновлена",
            "data" => $category,
            "timestamp" => Carbon::now('UTC')->format('Y-m-d\TH:i:s.u\Z'),
            "success" => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
