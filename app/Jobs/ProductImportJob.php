<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ProductImportJob implements ShouldQueue
{
    use Queueable;

    private array $rows;
    private string $userId;

    public function __construct(array $rows, string $userId)
    {
        $this->rows = $rows;
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->rows as $row) {
            try {
                Product::create([
                    'name' => $row[0],
                    'description' => $row[1],
                    'category_id' => $row[2],
                    'supplier_id' => $row[3],
                    'price' => $row[4],
                    'created_by' => $this->userId,
                    'updated_by' => $this->userId,
                ]);
            } catch (\Throwable $exception) {
                Log::error("Ошибка импорта товара", [
                    'row' => $row,
                    'error' => $exception->getMessage()
                ]);
            }
        }

        Log::info("Chunk импортирован", [
            'count' => count($this->rows),
            'user_id' => $this->userId
        ]);
    }
}
