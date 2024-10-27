<?php

use App\Models\AppData;
use App\Models\Menu;
use App\Models\category;


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
    }catch(\Exceptio $e){
        return [];

    }

 }

 function getAllCategory(){
    try{
      $getAllCategory =  category::whereNull('parent_id')->with('children')->get();
        return  $getAllCategory;
    }
    catch(\Exceptio $e){
        return [];

    }
 }

?>
