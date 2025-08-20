<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChangeHistoryResource extends JsonResource
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
            "user_id" => $this->user_id,
            "entity_type" => $this->entity_type,
            "entity_id" => $this->entity_id,
            "action" => $this->action,
            "changes" => $this->changes,
            "created_at" => $this->created_at,
        ];
    }
}
