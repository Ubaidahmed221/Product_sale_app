<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Variation;
use App\Models\VariationValue;
use Illuminate\Validation\Rule;

class VariationController extends Controller
{
    public function index(){
        try{
          $variation = Variation::with('values')->paginate(5);
            return view('admin.variation',compact('variation'));
        }
        catch(\Exception $e){
            return abort(404,"Something Went Wrong");

        }
    }
    public function store(Request $request){
        try{
            $request->validate([
                'name' => 'required|unique:variations,name',

            ]);

            Variation::create([
            'name' => $request->name
         ]);

            return response()->json([
                'success' => true,
                'msg' => 'variation created Successfully'
            ]);

        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }
    public function variationValuestore(Request $request){
        try{
            $request->validate([
                'variation_id' => 'required',
                'value' => 'required',

            ]);

          $isexist =   VariationValue::where('variation_id',$request->variation_id)
            ->whereRaw('LOWER(value) = ?',[strtolower($request->value)])
            ->first();

            if($isexist){
                return response()->json([
                    'success' => false,
                    'msg' => $request->value.'variation value already created!'
                ]);

            }
            VariationValue::create([
                'variation_id' => $request->variation_id,
                'value' => $request->value
            ]);

            return response()->json([
                'success' => true,
                'msg' => 'variation value created Successfully'
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
                'id' => 'required',
                'name' =>[
                    'required',
                    Rule::unique('variations')->ignore($request->id)
                ]

            ]);

            Variation::where('id',$request->id)->update([
                'name' => $request->name

            ]);

            return response()->json([
                'success' => true,
                'msg' => 'Variation Update   Successfully'
            ]);

        }
        catch(\Exception $e){
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }
    public function destory(Request $request){
        try{
            Variation::where('id',$request->id)->delete();

            return response()->json([
                'success' => true,
                'msg' => 'variation Delete Successfully'
            ]);

        }
        catch(\Exception $e){
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }
    public function variationValuedestory(Request $request){
        try{
            $request->validate([
                'id' => 'required'

            ]);
            VariationValue::where('id',$request->id)->delete();

            return response()->json([
                'success' => true,
                'msg' => 'variation value Delete Successfully'
            ]);

        }
        catch(\Exception $e){
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }
}
