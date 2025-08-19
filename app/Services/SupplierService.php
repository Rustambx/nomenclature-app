<?php

namespace App\Services;

use App\Models\Supplier;
use Carbon\Carbon;

class SupplierService
{
    public function getAll()
    {
        return Supplier::all();
    }

    public function getById($id)
    {
        return Supplier::findOrFail($id);
    }

    public function create(array $data, string $userId)
    {
        return Supplier::create([
            "name" => $data["name"],
            "phone" => $data["phone"],
            "contact_name" => $data["contact_name"],
            "website" => $data["website"],
            "description" => $data["description"],
            "created_by" => $userId,
            "updated_by" => $userId,
            "created_at" => Carbon::now('UTC')->format('Y-m-d\TH:i:s.u\Z'),
        ]);
    }

    public function update(Supplier $supplier, array $data, string $userId)
    {
        $supplier->update([
            "name" => $data["name"],
            "phone" => $data["phone"],
            "contact_name" => $data["contact_name"],
            "website" => $data["website"],
            "description" => $data["description"],
            "updated_by" => $userId,
            "updated_at" => Carbon::now('UTC')->format('Y-m-d\TH:i:s.u\Z'),
        ]);

        return $supplier;
    }

    public function delete(Supplier $supplier)
    {
        return $supplier->delete();
    }
}
