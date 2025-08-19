<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Carbon\Carbon;

class CategoryController extends Controller
{
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->categoryService->getAll();

        return ApiResponse::success(CategoryResource::collection($categories), "Записи успешно получены");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {
        $data = $request->validated();

        $category = $this->categoryService->create($data, $request->user()->id);

        return ApiResponse::success(CategoryResource::make($category), "Запись успешно добавлена");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = $this->categoryService->getById($id);

        return ApiResponse::success(CategoryResource::make($category), "Запись успешно получена");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, string $id)
    {
        $data = $request->validated();

        $category = $this->categoryService->getById($id);
        $categoryUpdated = $this->categoryService->update($category, $data, $request->user()->id);

        return ApiResponse::success(CategoryResource::make($categoryUpdated), "Запись успешно обновлена");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = $this->categoryService->getById($id);
        $this->categoryService->delete($category);

        return ApiResponse::success([], "Запись успешно удалена");
    }
}
