<?php

namespace App\Services;

use App\Imports\ProductImport;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ProductService
{
    public function getAll()
    {
        return Product::all();
    }

    public function getById(string $id)
    {
        return Product::findOrFail($id);
    }

    public function create(array $data, string $userId)
    {
        return Product::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'category_id' => $data['category_id'],
            'supplier_id' => $data['supplier_id'],
            'price' => $data['price'],
            'created_by' => $userId,
            'updated_by' => $userId,
            'created_at' => Carbon::now('UTC')->format('Y-m-d\TH:i:s.u\Z'),
        ]);
    }

    public function update(Product $product, array $data, string $userId)
    {
        $product->update([
            'name' => $data['name'],
            'description' => $data['description'],
            'category_id' => $data['category_id'],
            'supplier_id' => $data['supplier_id'],
            'price' => $data['price'],
            'updated_by' => $userId,
            'updated_at' => Carbon::now('UTC')->format('Y-m-d\TH:i:s.u\Z'),
        ]);

        return $product;
    }

    public function delete(Product $product)
    {
        return $product->delete();
    }

    public function uploadImage(Product $product, UploadedFile $file, string $userId)
    {
        $fileName = Str::uuid(). '.' .$file->getClientOriginalExtension();
        $path = Storage::disk('minio')->putFileAs('products', $file, $fileName);
        $url = env('MINIO_PUBLIC_URL') . '/products/' . $fileName;

        $product->update([
            'file_url' => $url,
            'updated_by' => $userId,
        ]);

        return [
            'file_url' => $url,
        ];
    }

    public function importFile(UploadedFile $file, string $userId): string
    {
        $path = $file->store('imports');

        Log::info("Импорт товаров начат", ['file' => $path]);

        Excel::import(new ProductImport($userId), $path);

        return $path;
    }
}
