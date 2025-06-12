<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory;
    
    protected $table = 'cities';
    
    protected $fillable = [
        'name',
        'province_id'
    ];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
    
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}