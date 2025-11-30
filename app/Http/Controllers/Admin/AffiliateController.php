<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AffiliateCommission;
use App\Models\User;
use Illuminate\Http\Request;

class AffiliateController extends Controller
{
     public function index(){
        try{
        $commission =  AffiliateCommission::with('affiliate','order')->latest()->paginate(15);
               return view('admin.affiliate.commissions',compact('commission'));
           }catch(\Exception $e){
               return abort(404,"something went wrong");
           }
    }
     public function commissions($id){
        try{
        $user =    User::findOrFail($id);
        $commission = $user->affiliateComissions()->orderBy('id','desc')->paginate(15);

        $stats = [
            'total_commission' => $user->affiliateComissions()->where('status','!=','rejected')->sum('commission_amount'),
            'pending_commission' => $user->affiliateComissions()->where('status','pending')->sum('commission_amount'),
            'approved_commission' => $user->affiliateComissions()->where('status','approved')->sum('commission_amount'),
            'paid_commission' => $user->affiliateComissions()->where('status','paid')->sum('commission_amount'),
        ];
               return view('admin.affiliate.affiliate-user',compact('commission','stats','user'));
           }catch(\Exception $e){
               return abort(404,"something went wrong");
           }
    }
}
