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
            'pkr_total_commission' => $user->affiliateComissions()->where('status','!=','rejected')->where('currency','pkr')->sum('commission_amount'),
            'usd_total_commission' => $user->affiliateComissions()->where('status','!=','rejected')->where('currency','usd')->sum('commission_amount'),
            'pkr_pending_commission' => $user->affiliateComissions()->where('status','pending')->where('currency','pkr')->sum('commission_amount'),
            'usd_pending_commission' => $user->affiliateComissions()->where('status','pending')->where('currency','usd')->sum('commission_amount'),
            'pkr_approved_commission' => $user->affiliateComissions()->where('status','approved')->where('currency','pkr')->sum('commission_amount'),
            'usd_approved_commission' => $user->affiliateComissions()->where('status','approved')->where('currency','usd')->sum('commission_amount'),
            'pkr_paid_commission' => $user->affiliateComissions()->where('status','paid')->where('currency','pkr')->sum('commission_amount'),
            'usd_paid_commission' => $user->affiliateComissions()->where('status','paid')->where('currency','usd')->sum('commission_amount'),
        ];
               return view('admin.affiliate.affiliate-user',compact('commission','stats','user'));
           }catch(\Exception $e){
               return abort(404,"something went wrong");
           }
    }

     public function approve(AffiliateCommission $commission){
        try{
            if($commission->status != 'pending'){
                return back()->with('error','Only pending commissions can be approved');
            }
            $commission->status = 'approved';
            $commission->save();
                return back()->with('success','Commission approved successfully');
       
           }catch(\Exception $e){
               return back()->with('error',$e->getMessage());
           }
    }
     public function reject(AffiliateCommission $commission){
        try{
            if(!in_array($commission->status, ['pending','approved'])){
                return back()->with('error','Only pending or approved commissions can be rejected');
            }
            $commission->status = 'rejected';
            $commission->save();
                return back()->with('success','Commission rejected successfully');
       
           }catch(\Exception $e){
               return back()->with('error',$e->getMessage());
           }
    }
     public function markPaid(AffiliateCommission $commission){
        try{
            if($commission->status != 'approved'){
                return back()->with('error','only approved commissions can be marked as paid');
            }

            // add commission into wallet
            $user = $commission->affiliate;
            if(strtolower($commission->currency) == 'pkr'){
                // credit to usd wallet
                $user->wallet_balance = $user->wallet_balance + $commission->commission_amount;
            }
            else{
                $user->wallet_balance_usd = $user->wallet_balance_usd + $commission->commission_amount;
            }
            // $user->wallet_balance += $commission->commission_amount;
            $user->save();

            $commission->status = 'paid';
            $commission->save();
                return back()->with('success','Commission paid successfully');
       
           }catch(\Exception $e){
               return back()->with('error',$e->getMessage());
           }
    }

     public function users(){
        try{
          $users =  User::whereNotNull('referral_code')
            ->whereHas('affiliateComissions')
            ->select('users.*')
            ->selectSub(function ($query) {
                $query->from('affiliate_commissions')
                      ->selectRaw('COALESCE(SUM(commission_amount),0)')
                      ->whereColumn('affiliate_commissions.affiliate_user_id', 'users.id')
                      ->where(function($q){
                          $q->where('currency','pkr')
                          ->orwhereNull('currency');
                      });
            }, 'total_earned_pkr')

            ->selectSub(function ($query) {
                $query->from('affiliate_commissions')
                      ->selectRaw('COALESCE(SUM(commission_amount),0)')
                      ->whereColumn('affiliate_commissions.affiliate_user_id', 'users.id')
                      ->where(function($q){
                          $q->where('currency','usd')
                          ->orwhereNull('currency');
                      });
            }, 'total_earned_usd')
            ->latest()->paginate(15);
       
               return view('admin.affiliate.user',compact('users'));
           }catch(\Exception $e){
               return abort(404,"something went wrong");
           }
    }
}
