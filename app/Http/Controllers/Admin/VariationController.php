<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Variation;

class VariationController extends Controller
{
    public function index(){
        try{
          $variation = Variation::paginate(5);
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
    public function update(Request $request){
        try{

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
}
