<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductImportRequest;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Http\Requests\Product\ProductUploadRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = $this->productService->getPaginated($request);

        return ApiResponse::paginated($products, ProductResource::class, "Записи успешно получены");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        $data = $request->validated();

        $product = $this->productService->create($data, $request->user()->id);

        return ApiResponse::success(ProductResource::make($product), "Запись успешно добавлена");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = $this->productService->getById($id);

        return ApiResponse::success(ProductResource::make($product), "Запись успешно получена");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, string $id)
    {
        $data = $request->validated();
        $product = $this->productService->getById($id);

        $product = $this->productService->update($product, $data, $request->user()->id);

        return ApiResponse::success(ProductResource::make($product), "Запись успешно обновлена");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = $this->productService->getById($id);

        $this->productService->delete($product);

        return ApiResponse::success([], "Запись успешно удалена");
    }

    public function upload(ProductUploadRequest $request)
    {
        $product = $this->productService->getById($request->product_id);

        $data = $this->productService->uploadImage($product, $request->file('file'), $request->user()->id);

        return ApiResponse::success($data, "Файл успешно загружен");
    }

    public function import(ProductImportRequest $request)
    {
        $path = $this->productService->importFile($request->file('file'), $request->user()->id);

        return ApiResponse::success([], "Импорт запущен. Проверяйте логи.");
    }
}
