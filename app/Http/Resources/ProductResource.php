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
            'stock' => $this->stock,
            'price' => $this->price,    
            'description' => $this->description,
            'provider_id' => $this->provider_id,
            'provider_name' => $this->whenLoaded('provider', function () {
                return $this->provider->name;
            }),
        ];
    }
}