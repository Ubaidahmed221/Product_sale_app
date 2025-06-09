<?php

use App\Models\AppData;
use App\Models\Menu;
use App\Models\category;
use App\Models\Banner;
use App\Models\Cart;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\Variation;
use App\Models\Offer;
use App\Models\PaymentGateway;
use App\Models\PriceFilter;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\ShippingZone;
use App\Models\Wishlist;

function getAppData($select){

    $sendData = '';
   $exits = AppData::select($select)->first();
   if($exits){
    $sendData = $exits->$select;

   }

   return  $sendData;


}

 function getMenu($position){
    try{
     $menus =  Menu::where('position',$position)->whereNull('parent_id')->orderBy('id')->get();
        return $menus;
    }catch(\Exception $e){
        return [];

    }

 }

 function getAllCategory(){
    try{
      $getAllCategory =  category::whereNull('parent_id')->with('children')->get();
        return  $getAllCategory;
    }
    catch(\Exception $e){
        return [];

    }
 }
 function getVariations(){
    try{
      $variations =  Variation::with('values')->get();
        return  $variations;
    }
    catch(\Exception $e){
        return [];

    }
 }
 function getbanners(){
    try{
      $getbanner =  Banner::where('status',1)->get();
        return  $getbanner;
    }
    catch(\Exception $e){
        return [];

    }
 }
 function getCategoryWithProductCount(){
    try{
      $categories =  category::withCount('products')
      ->inRandomOrder()
      ->take(6)
      ->get();
        return  $categories;
    }
    catch(\Exception $e){
        return [];

    }
 }
 function getOffers(){
  try{
    $offer =  Offer::orderBy('id','DESC')
    ->get();
      return  $offer;
  }
  catch(\Exception $e){
      return [];

  }
}
function getJustArrivedProducts(){
    try{
     $product = Product::latest()
     ->whereNull('deleted_at')
     ->take(8)
     ->with('firstImage')
      ->get();
        return  $product;
    }
    catch(\Exception $e){
        return [];

    }
  }

  function getCartCount(){
    try{

      if(auth()->check()){
      return  Cart::where('user_id',auth()->id())->count();
      }
      else{
        return 0;
      }

    }
    catch(\Exception $e){
        return 0;

    }
  }
  function getWishlistCount(){
    try{

      if(auth()->check()){
      return  Wishlist::where('user_id',auth()->id())->count();
      }
      else{
        return 0;
      }
    }
    catch(\Exception $e){
        return 0;

    }
  }
  function getProductCartCount($productId){
    try{

     
      return  Cart::where([
          'product_id' => $productId
      ])->sum('quantity');
      

    }
    catch(\Exception $e){
        return 0;

    }
  }

  function getProductCartCountIgnore($productId, $cartId){
    try{

     
      return  Cart::where([
          'product_id' => $productId
      ])
      ->where('id','!=',$cartId)
      ->sum('quantity');
      

    }
    catch(\Exception $e){
        return 0;

    }
  }
  function getCartTotal(){
    try{
     
      return number_format(getCartSubTotal() + shippingAmount(),2);

    }
    catch(\Exception $e){
        return 0;

    }
  }

  function getCartSubTotal(){
    try{
      $cartTotal = 0;
      $cartItem = Cart::where('user_id',auth()->user()->id)
      ->with('product')->get();
      if(getUserCurrency()){
        $cartTotal =  $cartItem->sum(fn($item) => $item->product->pkr_price * $item->quantity);

      }else{

        $cartTotal =  $cartItem->sum(fn($item) => $item->product->usd_price * $item->quantity);
      }
      $coupon = session('applied_coupon');
      if($coupon){
        $validcoupon =  Coupon::where('code',$coupon['code'])->first();

        if(!$validcoupon || $validcoupon->expires_at < now() || ($validcoupon->user_limit && $validcoupon->used_count >= $validcoupon->user_limit)){
         session()->forget('applied_coupon');
      }
      else{
        $cartSubTotal = $cartTotal;
       $discountAmount = ($cartSubTotal *  $validcoupon->discount) / 100;
       $cartTotal = max($cartSubTotal - $discountAmount,0);
      }
      }
      return number_format($cartTotal,2);

    }
    catch(\Exception $e){
        return 0;

    }
  }

  function countries(){
    try{

    return  Country::all();

    }
    catch(\Exception $e){
        return [];

    }
  }
  function getUserCurrency(){
    try{

      $ispkr = 1;
      if(auth()->check() && auth()->user()->currency != 'pkr'){
        $ispkr = 0;

      }
      return $ispkr;

    }
    catch(\Exception $e){
        return null;

    }
  }
  function shippingAmount(){
    try{
      $shippingCost = 0;

   $shippingZone =   ShippingZone::where('country',auth()->user()->country)
      ->where(function($query) {
        if(!empty(auth()->user()->state)){
          $query->where('state',auth()->user()->state);
        }else{
          $query->whereNull('state');
        }
      })
      ->first();

      if($shippingZone){
        $shippingCost = getUserCurrency() ? $shippingZone->shipping_cost_pkr : $shippingZone->shipping_cost_usd; 
      }
      return number_format($shippingCost,2);

    }
    catch(\Exception $e){
        return 0;

    }
  }

  function getPriceFilter(){
    try{

    $priceColumn =  getUserCurrency() ? 'pkr_price' :  'usd_price';

   $pricefilter = PriceFilter::orderBy('min_price','ASC')->get();
   foreach($pricefilter as $filter){
    $filter->product_count = Product::whereBetween($priceColumn,[$filter->min_price,$filter->max_price])
    ->whereNull('deleted_at')
    ->where('stock','>',0)
    ->count();

   }
   return $pricefilter;
    }
    catch(\Exception $e){
      return [];

    }
  }
  function totalProductCount(){
    try{

    $productCount = Product::whereNull('deleted_at')
    ->where('stock','>',0)
    ->count();

   return $productCount;
    }
    catch(\Exception $e){
      return 0;

    }
  }
  function getVariationFilter(){
    try{
   $variation =  Variation::with([
        'values' => function($query){
          $query->withCount([
            'productVariation as product_count' => function($query){
              $query->join('products','products_variations.product_id','=','products.id')
              ->whereNull('products.deleted_at')
              ->where('products.stock','>',0);
            }
          ]);
        }
        ])->get();
   return $variation;
    }
    catch(\Exception $e){
      return [];

    }
  }
  function getVariationProductCount($variationId){
    try{
     
      try {
        $productCount = ProductVariation::with('product')
            ->where('variation_id', $variationId)
            ->whereHas('products', function ($query) {
                $query->whereNull('deleted_at') // Agar soft delete enabled hai
                      ->where('stock', '>', 0); // Sirf available stock wale products
            })
            ->distinct('product_id')
            ->count('product_id');

        return $productCount;
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }

   return $productCount;
    }
    catch(\Exception $e){
      return 0;

    }
  }

  function getTrandyProducts(){
      try {
      
        return Product::trandy()->take(8)->with('firstImage')->get();
    } 

    catch(\Exception $e){
      return [];

    }
  }

  function getPaymentGateways(){
    try {
    
      return PaymentGateway::where('is_enabled',1)->get();
  } 

  catch(\Exception $e){
    return [];

  }
}
?>
