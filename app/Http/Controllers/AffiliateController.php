<?php

namespace App\Http\Controllers;

use App\Models\AffiliateCommission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AffiliateController extends Controller
{
    public function index(){
    //    dd('hello affiliate');
        try {
           $user = Auth::user();
        // dd($user);
            $totalSignup = $user->referrals()->count();
            $totalClicks = $user->affiliateClicks()->count();
        // dd($totalClicks,$totalSignup);
           $totalOrders = AffiliateCommission::where('affiliate_user_id', $user->id)
            ->distinct()
            ->count('order_id');
        // dd($totalOrders);
           $totalapprovedPKRCommission = $user->affiliateComissions()
            ->where(['status' => 'approved', 'currency' => 'pkr'])
            ->sum('commission_amount');

             $totalapprovedUSDCommission = $user->affiliateComissions()
            ->where(['status' => 'approved', 'currency' => 'usd'])
            ->sum('commission_amount');

             $totalpeddingPKRCommission = $user->affiliateComissions()
            ->where(['status' => 'pending', 'currency' => 'pkr'])
            ->sum('commission_amount');

             $totalpeddingUSDCommission = $user->affiliateComissions()
            ->where(['status' => 'pending', 'currency' => 'usd'])
            ->sum('commission_amount');

             $totalpaidPKRCommission = $user->affiliateComissions()
            ->where(['status' => 'paid', 'currency' => 'pkr'])
            ->sum('commission_amount');

             $totalpaidUSDCommission = $user->affiliateComissions()
            ->where(['status' => 'paid', 'currency' => 'usd'])
            ->sum('commission_amount');

          

            return view('affiliate.dashboard',compact(
                'totalSignup',
                'totalClicks',
                'totalOrders',
                'totalapprovedPKRCommission',
                'totalapprovedUSDCommission',
                'totalpeddingPKRCommission',
                'totalpeddingUSDCommission',
                'totalpaidPKRCommission',
                'totalpaidUSDCommission',
            ));
           }   catch(\Exception $e){
           return abort(404,'something went wrong!');
        }
    }
}
