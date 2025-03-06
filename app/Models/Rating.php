<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rating extends Model
{
    use HasFactory;
    protected $table= 'ratings';
    protected $fillable = ['product_id', 'user_id', 'rating', 'review'];
    
    public function purchase()
{
    return $this->belongsTo(Purchase::class);
}
public function user()
{
    return $this->belongsTo(User::class);
}
}
