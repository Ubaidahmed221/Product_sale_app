<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasFactory;
    protected $table = "products_variations";

    protected $fillable = ['product_id','variation_id','variation_value_id'];

    public function products(){
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function variation(){
        return $this->belongsTo(Variation::class);
    }
    public function variationValue(){
        return $this->belongsTo(VariationValue::class);
    }

}
