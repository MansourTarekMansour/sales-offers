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
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'offer_period' => $this->offer_periodl,
            'rate' => $this->rate,
            'discount' => $this->discount,
            'discount_percentage' => $this->discount_percentage,
            'is_daily_offer' => $this->is_daily_offer,
            'market_id' => $this->market_id,
        ];
    }
}
