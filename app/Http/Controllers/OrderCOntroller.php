<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\PaymentGateway;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Stripe\Stripe;
use Stripe\Checkout\Session;

class OrderCOntroller extends Controller
{
    public function store(OrderRequest $request){
        try{
            Log::info($request->all());
            $user = auth()->user();
          $cartItem =  Cart::where('user_id',$user->id)->get();
          if($cartItem->count() == 0){
            return response()->json([
                'success' => false,
                'message' => "Your cart is empty!"
            ]);
          }

       $paymentGateway =  PaymentGateway::findOrFail($request->payment);

       DB::beginTransaction();
    $order =   Order::create([
        'user_id' => $user->id,
        'billing_address' => $this->preparedAddressData($request),
        'shipping_address' => $request->has("ship_to_different") ? $this->preparedAddressData($request,'shipping',$request->has("ship_to_different")) : NULL,
        'payment_status' => Order::PAYMENT_PENDING,
        'payment_method' => $paymentGateway->name,
        'status' => Order::STATUS_PENDING,
        'currency' => getUserCurrency() ? 'pkr' : 'usd',
        'subtotal' => getCartSubTotal(),
        'shipping_amount' => shippingAmount(),
        'total' => getCartTotal(),
       
       ]);

       foreach($cartItem as $cartItems){
        $price = $this->getProductPrice($cartItems);
        $order->items()->create([ 
            'product_id' => $cartItems->product_id,
            'product_title' => $cartItems->product->title,
            'price' => $price,
            'quantity' => $cartItems->quantity,
            'total' => number_format($cartItems->quantity * $price,2)
        
        ]);
       }    
       Cart::where('user_id',$user->id)->delete();
       DB::commit();
       if($paymentGateway->type === 'cod'){
        return response()->json([
            'success' => true,
            'type' => 0,
            'message' => 'Order Place Successfully with COD!',
            'data' => $order
        ]);
       }
       else{
        return $this->handlePaymentGateway($paymentGateway->name,$order);
       }

        }
        catch(\Exception $e){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    private function preparedAddressData(OrderRequest $request, $type = '',$isShipping = false){
            $prefix = $type?"{$type}_":"";
           $user_id = auth()->user()->id;
           $addressType = $isShipping ? 'shipping' : 'billing';

         $userAddress =[
            'first_name' => $request->input("{$prefix}first_name"),
            'last_name' => $request->input("{$prefix}last_name"),
            'email' => $request->input("{$prefix}email"),
            'phone' => $request->input("{$prefix}phone"),
            'address_1' => $request->input("{$prefix}address_1"),
            'address_2' => $request->input("{$prefix}address_2") ? $request->input("{$prefix}address_2"): null,
            'country' => $request->input("{$prefix}country"),
            'state' => $request->input("{$prefix}state"),
            'city' => $request->input("{$prefix}city"),
            'zip' => $request->input("{$prefix}zip"),
            'is_shipping' => $isShipping,
        ];

        Address::updateOrCreate([
            'user_id' => $user_id,
            'type' => $addressType],
            $userAddress
        );
        return $userAddress;
    }

    private function getProductPrice($cartItem){
        return getUserCurrency() ? $cartItem->product->pkr_price : $cartItem->product->usd_price;  
    }

    private function handlePaymentGateway($paymentMethod,$order){
        $currency = getUserCurrency() ? 'pkr' : 'usd';

        $paymentMethod  = strtolower($paymentMethod);

        switch($paymentMethod){
            case 'stripe':
                    Stripe::setApiKey(config('services.stripe.secret'));
                $session =  Session::create([
                        'payment_method_types' => ['card'],
                        'line_items' => [[
                            'price_data' => [
                                'currency' => $currency,
                                'product_data' => [
                                    'name' => 'Order #'.$order->id,
                                ],
                                'unit_amount' => intval($order->total * 100),
                            ],
                            'quantity' => 1,
                        ]],
                            'mode' => 'payment',
                            'success_url' => route('payment.success',['order'=> $order->id]),
                            'cancel_url' => route('payment.cancel',['order'=> $order->id])
                        ]);
                        $order->stripe_session_id = $session->id;
                        $order->save();
                        return response()->json([
                            'success' => true,
                            'type' => 1,
                            'gateway' => $paymentMethod,
                            'session_id' => $session->id,

                        ]);

            case 'paypal':
                break;
            default:
                throw new Exception("Unsupported payment method: $paymentMethod");
        }


    }
}
