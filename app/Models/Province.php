<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Province extends Model
{
    use HasFactory;
    
    protected $table = 'provinces';
    
    protected $fillable = [
        'name'
    ];

    public function cities()
    {
        return $this->hasMany(City::class);
    }
    
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}