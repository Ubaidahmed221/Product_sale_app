<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
// use Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;


class AuthController extends Controller
{
    public function registerView(){

        try{

            return view('auth.register');

        }
        catch(\Exception $e){
            return abort(404,"Something Went Wrong");

        }

    }
    public function register(RegisterRequest $request){
        try {

        $verificationToken = Str::random(60);

        $tokenExpiresAt = Carbon::now()->addHour();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'code' => $request->code,
                'phone_number' => $request->phone,
                'country' => $request->country,
                'state' => $request->state,
                'password' => Hash::make($request->password),
                'verification_token' => $verificationToken,
                'token_expires_at' => $tokenExpiresAt,

            ]);
            $this->sendVerificationEmail($user);

            return back()->with('success', 'Your Registration has been Successfully, please check your email to verify you account!');
        }

        catch(\Exception $e){
            return back()->with('error',$e->getMessage());

        }

    }

    protected function sendVerificationEmail($user){
        $verificationUrl = url('/verify/' . $user->verification_token);
        Mail::send('mails.verificationMail',['name' => $user->name, 'url' => $verificationUrl ], function($message) use ($user){
            $message->to($user->email);
            $message->subject('Email Verification');
        });
    }

    public function loginView(){
        try{

            return view('auth.login');
        }
        catch(\Exception $e){
            return abort(404,"Something Went Wrong");
        }
    }
    public function login(LoginRequest $request){
        try {
          $usercrediential =  $request->only('email','password');
          if(Auth::attempt($usercrediential)){
            if(Auth::user()->is_verified == 0){
                Auth::logout();
                return back()->with('error','please verify you account');
            }
            if(Auth::user()->is_admin == 1){
                return redirect()->route('admin.dashboard');
            }else{
                return redirect()->route('user.dashboard');
            }

          }else{
            return back()->with('error','Username & password increect');
          }
          }

        catch(\Exception $e){
            return back()->with('error',$e->getMessage());

        }

    }

    public function forgetpasswordView(){
        try{

            return view('auth.forget-password');
        }
        catch(\Exception $e){
            return abort(404,"Something Went Wrong");
        }
    }

    public function forgetPasssword(Request $request){
        try{

         $user =   User::where('email',$request->email)->first();
         if(!$user){
            return back()->with('error','Email is not exist!');

         }

       $token =  Str::random(40);
       $url = url('/reset-password/'.$token);

       PasswordReset::updateOrInsert(
        [
            'email' => $user->email
        ],
        [
            'email' => $user->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]
        );

       Mail::send('mails.forget-password',['url' => $url] , function($message) use ($user){
        $message->to($user->email)->subject('Reset Password');

    });
    return back()->with('success','please check your email to reset Password!');


        }
        catch(\Exception $e){
            return back()->with('error',$e->getMessage());

        }

    }
    public function resetpasswordView($token){
        try{
          $resetdata =  PasswordReset::where('token',$token)->first();
          if(!$resetdata){
            return abort(404,'Something Went wrong');

          }
       $user =  User::where('email', $resetdata->email)->first();
            return view('auth.reset-password',compact('user'));
        }
        catch(\Exception $e){
            return abort(404,"Something Went Wrong");
        }
    }

    public function resetPasssword(ResetPasswordRequest $request){
        try{
            $user = User::find($request->id);
            $user->password = Hash::make($request->password);
            $user->save();

            PasswordReset::where('email',$user->email)->delete();
            return redirect()->route('PassswordUpdated');

        }
        catch(\Exception $e){
            return abort(404,"Something Went Wrong");
        }
    }

    public function PassswordUpdated(){
        try{

            return view('auth.password-updated');
        }
        catch(\Exception $e){
            return abort(404,"Something Went Wrong");
        }
    }

    public function mailverificationView(){
        try{

            return view('auth.mail-verification');
        }
        catch(\Exception $e){
            return abort(404,"Something Went Wrong");
        }
    }

    public function mailVerification(Request $request){
        try{
        $userExist =  User::where('email',$request->email)->first();

            if(!$userExist){
                return back()->with('error',"Email is not exit");
            }
            $user = User::find($userExist->id);
            $user->verification_token = Str::random(60);
            $user->token_expires_at = Carbon::now()->addHour();
            $user->save();
        $this->sendVerificationEmail($user);
        return back()->with('success',"Verification mail has been sent to your email!");


        }
        catch(\Exception $e){
            return back()->with('error',$e->getMessage());

        }
    }
    public function logout(Request $request){
        try{

            auth()->logout();
            $request->session()->invalidate(); 
            $request->session()->regenerateToken();

            return response()->json([
                'success' => true,
                'message' => 'logout successfully'
            ]);
        }
        catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);

        }
    }

    public function CurrencyUpdate(Request $request){
        try{
            $request->validate([
                'currency' => 'required|string'
            ]);
        $user =  User::findOrFail(Auth::user()->id);
        $user->currency = $request->currency;
        $user->save();
            return response()->json([
                'success' => true,
                'message' => 'Currency Update SUccessfully'
            ]);
        }
        catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);

        }
    }

}
