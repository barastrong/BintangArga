<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_serial',
        'nama',
        'no_telepon',
        'email',
        'foto_profile',
        'user_id',
    ];

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($delivery) {
            if (empty($delivery->delivery_serial)) {
                $delivery->delivery_serial = self::generateDeliverySerial();
            }
        });
    }

    private static function generateDeliverySerial()
    {
        do {
            $serial = 'DLV-' . strtoupper(uniqid());
        } while (self::where('delivery_serial', $serial)->exists());
        
        return $serial;
    }

    // Get random delivery
    public static function getRandomDelivery()
    {
        return self::inRandomOrder()->first();
    }
}