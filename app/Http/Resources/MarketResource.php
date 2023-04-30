<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class MarketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request, $includeCategory = true): array
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'logo' => url(Storage::url($this->logo)),
        ];

        if ($includeCategory) {
            $data['category'] = new CategoryResource($this->category);
        }

        return $data;
    }
}
