<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\category;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    public function index(){
        try{
         $category = category::whereNull('parent_id')->get();
      $allcategory =   category::with('parent')->paginate(5);
    // $allcategory = category::paginate(5);
            return view('admin.categories',compact(['category','allcategory']));
        }catch(\Exception $e){
            return abort(404,"something went wrong");
        }
    }

    public function store(Request $request){
        try{
            $request->validate([
                'image' => 'required|image|mimes:png,jpeg,svg,gif|max:5048',
                'category_name' => 'required|unique:categories,name',
                'parent_id' => 'nullable|exists:categories,id'
            ]);
            if($request->hasFile('image')){
                $image = $request->file('image');
             $imageName =   time().'_'.uniqid().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('categories'),$imageName);
            $imagepath = 'categories/'.$imageName;
            }
        category::create([
            'name' => $request->category_name,
            'parent_id' => $request->parent_id,
            'image' => $imagepath
         ]);

            return response()->json([
                'success' => true,
                'msg' => 'category created Successfully'
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
                'id' => 'required|integer|exists:categories,id',
                'image' => 'nullable|image|mimes:png,jpeg,svg,gif|max:5048',
                'category_name' => 'required|unique:categories,name,'. $request->id,
                 'parent_id' => 'nullable|exists:categories,id'
            ]);
         $category =   category::find($request->id);
         $category->name = $request->category_name;
         $category->parent_id = $request->parent_id;
            if($request->hasFile('image')){
         if(!empty($category->image)){
            $filepath = public_path($category->image);
            if(File::exists($filepath)){
                File::delete($filepath);

            }
        }
       
            $image = $request->file('image');
         $imageName =   time().'_'.uniqid().'.'.$image->getClientOriginalExtension();
        $image->move(public_path('categories'),$imageName);
        $imagepath = 'categories/'.$imageName;
        
        $category->image =  $imagepath;

            }
            $category->save();

            return response()->json([
                'success' => true,
                'msg' => 'Category Update   Successfully'
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
                'id' => 'required|integer|exists:categories,id'
            ]);
            $category = category::where('id',$request->id)->orWhere('parent_id',$request->id)->get();
            foreach($category as $categories){
                if(!empty($categories->image)){
                    $filepath = public_path($categories->image);
                    if(File::exists($filepath)){
                        File::delete($filepath);

                    }
                }

            }
            category::where('id',$request->id)->orWhere('parent_id',$request->id)->delete();

            return response()->json([
                'success' => true,
                'msg' => 'Category Delete Successfully'
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
