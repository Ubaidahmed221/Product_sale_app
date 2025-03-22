<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingZone;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function index(){
        try{
    
    $zone = ShippingZone::with(['countryRelation','stateRelation'])->paginate(5);
            return view('admin.shipping-zone',compact('zone'));
        }catch(\Exception $e){
            return abort(404,"something went wrong");
        }
    }

    public function store(Request $request){
        try{
            $request->validate([
                'country' => 'required|string',
                'state' => 'nullable|string',
                'shipping_cost_pkr' => 'required|numeric',
                'shipping_cost_usd' => 'required|numeric'
            ]);

            ShippingZone::create([
                'country' => $request->country,
                'state' => $request->state,
                'shipping_cost_pkr' => $request->shipping_cost_pkr,
                'shipping_cost_usd' => $request->shipping_cost_usd,
            ]);
          

            return response()->json([
                'success' => true,
                'msg' => 'Shipping Zones created Successfully'
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
            $request->validate([
                'id' => 'required|exists:shipping_zones,id',
                'country' => 'required|string',
                'state' => 'nullable|string',
                'shipping_cost_pkr' => 'required|numeric',
                'shipping_cost_usd' => 'required|numeric'
            ]);

        $zone =   ShippingZone::findOrFail($request->id);

        $zone->update([
                'country' => $request->country,
                'state' => $request->state,
                'shipping_cost_pkr' => $request->shipping_cost_pkr,
                'shipping_cost_usd' => $request->shipping_cost_usd,
            ]);
          

            return response()->json([
                'success' => true,
                'msg' => 'Shipping Zones updated Successfully'
            ]);

        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }
    public function destory(Request $request){
        try{
            $request->validate([
                'id' => 'required|exists:shipping_zones,id',
            ]);

         ShippingZone::where('id',$request->id)->delete();

            return response()->json([
                'success' => true,
                'msg' => 'Shipping Zones Deleted Successfully'
            ]);

        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }
}
