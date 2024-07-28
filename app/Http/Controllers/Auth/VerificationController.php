<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;

class VerificationController extends Controller
{
    public function verify($token){

        $user = User::where('verification_token', $token)->first();
        // dd($user);
       \Log::info('User table data: ' . $user);
       if(!$user){
        return abort(404,"Something Went Wrong!");
       }
       if($user->token_expires_at < Carbon::now()){
        $msg = "Verification token has expired, please request a new verification email!";
        return view('auth.verification_message',compact('msg'));

       }
       $user->is_verified = 1;
       $user->email_verified_at = Carbon::now();
       $user->verification_token = null;
       $user->token_expires_at = null;
       $user->save();

       $msg = "Email Verify Successfully";
       return view('auth.verification_message',compact('msg'));



    }
}
