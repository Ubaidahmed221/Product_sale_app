<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function store(Request $request){
        try{
            $request->validate([
                'name' => 'nullable',
                'email' => 'required|email|unique:subscribers,email'
            ],[
                "email.unique" => "The email address you entered is already subscribed. "
            ]);
            Subscriber::create([
                "name" => $request->name,
                "email" => $request->email
            ]);
            return response()->json([
                'message'=> 'Thank you For Subscribing',
                'success' => true
            ]);
        }
        catch(\Exception $e){
            return response()->json([
                'message'=>$e->getMessage(),
                'success' => false
            ]);
        }
        
    }
}
