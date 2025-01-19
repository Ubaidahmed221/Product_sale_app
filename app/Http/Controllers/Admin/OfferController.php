<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Offer;
use Illuminate\Support\Facades\File;

class OfferController extends Controller
{
    public function index(){
        try{
    //      $category = category::whereNull('parent_id')->get();
    //   $allcategory =   category::with('parent')->paginate(5);
    $alloffer = offer::paginate(5);
            return view('admin.offers',compact('alloffer'));
        }catch(\Exception $e){
            return abort(404,"something went wrong");
        }
    }

    public function store(Request $request){
        try{
            $request->validate([
                'image' => 'required|image|mimes:png,jpeg,svg,gif|max:5048',
                'heading' => 'required',
                'offer_heading' => 'required',
                'btn_text' => 'nullable',
                'btn_link' => 'nullable'
            ]);
            if($request->hasFile('image')){
                $image = $request->file('image');
             $imageName =   time().'_'.uniqid().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('offer'),$imageName);
            $imagepath = 'offer/'.$imageName;
            }
            Offer::create([
            'heading' => $request->heading,
            'offer_heading' => $request->offer_heading,
            'btn_text' => $request->btn_text,
            'btn_link' => $request->btn_link,
            'image' =>  $imagepath
         ]);

            return response()->json([
                'success' => true,
                'msg' => 'offer created Successfully'
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
                'id' => 'required|integer|exists:offers,id',
                'image' => 'nullable|image|mimes:png,jpeg,svg,gif|max:5048',
                'heading' => 'required',
                'offer_heading' => 'required',
                'btn_text' => 'nullable',
                'btn_link' => 'nullable'
            ]);
         $offer =   Offer::find($request->id);
         $offer->heading = $request->heading;
         $offer->offer_heading = $request->offer_heading;
         $offer->btn_text = $request->btn_text;
         $offer->btn_link = $request->btn_link;
        
            if($request->hasFile('image')){
         if(!empty($offer->image)){
            $filepath = public_path($offer->image);
            if(File::exists($filepath)){
                File::delete($filepath);

            }
        }
       
            $image = $request->file('image');
         $imageName =   time().'_'.uniqid().'.'.$image->getClientOriginalExtension();
        $image->move(public_path('offer'),$imageName);
        $imagepath = 'offer/'.$imageName;
        
        $offer->image =  $imagepath;

            }
            $offer->save();

            return response()->json([
                'success' => true,
                'msg' => 'Offer Update   Successfully'
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
            $request->validate([
                'id' => 'required|integer|exists:offers,id',
            ]);
            // Offer::where('id',$request->id)->delete();
            $offer =   Offer::find($request->id);
            if(!empty($offer->image)){
                $filepath = public_path($offer->image);
                if(File::exists($filepath)){
                    File::delete($filepath);
    
                }
            }
            $offer->delete();
            return response()->json([
                'success' => true,
                'msg' => 'Offer Delete Successfully'
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
