<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'code' => $request->code,
                'phone_number' => $request->phone,
                'password' => Hash::make($request->password),
            ]);

            return back()->with('success', 'Your Registration has been Successfully!');
        }

        catch(\Exception $e){
            return back()->with('error',$e->getMessage());

        }

    }
}
