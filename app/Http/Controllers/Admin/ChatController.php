<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
     public function index(Request $request)
    {
         try {
            return view('admin.chat.index');
        } catch (\Exception $e) {
            return abort(404, "something went wrong");
        }
    }
     public function userwithMessages(Request $request){
        try{
           $adminId = auth()->id();
           $users = User::where('is_admin', 0)
            ->whereHas('sendMessage', function ($q) use ($adminId) {
                $q->where('to_id', $adminId);
            })
              ->OrwhereHas('receivedMessage', function ($q) use ($adminId) {
                $q->where('from_id', $adminId);
            })
            ->with(['sendMessage' => function ($q) use ($adminId) {
                $q->where('to_id', $adminId)->latest()->limit(1);
            },
            'receivedMessage' => function ($q) use ($adminId) {
                $q->where('from_id', $adminId)->latest()->limit(1);
            }
            ])
            ->get()
            ->map(function($user) use($adminId){
                $lastSent = $user->sendMessage->first();
                $lastReceived = $user->receivedMessage->first();
                $lastMessage = null;
                if($lastSent && $lastReceived){
                    $lastMessage = $lastSent->created_at > $lastReceived->created_at ? $lastSent : $lastReceived;
                }
                elseif($lastSent){
                    $lastMessage = $lastSent;
                }
                elseif($lastReceived){
                    $lastMessage = $lastReceived;
                }
                $user->last_message = $lastMessage ? [
                    'text' => $lastMessage->message,
                    'time' => $lastMessage->created_at->diffForHumans(),
                ] : null; 
                return $user;
            });
            return response()->json(
                ['success' =>  true,
                 'message' => 'Conversation.', 
            'data' => $users ]);
        }
        catch(\Exception $e){
           return response()->json(['success' => false, 'message' => 'Failed to send message.'], 500);
        }
    }
}
