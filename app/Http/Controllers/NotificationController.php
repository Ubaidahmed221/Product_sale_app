<?php

namespace App\Http\Controllers;

use App\Models\UserDevice;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    
    public function saveFcmToken(Request $request)
    {
       try{
        $request->validate([
            'fcm_token' => 'required|string',
        ]);

        UserDevice::updateOrCreate(
            [
                'fcm_token' => $request->fcm_token,
             
            ],
            [
                   'user_id' => auth()->id()
            ]
        );

          return response()->json([
            'success'=> true,'message'=>"FCM Token saved successfully"]);
     
       }
       catch(\Exception $e){
        return response()->json([
            'success'=> false,'message'=>"Something went wrong"]);
       }

    }
}
