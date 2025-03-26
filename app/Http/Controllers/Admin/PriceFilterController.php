<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PriceFilter;
use Illuminate\Http\Request;

class PriceFilterController extends Controller
{
    public function index()
    {
        try {

            $PriceFilter = PriceFilter::paginate(5);
            return view('admin.price-filter', compact('PriceFilter'));
        } catch (\Exception $e) {
            return abort(404, "something went wrong");
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData =  $request->validate([  
                'min_price' => 'required|numeric|min:0',
                'max_price' => 'required|numeric|min:0'
             
            ]);
            PriceFilter::create($validatedData);

            return response()->json([
                'success' => true,
                'msg' => 'Price Filter Created Successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request)
    {
        try {
            $validatedData =  $request->validate([
                'id' => 'required|exists:price_filters,id',
                  'min_price' => 'required|numeric|min:0',
                'max_price' => 'required|numeric|min:0'
             
            ]);
            $coupon =  PriceFilter::findOrFail($request->id);
            unset($validatedData['id']);
            $coupon->update($validatedData);

            return response()->json([
                'success' => true,
                'msg' => 'Price Filter Updated Successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }

    public function destroy(Request $request)
    {
        try {

            $validatedData =  $request->validate([
                'id' => 'required|exists:price_filters,id',

            ]);
            PriceFilter::where('id', $request->id)->delete();

            return response()->json([
                'success' => true,
                'msg' => 'Price Filter Deleted Successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }
}
