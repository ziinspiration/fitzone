<?php

namespace App\Models;

use App\Models\Order;
use App\Services\RajaOngkirService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone',
        'street_address',
        'province_id',
        'city_id',
        'district',
        'postal_code',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getProvinceNameAttribute()
    {
        $rajaOngkir = new RajaOngkirService();
        $provinces = $rajaOngkir->getProvinces();

        foreach ($provinces as $province) {
            if ($province['province_id'] == $this->province_id) {
                return $province['province'];
            }
        }

        return null;
    }

    public function getCityNameAttribute()
    {
        $rajaOngkir = new RajaOngkirService();
        $cities = $rajaOngkir->getCities($this->province_id);

        foreach ($cities as $city) {
            if ($city['city_id'] == $this->city_id) {
                return $city['city_name'];
            }
        }

        return null;
    }
}
