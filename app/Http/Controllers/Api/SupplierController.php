<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Supplier\SupplierStoreRequest;
use App\Http\Requests\Supplier\SupplierUpdateRequest;
use App\Http\Resources\SupplierResource;
use App\Services\SupplierService;
use Illuminate\Http\Request;

class SupplierController extends Controller
{

    private SupplierService $supplierService;

    public function __construct(SupplierService $supplierService)
    {
        $this->supplierService = $supplierService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $paginator = $this->supplierService->getPaginated($request);

        return ApiResponse::paginated($paginator, SupplierResource::class, "Записи успешно получены");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SupplierStoreRequest $request)
    {
        $data = $request->validated();

        $supplier = $this->supplierService->create($data, $request->user()->id);

        return ApiResponse::success(SupplierResource::make($supplier), "Запись успешно добавлена");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $supplier = $this->supplierService->getById($id);

        return ApiResponse::success(SupplierResource::make($supplier), "Запись успешно получена");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SupplierUpdateRequest $request, string $id)
    {
        $data = $request->validated();

        $supplier = $this->supplierService->getById($id);
        $supplier = $this->supplierService->update($supplier, $data, $request->user()->id);

        return ApiResponse::success(SupplierResource::make($supplier), "Запись успешно обновлена");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $supplier = $this->supplierService->getById($id);

        $this->supplierService->delete($supplier);

        return ApiResponse::success([], "Запись успешно удалена");
    }
}
