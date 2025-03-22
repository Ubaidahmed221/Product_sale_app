<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingZone extends Model
{
    use HasFactory;
    protected $fillable = [
        'country',
        'state',
        'shipping_cost_pkr',
        'shipping_cost_usd'
    ];

    public function countryRelation(){
        return $this->belongsTo(Country::class,'country','iso2');
    }
    public function stateRelation(){
        return $this->belongsTo(State::class,'state','state_code');
    }
}
