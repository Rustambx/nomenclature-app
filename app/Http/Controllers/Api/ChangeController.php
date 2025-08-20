<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChangeHistoryResource;
use App\Services\ChangeHistoryService;
use Illuminate\Http\Request;

class ChangeController extends Controller
{
    private ChangeHistoryService $changeHistoryService;

    public function __construct(ChangeHistoryService $changeHistoryService)
    {
        $this->changeHistoryService = $changeHistoryService;
    }

    public function index(Request $request)
    {
        $changes = $this->changeHistoryService->getPaginated($request);

        return ApiResponse::paginated($changes, ChangeHistoryResource::class, "Записи успешно получены");
    }
}
