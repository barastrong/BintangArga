<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'nama_barang' => $this->nama_barang,
            'description' => $this->description,
            'lokasi' => $this->lokasi,
            'alamat_lengkap' => $this->alamat_lengkap,
            'gambar' => asset('storage/' . $this->gambar),
            'category_id' => $this->category_id,
            'seller_id' => $this->seller_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'sizes' => SizeResource::collection($this->whenLoaded('sizes')),
        ];
    }
}