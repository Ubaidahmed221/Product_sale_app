<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_FAILED = 'failed';

    const PAYMENT_PENDING = 'pending';
    const PAYMENT_SUCCESS = 'success';
    const PAYMENT_FAILED = 'failed';

    protected $fillable = [
        'user_id',
        'billing_address',
        'shipping_address',
        'payment_method',
        'payment_status',
        'status',
        'subtotal',
        'currency',
        'shipping_amount',
        'total',
        'transaction_id',
        'stripe_session_id'
    ];

    protected $casts = [
        'billing_address' => 'array' ,
        'shipping_address' => 'array'
    ];

    
    public function items(){
        return $this->hasMany(OrderItem::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
