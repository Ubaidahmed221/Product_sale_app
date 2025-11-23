<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateCommission extends Model
{
    use HasFactory;
   protected $table = 'affiliate_commissions';

    protected $fillable = [
        'affiliate_user_id',
        'order_id',
        'commission_amount',
        'status',
    ];

    public function affiliate()
    {
        return $this->belongsTo(User::class, 'affiliate_user_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
