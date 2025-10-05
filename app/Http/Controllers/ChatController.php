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

      public function fetchMessages($userId){
        try{
           $authid = Auth::id();
          $message =  Message::where(function($q) use($userId,$authid){
                $q->where('from_id',$userId);
                $q->where('to_id',$authid);
            })->orWhere(function($q) use($userId,$authid){
                $q->where('from_id',$authid);
                $q->where('to_id',$userId);
            })
            ->with('sender')
            ->orderBy('created_at','asc')
            ->get();

            return response()->json(['success' =>  true, 'message' => 'Message ', 
            'data' => $message->load('sender') ]);
        }
        catch(\Exception $e){
           return response()->json(['success' => false, 'message' => 'Failed to send message.'], 500);
        }
    }
      public function markAsRead($userId){
        try{
           
          Message::where('from_id',$userId)
          ->where('to_id',Auth::id())
          ->where('is_read',0)
          ->update(['is_read' => 1]);

            return response()->json(['success' =>  true ]);
        }
        catch(\Exception $e){
           return response()->json(['success' => false, 'message' => 'Failed to send message.'], 500);
        }
    }
}
