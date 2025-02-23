<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ProductController extends Controller
{
    public function detail($encryptedstring){
        try{
            $id = Crypt::decrypt($encryptedstring);
          $product =  Product::withCount('review')
          ->withAvg('review','rating')
          ->with(['images',
          'productVariations.variation',
          'productVariations.variationValue'])
          ->where('id',$id)->first();

          $variations = [];
          foreach($product->productVariations as $productVaration)
          {
            $variationName = $productVaration->variation->name; // color,size etc..
            $variationValue = $productVaration->variationValue->value; // yellow,red,XL,S etc..

            $variations[$variationName][] = $variationValue;
          }

          return view('product.detail',compact(['product','variations']));

        }
        catch(\Exception $e)
        {
            return abort(404);

        }
    }
}
