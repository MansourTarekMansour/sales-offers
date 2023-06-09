<?php
namespace App\Http\Resources;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image' => url(Storage::url($this->image)),
        ];
    }

    public function with($request)
    {
        return [
            'status' => 'success',
            'message' => 'Category successfully retrieved.',
        ];
    }
}
