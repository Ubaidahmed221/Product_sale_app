<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Mail;
use Illuminate\Support\Facades\Crypt;


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
            $token = Crypt::encrypt($request->email);
            $url = url('/unsubscribe/'.$token);
            Mail::send("mails.subcribe",["name"=>$request->name,"email"=>$request->email,"url" => $url ], function($message) use($request){
                $message->to($request->email);
                $message->subject('Subscribe');

            });
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
    public function unsubscribe($token){

        try{
           $email =  Crypt::decrypt($token);
         $isexist =  Subscriber::where("email",$email)->first();
         if(!$isexist){
            abort(404,"Something went wrong");
         }
         Subscriber::where("email",$email)->delete();
         return redirect()->route('loginView')->with('success','unsubscribe Successfully');


        }
        catch(\Exception $e){
            abort(404,"Something went wrong");
        }
    }
}
