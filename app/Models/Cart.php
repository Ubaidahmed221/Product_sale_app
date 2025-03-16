<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','product_id','variation_values','quantity'];
    
    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function getVariationValuesAttribute($value){
        return json_decode($value, true) ?? [];
    }

    public function getVariationDetailsAttribute()
{
    $variationIds = $this->variation_values;

    if (empty($variationIds)) {
        return collect(); // Return an empty collection instead of null
    }

    return VariationValue::whereIn('id', $variationIds)
        ->with('variation')
        ->get();
}

}
