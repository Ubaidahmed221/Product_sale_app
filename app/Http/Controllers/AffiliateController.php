<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AffiliateController extends Controller
{
    public function index(){
        // dd('hello');
        try {
           $user = Auth::user();
        //    dd($user);
         $commissions =  $user->affiliateComissions()->latest()->paginate(10);
            $referrals = $user->referrals()->count();
            // dd($commissions,$referrals);
            return view('affiliate.index',compact('commissions','referrals','user'));
           }   catch(\Exception $e){
           return abort(404,'something went wrong!');
        }
    }
}
