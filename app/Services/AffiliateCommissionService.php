<?php

namespace App\Services;

use App\Models\AffiliateCommission;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AffiliateCommissionService
{
    public Static function addCommission(Order $order)
    {
        $exist = AffiliateCommission::where(['order_id' => $order->id])->first();
        if($exist){
            return;
        }
       $buyer = $order->user;
        if($buyer && $buyer->referred_by){
          $affiliate =  User::find($buyer->referred_by);
            if($affiliate){
                $commissionValue = 0;
                foreach($order->items as $item){
                    $product = $item->product;
                    $qty = $item->quantity;
                    $price = $item->price;

                   $commissioPercenatge = getSetting('commission_percentage');
                   if($product->affiliate_commission && $product->affiliate_commission > 0){
                    $commissioPercenatge = $product->affiliate_commission;
                 
                   }
                   $commissionValue += round((($price * $qty) * ($commissioPercenatge / 100)),2);
                   Log::info("Commission for product ID {$product->id} is ". round((($price * $qty) * ($commissioPercenatge / 100)),2));

                }
                if($commissionValue > 0){
                    AffiliateCommission::create([
                        'affiliate_user_id' => $affiliate->id,
                        'order_id' => $order->id,
                        'commission_amount' => $commissionValue,
                        'status' => getSetting('auto_credit_wallet') ? 'paid' : 'pending',
                    ]);
                    Log::info("Total Commission for order ID {$order->id} is ". $commissionValue);

                    if(getSetting('auto_credit_wallet')){
                        // credit to wallet
                        $affiliate->wallet_balance = $affiliate->wallet_balance + $commissionValue;
                        $affiliate->save();
                        Log::info("Commission of {$commissionValue} credited to affiliate user ID {$affiliate->id} wallet");
                    }
                }
            }
        }
    }
     public Static function rollBackCommission(Order $order)
    {
        $exist = AffiliateCommission::where(['order_id' => $order->id, 'status' => 'pending' ])->first();
        if(!$exist){
            return;
        }
        AffiliateCommission::where(['order_id' => $order->id,'status' => 'pending'])->delete();

    }
}

?>