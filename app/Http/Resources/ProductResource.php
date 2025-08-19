<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "description" => $this->description,
            "category_id" => $this->category_id,
            "supplier_id" => $this->supplier_id,
            "price" => $this->price,
            "file_url" => $this->file_url ?? null,
            "is_active" => $this->is_active,
            "created_by" => $this->created_by,
            "updated_by" => $this->updated_by,
            "created_at" => $this->created_at->format('Y-m-d\TH:i:s.u\Z'),
            "updated_at" => $this->updated_at->format('Y-m-d\TH:i:s.u\Z')
        ];
    }
}
