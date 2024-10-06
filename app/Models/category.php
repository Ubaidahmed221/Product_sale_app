<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'parent_id'
    ];

        public function parent(){
            return $this->belongsTo(category::class,'parent_id');
        }

}
