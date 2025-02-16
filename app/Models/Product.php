<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;
    protected $fillable= [
        'title',
        'pkr_price',
        'usd_price',
        'stock',
        'description',
        'add_information',
        'sku',
        'deleted_at'
    ];

    public static function boot(){
        parent::boot();

        static::creating(function($product){
            $product->sku = $product->generateSKU();
        });
    }
    public function generateSKU(){
        $prefix = 'PROD';
        $uniquePart = strtoupper(Str::random(6));
        $timestamp = now()->timestamp;
        return "{$prefix}-{$uniquePart}-{$timestamp}";
    }

    public function firstImage(){
        return $this->hasOne(ProductImage::class)->oldest();
    }
    public function images(){
        return $this->hasMany(ProductImage::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'products_categories');
    }
    public function productVariations()
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function variations(){
        return $this->hasManyThrough(
            Variation::class,
            ProductVariation::class,
            'product_id',
            'id',
            'id',
            'variation_id'
        );
    }
    public function variationValues(){
        return $this->hasManyThrough(
            VariationValue::class,
            ProductVariation::class,
            'product_id',
            'id',
            'id',
            'variation_value_id'
        );
    }
}
