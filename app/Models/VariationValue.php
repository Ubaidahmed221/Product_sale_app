<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariationValue extends Model
{
    use HasFactory;
    
    protected $table = "variation_values";

    protected $fillable = ['variation_id','value'];
    
    public function variation(){
        return $this->belongsTo(Variation::class);
    }

    public function productVariation(){
        return $this->hasMany(ProductVariation::class,'variation_value_id');
    }
}
