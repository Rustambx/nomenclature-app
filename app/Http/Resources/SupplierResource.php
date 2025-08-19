<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource
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
            "phone" => $this->phone,
            "contact_name" => $this->contact_name,
            "website" => $this->website,
            "description" => $this->description,
            "created_by" => $this->created_by,
            "updated_by" => $this->updated_by,
            "created_at" => $this->created_at->format('Y-m-d\TH:i:s.u\Z'),
            "updated_at" => $this->updated_at->format('Y-m-d\TH:i:s.u\Z'),
        ];
    }
}
