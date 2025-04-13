<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index(){
        try{
         $cartitems =  Cart::where('user_id',Auth::id())->get();
         if(count($cartitems) == 0){
            return redirect()->route('cart');
         }
            return view('checkout',compact('cartitems'));
        }
        catch(\Exception $e){
            return abort(404);

        }
    }
}
