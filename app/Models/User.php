<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Illuminate\Notifications\Notifiable;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser
{

    protected $appends = ['full_name'];

    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'verification_code',
        'is_verified',
        'avatar',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function cartItemCount()
    {
        return $this->cart ? $this->cart->items()->count() : 0;
    }

    public function cartGrandTotal()
    {
        return $this->cart ? $this->cart->items->sum('total_amount') : 0;
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->role_id === 1;
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function setFullNameAttribute($value)
    {
        $names = explode(' ', $value, 2);
        $this->attributes['first_name'] = $names[0] ?? '';
        $this->attributes['last_name'] = $names[1] ?? '';
    }
}
