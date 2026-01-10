<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'country_code',
        'phone_number',
        'currency',
        'is_verified',
        'verification_token',
        'token_expires_at',
        'country',
        'state',
        'is_block',
        'referral_code',
        'referred_by',
        'wallet_balance',
        'wallet_balance_usd',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->referral_code)) {
                $user->referral_code = Str::upper(Str::random(10));
                do {
                   
                    $code = strtoupper(Str::random(8));
                } while (self::where('referral_code', $code)->exists());
                $user->referral_code = $code;
            }
        });
    }

    public function affiliateComissions(){
        return $this->hasMany(AffiliateCommission::class, 'affiliate_user_id');
    }
    public function referrals(){
        return $this->hasMany(User::class, 'referred_by');
    }
    public function addresses(){
        return $this->hasMany(Address::class);
    }
    public function orders(){
        return $this->hasMany(Order::class);
    }
    public function billingAddresses(){
        return $this->hasOne(Address::class)->where('type','billing');
    }
    public function shippingAddresses(){
        return $this->hasOne(Address::class)->where('type','shipping');
    }

      public function sendMessage(){

        return $this->hasMany(Message::class, 'from_id');
    }
    public function receivedMessage(){

        return $this->hasMany(Message::class, 'to_id');
    }
        public function messages(){

        return $this->hasMany(Message::class, 'from_id');
    }
        
}
