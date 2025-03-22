<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index(){
        try{
    
    $coupon = Coupon::paginate(5);
            return view('admin.coupon',compact('coupon'));
        }catch(\Exception $e){
            return abort(404,"something went wrong");
        }
    }

    public function store(Request $request){
        try{
          $validatedData =  $request->validate([
                'code' => 'required|string|unique:coupons,code|max:20',
                'discount' => 'required|numeric|min:1|max:100',
                'user_limit' => 'nullable|integer|min:1',
                'expires_at' => 'nullable|date|after_or_equal:today'
            ]);
            Coupon::create($validatedData);

            return response()->json([
                'success' => true,
                'msg' => 'Coupon Created Successfully'
            ]);

        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request){
        try{
          $validatedData =  $request->validate([
                'id' => 'required|exists:coupons,id',
                'code' => 'required|string|max:20|unique:coupons,code,'. $request->id,
                'discount' => 'required|numeric|min:1|max:100',
                'user_limit' => 'nullable|integer|min:1',
                'expires_at' => 'nullable|date|after_or_equal:today'
            ]);
          $coupon =  Coupon::findOrFail($request->id);
            unset($validatedData['id']);
          $coupon->update($validatedData);

            return response()->json([
                'success' => true,
                'msg' => 'Coupon Updated Successfully'
            ]);

        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }

    public function destroy(Request $request){
        try{

          $validatedData =  $request->validate([
                'id' => 'required|exists:coupons,id',
              
            ]);
           Coupon::where('id', $request->id)->delete();

            return response()->json([
                'success' => true,
                'msg' => 'Coupon Deleted Successfully'
            ]);

        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }
}
