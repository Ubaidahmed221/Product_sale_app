<?php

use App\Models\AppData;

function getAppData($select){

    $sendData = '';
   $exits = AppData::select($select)->first();
   if($exits){
    $sendData = $exits->$select;

   }

   return  $sendData;


}

?>
