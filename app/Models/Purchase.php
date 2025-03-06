<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purchase extends Model
{
    use HasFactory;
    protected $table = 'purchases';
    protected $fillable = [
        'user_id',
        'product_id',
        'size_id',
        'quantity',
        'total_price',
        'status',
        'payment_status',
        'shipping_address',
        'phone_number',
        'description',
        'status_pembelian',
        'payment_method',
        'seller_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function rating()
    {
        return $this->belongsTo(Rating::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }
}
