<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;

class ReviewController extends Controller
{
    public function store(Request $request){
        try{

            $request->validate([
                'product_id' => 'required|exists:products,id',
                'rating' => 'nullable|integer|min:1|max:5',
                'review' => 'required|string|max:1000'
            ]);
            if(!Auth::check()){
                return response()->json([
                    'success' => false,
                    'message' => 'please Login'
                ]);

            }

            $review = Review::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'rating' => $request->rating?$request->rating : 0,
                'review' => $request->review
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Review Submited Sussessfully'
            ]);
        }
        catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
