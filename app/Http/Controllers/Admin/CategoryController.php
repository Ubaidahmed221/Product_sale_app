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
            return view('admin.categories',compact('category'));
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
}
