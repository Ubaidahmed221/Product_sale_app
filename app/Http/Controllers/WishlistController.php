<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class WishlistController extends Controller
{
    public function index(){
        try{
           $wishlist = Wishlist::where('user_id',Auth::id())->with(['product.firstImage'])->get();
            return view('wishlist',compact('wishlist'));
        }
        catch(\Exception $e){
           return abort(404,'something went wrong!');
        }
    }
    public function toggle(Request $request){
        try{
            $productId = $request->product_id;
            $user = Auth::user();

            if(!$user){
                return response()->json([
                    'success' => true,
                    'message' => 'Login required.'
                ]);  
            }
           $wishlist = Wishlist::where('user_id',$user->id)
            ->where('product_id',$productId)
            ->first();

            if($wishlist){
                $wishlist->delete();
                return response()->json([
                    'success' => true,
                    'status' => 0,
                    'message' => 'Remove from Wishlist Successfully'
                ]); 
            }else{
                Wishlist::create([
                    'user_id' => $user->id,
                    'product_id' => $productId
                ]);
                return response()->json([
                    'success' => true,
                    'status' => 1,
                    'message' => 'Added In  Wishlist Successfully'
                ]); 

            }
        }
        catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function destory(Request $request){
        try{
            
            $request->validate([
                'id' => 'required|exists:wishlist,id'
            ]);

           $wishlist = Wishlist::where('id',$request->id)->delete();
           $count = Wishlist::where('user_id', Auth::id())->count();
          

                return response()->json([
                    'success' => true,
                    'count' => $count,
                    'message' => ' Wishlist Delete Successfully'
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
