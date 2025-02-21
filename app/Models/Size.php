<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Size extends Model
{
    use HasFactory;
    protected $table = 'sizes';
    protected $fillable = ['product_id', 'size', 'gambar_size', 'harga', 'stock'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
