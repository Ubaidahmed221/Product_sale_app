<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AffiliateSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(Request $request){
        
      try {
       $affiliate = AffiliateSetting::first();
          return view('admin.setting.index', compact('affiliate'));
      } catch (\Exception $e) {
          return abort(404, 'Something went wrong');
      }
      
    }

    public function affiliateUpdate(Request $request){
        
        try {
          $validatedata =  $request->validate([
                'commission_percentage' => 'required|numeric|min:0',
                'min_payout' => 'required|numeric|min:1',
                'auto_credit_wallet' => 'boolean',
            ]);
            $validatedata['auto_credit_wallet'] = $request->has('auto_credit_wallet') ? 1 : 0;

            AffiliateSetting::updateOrCreate(
                ['id' => 1], 
                $validatedata
            );
            return redirect()->back()->with('success', 'Affiliate settings updated successfully.');

            return redirect()->back()->with('success', 'Affiliate settings updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error',$e->getMessage());
        }
    }
}
