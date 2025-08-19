<?php

namespace App\Imports;

use App\Jobs\ProductImportJob;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProductImport implements ToCollection
{
    private string $userId;

    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    public function collection(Collection $rows)
    {
        $rows = $rows->skip(1);

        $chunks = $rows->chunk(100);

        foreach ($chunks as $chunk) {
            ProductImportJob::dispatch($chunk->toArray(), $this->userId);

            Log::info("Отправлен в очередь RabbitMQ", [
                'count' => count($chunk),
                'user_id' => $this->userId,
            ]);
        }
    }
}
