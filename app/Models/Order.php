<?php

namespace App\Models;

use App\Models\Address;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address_id',
        'order_number',
        'subtotal',
        'tax_amount',
        'shipping_cost',
        'total_amount',
        'shipping_service',
        'status',
        'payment_status',
        'payment_method',
        'payment_token',
        'paid_at'
    ];

    protected $appends = ['is_paid', 'is_unpaid'];

    public function getIsPaidAttribute()
    {
        return !is_null($this->paid_at);
    }

    public function getIsUnpaidAttribute()
    {
        return is_null($this->paid_at);
    }

    protected $dates = [
        'paid_at',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }
}
