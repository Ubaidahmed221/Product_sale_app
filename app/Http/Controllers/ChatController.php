<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
     public function index(){
        try{
         $admin =   User::where('is_admin',1)->firstOrFail();
           return view('dashboard.chat.index',compact('admin'));
        }
        catch(\Exception $e){
           return abort(404,'something went wrong!');
        }
    }
     public function sendMessage(Request $request){
        try{
            $request->validate([
                'to_id' => 'required|exists:users,id',
               
                'message' => 'required|string|max:5000',
            ]);

        $message =   Message::create([
                'to_id' => (int)$request->to_id,
                'from_id' => Auth::id(),
                'message' => $request->message,
            ]);

            return response()->json(['success' =>  true, 'message' => 'Message sent successfully.', 
            'data' => $message->load('sender:id') ]);
        }
        catch(\Exception $e){
           return response()->json(['success' => false, 'message' => 'Failed to send message.'], 500);
        }
    }
}
