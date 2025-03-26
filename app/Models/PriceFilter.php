<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceFilter extends Model
{
    use HasFactory;

    protected $fillable = ['min_price','max_price'];
}
