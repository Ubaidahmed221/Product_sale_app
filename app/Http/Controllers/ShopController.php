<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(){
        try {
            return view('shop');
        } catch (\Exception $e) {
            return abort(404, "something went wrong");
        }
    }

    public function filterProduct(Request $request){
        try {
            
           $products = Product::query()
            ->whereNull('deleted_at')
            ->where('stock' ,'>',0);

          $columnName =  getUserCurrency() ? 'pkr_price' : 'usd_price';
          if($request->has("price")  && count($request->price) > 0){
           $priceRange = $request->price;
           $products->where(function($query) use( $priceRange, $columnName){
            foreach($priceRange as $range){
                [$min,$max] = explode('-',$range);
                $query->orwhereBetween($columnName,[(float)$min, (float)$max]);
            }
           });
          }

           $products = $products->paginate(9);

           return response()->json([
            'success' => true,
            'message' => "Products",
            "html" => view("partials.product-list", compact("products"))->render()
           ]);


        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
