<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateSetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'commission_percentage',
        'min_payout',
        'auto_credit_wallet',
    ];
    
}
