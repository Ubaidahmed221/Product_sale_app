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

          if($request->has("search") && !empty($request->search) ){
            $products->where("title","LIKE", "%".$request->search."%");
          }

          if($request->has("price")  && count($request->price) > 0){
           $priceRange = $request->price;
           $products->where(function($query) use( $priceRange, $columnName){
            foreach($priceRange as $range){
                [$min,$max] = explode('-',$range);
                $query->orwhereBetween($columnName,[(float)$min, (float)$max]);
            }
           });
          }
          if($request->has("variations") && count($request->variations) > 0 ){
            $variationFilter = $request->variations;
            $products->whereHas("productVariations",function($query) use ($variationFilter){
                $query->whereHas("variationValue", function($q) use ($variationFilter){
                        $q->whereIn('value',$variationFilter);
                });
            });
          }

          if($request->has("sort") ){
            switch($request->sort){
                case 'latest';
                $products->orderBy("created_at","desc");
                break;
                case 'oldest';
                $products->orderBy("created_at","asc");
                break;
                case 'popularity';
                $products->withCount('review')->orderBy("review_count", "desc");
                break;
                case 'rating';
                $products->withAvg('review','rating')->orderBy("review_avg_rating","desc");
                break;

            }

          }

           $products = $products->paginate(5);

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
