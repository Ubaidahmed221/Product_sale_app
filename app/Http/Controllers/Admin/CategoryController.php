<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\category;

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
                'category_name' => 'required|unique:categories,name',
                'parent_id' => 'nullable|exists:categories,id'
            ]);

        category::create([
            'name' => $request->category_name,
            'parent_id' => $request->parent_id
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

            category::where('id',$request->id)->update([
                'name' => $request->category_name,
              'parent_id' => $request->parent_id,

            ]);

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
