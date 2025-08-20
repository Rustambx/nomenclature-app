<?php

namespace App\Services;

use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class SupplierService
{
    public function getPaginated(Request $request): LengthAwarePaginator
    {
        $perPage = (int) $request->input('per_page', 20);
        $perPage = max(1, min($perPage, 100));

        return Supplier::query()
            ->when($request->filled('name'), fn($q) =>
                $q->where('name', 'ilike', '%'.$request->string('name').'%'))
            ->orderByDesc('created_at')
            ->paginate($perPage)
            ->withQueryString();
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
