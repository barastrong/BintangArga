<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = ['category_id', 'nama_barang', 'description', 'gambar','alamat_lengkap','lokasi'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sizes()
    {
        return $this->hasMany(Size::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function getMinPriceAttribute()
    {
        return $this->sizes->min('harga');
    }

    public function getMaxPriceAttribute()
    {
        return $this->sizes->max('harga');
    }

    public function getTotalStockAttribute()
    {
        return $this->sizes->sum('stock');
    }
    public function purchases()
{
    return $this->hasMany(Purchase::class);
}
}
