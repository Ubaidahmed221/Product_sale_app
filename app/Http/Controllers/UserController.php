<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function account(){
        try{
           return view('dashboard.account.index');
        }
        catch(\Exception $e){
           return abort(404,'something went wrong!');
        }
    }
    public function orders(){
        try{
           return view('dashboard.orders.index');
        }
        catch(\Exception $e){
           return abort(404,'something went wrong!');
        }
    }
    public function address(){
        try{
           return view('dashboard.address.index');
        }
        catch(\Exception $e){
           return abort(404,'something went wrong!');
        }
    }
    public function changePassword(){
        try{
           return view('dashboard.change-password.index');
        }
        catch(\Exception $e){
           return abort(404,'something went wrong!');
        }
    }

    public function accountUpdate(Request $request){
        try{
            $user = User::findOrFail(auth()->user()->id);
            $user->name = $request->name;
            $user->gender = $request->gender;
            $user->save();
            return back()->with(['success' => 'Updated Successfully']);

        }
        catch(\Exception $e){
            return back()->with(['error' => $e->getMessage()]);
         }
    }
}
