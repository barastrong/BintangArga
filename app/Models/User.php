<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'google_id',
        'github_id',
        'profile_image',
        'otp_code',
        'otp_expires_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be appended to the model's array form.
     *
     * @var array
     */
    protected $appends = ['user_type'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified' => 'boolean',
            'password' => 'hashed',
            'otp_expires_at' => 'datetime',
        ];
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    public function seller()
    {
        return $this->hasOne(Seller::class);
    }

    public function isSeller()
    {
        return $this->seller()->exists();
    }

    public function delivery()
    {
        return $this->hasOne(Delivery::class);
    }

    public function isDelivery()
    {
        return $this->delivery()->exists();
    }

    public function getUserType()
    {
        if ($this->isSeller()) {
            return 'seller';
        } elseif ($this->isDelivery()) {
            return 'delivery';
        }
        return 'user';
    }

    /**
     * Get user type attribute (accessor)
     */
    public function getUserTypeAttribute()
    {
        return $this->getUserType();
    }
}