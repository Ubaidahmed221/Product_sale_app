<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;


class PaymentController extends Controller
{
    public function success(Order $order) {
        try{
            Stripe::setApiKey(config('services.stripe.secret'));
         $session =   Session::retrieve($order->stripe_session_id);
       $paymentIntent =  PaymentIntent::retrieve($session->payment_intent);
            $order->update([
                'payment_status' => Order::PAYMENT_SUCCESS,
                'status' => Order::STATUS_PROCESSING,
                'transaction_id' => $paymentIntent->id
            ]);
            return redirect()->route('thank-you',['id'=> $order->id]);
        }
        catch(\Exception $e){
         return   abort(404,"something went wrong");
        }
      
    }

    public function cancel(Order $order) {
        try{
            $order->update([
                'payment_status' => Order::PAYMENT_FAILED,
                'status' => Order::STATUS_FAILED
            ]);
          return view('payment.failed');
        }
        catch(\Exception $e){
         return   abort(404,"something went wrong");
        }

    }

    public function thankYou($id){
        try{
          $order =  Order::with('items')->findOrFail($id);
            return view('payment.thank-you',compact('order'));
        }
        catch(\Exception $e){
         return   abort(404,"something went wrong");
        }
    }
}
