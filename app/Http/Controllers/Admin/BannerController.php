<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;

class BannerController extends Controller
{
    public function index(){
        try{

         $banners =   Banner::paginate(5);
       // $allcategory = category::paginate(5);
               return view('admin.banners',compact(['banners','banners']));
           }catch(\Exception $e){
               return abort(404,"something went wrong");
           }
    }
    public function store(Request $request){
        try{
            $request->validate([
                'image' => 'required|mimes:jpg,png|max:5120',
                'heading' => 'required'
            ]);
            $filename = '';
            if($request->hasFile('image')){
                $file = $request->file('image');
               $filename =  time().'_'.$file->getClientOriginalName();
              $distinationPath =  public_path('uploads');
                $file->move($distinationPath,$filename);

                $filename = 'uploads/'.$filename;
            }
            Banner::create([
            'image' => $filename,
            'paragraph' => $request->paragraph,
            'heading' => $request->heading,
            'btn_text' => $request->btn_text,
            'link' => $request->link,
            'status' => $request->status
         ]);

            return response()->json([
                'success' => true,
                'msg' => 'Banner created Successfully'
            ]);

        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }
}
