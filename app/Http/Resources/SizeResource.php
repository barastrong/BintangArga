<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SizeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'size' => $this->size,
            'harga' => $this->harga,
            'stock' => $this->stock,
            'gambar_size' => asset('storage/' . $this->gambar_size),
            'product_id' => $this->product_id,
        ];
    }
}