<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Seller extends Model
{
    use HasFactory;
    
    protected $table = 'sellers';
    protected $fillable = ['user_id', 'nama_penjual', 'email_penjual', 'foto_profil', 'nomor_seri','no_telepon'];

    /**
     * Boot method to automatically generate serial number when creating a new seller
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($seller) {
            if (empty($seller->nomor_seri)) {
                $seller->nomor_seri = self::generateSerialNumber();
            }
        });
    }
    
    public static function generateSerialNumber()
    {
        $prefix = 'SLR-';
        $dateFormat = date('Ymd'); // Format: YYYYMMDD
        
        // Count how many sellers were created today
        $todayCount = self::whereDate('created_at', today())
                         ->where('nomor_seri', 'like', $prefix . $dateFormat . '%')
                         ->count();
        
        // Increment for new seller
        $sequence = str_pad($todayCount + 1, 2, '0', STR_PAD_LEFT);
        
        return $prefix . $dateFormat . $sequence;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}