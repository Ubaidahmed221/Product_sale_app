<?php

use App\Models\AppData;
use App\Models\Menu;
use App\Models\category;
use App\Models\Banner;
use App\Models\Variation;
use App\Models\Offer;

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
?>
