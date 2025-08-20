<?php

namespace App\Services;

use App\Models\ChangeHistory;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ChangeHistoryService
{
    public function getPaginated(Request $request): LengthAwarePaginator
    {
        $perPage = $request->query('per_page', 20);
        $perPage = max(1, min($perPage, 100));

        return ChangeHistory::query()
            ->when($request->filled('action'), fn($q) =>
                $q->where('action', 'ilike', '%'.$request->query('action').'%'))
            ->when($request->filled('entity_type'), fn($q) =>
                $q->where('entity_type', 'ilike', '%'.$request->query('entity_type').'%'))
            ->orderByDesc('created_at')
            ->paginate($perPage)
            ->withQueryString();
    }
}
