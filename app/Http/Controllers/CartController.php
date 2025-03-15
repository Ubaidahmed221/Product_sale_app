<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
   public function store(Request $request){
        try{
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1',
                'variation_values' => 'nullable|array',
                'variation_values.*' => 'exists:variation_values,id'

            ]);
            $user_id = Auth::id();
          $variationValues =  json_encode($request->variation_values);

         $existingcartItem =  Cart::where([
            'user_id' => $user_id,
            'product_id' => $request->product_id,
            'variation_values' => $variationValues,
          ])->first();

          if($existingcartItem){

            $existingcartItem->increment('quantity',$request->quantity);
            return response()->json([
                'success' => true,
                'msg' => 'Cart updated! Quantity increased!',
                'data' => $existingcartItem
            ]);
          }

           $cartItem = Cart::create([
                'user_id' => $user_id,
                'product_id' => $request->product_id,
                'variation_values' => $variationValues,
                'quantity' => $request->quantity,
            ]);
            return response()->json([
                'success' => true,
                'msg' => 'Product added to cart',
                'data' => $cartItem
            ]);
        }
        catch(\Exception $e){
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }
}
