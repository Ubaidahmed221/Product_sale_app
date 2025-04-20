<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','type','first_name','last_name','email','phone','address_1','address_2','country','state','city','zip'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
