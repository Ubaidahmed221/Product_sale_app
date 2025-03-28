<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function index(){
        try{
         $cartitems =  Cart::where('user_id',Auth::id())->with(['product.firstImage'])->get();
            return view('cart',compact('cartitems'));
        }
        catch(\Exception $e){
            return abort(404);

        }
    }

   public function store(Request $request){
        try{
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1',
                'variation_values' => 'nullable|array',
                'variation_values.*' => 'exists:variation_values,id'

            ]);
        $Productcartquantity = getProductCartCount($request->product_id);
          $totalproductcartquantity =  $Productcartquantity + $request->quantity;

        $product =  Product::findOrFail($request->product_id);

        if($product->stock < $totalproductcartquantity){
            return response()->json([
                'success' => false,
                'msg' => 'Not enough stock available!'
               
            ]);

        }

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
                'cart_added' => false,
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
                'cart_added' => true,
                'msg' => 'Product added to cart',
                'data' => $cartItem
            ]);
        }
        catch(\Exception $e){
            return response()->json([
                'success' => false,
                'cart_added' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request){
        try{
            $request->validate([
                'id' => 'required|exists:carts,id',
                'quantity' => 'required|integer|min:1',
            ]);

            $cart = Cart::findOrFail($request->id);
         $product =  Product::findOrFail($cart->product_id);
        $Productcartquantity = getProductCartCountIgnore($cart->product_id, $cart->id);

          $userCartQuantity =  $Productcartquantity + $request->quantity;
            if($product->stock < $userCartQuantity){
                return response()->json([
                    'success' => false,
                    'msg' => 'Not Enough stock available'
               
                ]);
            }

            $cart->update([
                'quantity' => $request->quantity
            ]);

            $currency = '';
            if(getUserCurrency()){
                $currency = 'Rs';
                $cartTotal = $currency . ' '. number_format($product->pkr_price * $request->quantity,2);
            }else{
                $currency = '$';
                $cartTotal = $currency . ' '. number_format($product->usd_price * $request->quantity,2);
           
            }

            return response()->json([
                'success' => true,
                'msg' => 'Cart Update Successfully',
                'sub_total' =>  $currency.' '. getCartSubTotal(),
                'total' =>  $currency.' '. getCartTotal(),
                'cartTotal' =>  $cartTotal
           
            ]);

        }
        catch(\Exception $e){

            return response()->json([
                'success' => false,
                'msg' => $e->getMessage(),
           
            ]);
        }
    }

    public function destory(Request $request){
        try{
            $request->validate([
                'id' => 'required|exists:carts,id',
            ]);

            Cart::where('id',$request->id)->delete();
            $currency = '';
            if(getUserCurrency()){
                $currency = 'Rs';
            }else{
                $currency = '$';
           
            }
            return response()->json([
                'success' => true,
                'msg' => 'Cart Remove Successfully',
                'sub_total' =>  $currency.' '. getCartSubTotal(),
                'total' =>  $currency.' '.getCartTotal(),
                'count' => getCartCount()
           
            ]);

        }
        catch(\Exception $e){

            return response()->json([
                'success' => false,
                'msg' => $e->getMessage(),
           
            ]);
        }
    }
    public function applyCoupon(Request $request){
        try{
            $request->validate([
                'coupon_code' => 'required|exists:coupons,code',
            ]);

          $coupon =  Coupon::where('code',$request->coupon_code)->first();
            if(!$coupon || $coupon->expires_at < now() || ($coupon->user_limit && $coupon->used_count >= $coupon->user_limit)){
                return response()->json([
                    'success' => false,
                    'msg' => "Coupons is invalid or expired",
               
                ]);
            }

            session(['applied_coupon' => $coupon]);
            $currency = '';
            if(getUserCurrency()){
                $currency = 'Rs';
            }else{
                $currency = '$';
            }

            return response()->json([
                'success' => true,
                'msg' => 'Coupon Add Successfully',
                'code' => $coupon->code,
                'discount' => number_format($coupon->discount,2),
                'sub_total' =>  $currency.' '. getCartSubTotal(),
                'total' =>  $currency.' '.getCartTotal()
           
            ]);

        }
        catch(\Exception $e){

            return response()->json([
                'success' => false,
                'msg' => $e->getMessage(),
           
            ]);
        }
    }

    public function removeCoupon(Request $request){
        try{
          
            session()->forget('applied_coupon');
            $currency = '';
            if(getUserCurrency()){
                $currency = 'Rs';
            }else{
                $currency = '$';
            }

            return response()->json([
                'success' => true,
                'msg' => 'Remove Remove Successfully',
                'sub_total' =>  $currency.' '. getCartSubTotal(),
                'total' =>  $currency.' '.getCartTotal()
           
            ]);

        }
        catch(\Exception $e){

            return response()->json([
                'success' => false,
                'msg' => $e->getMessage(),
           
            ]);
        }
    }
}
