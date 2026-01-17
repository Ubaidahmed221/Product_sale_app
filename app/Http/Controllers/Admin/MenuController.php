<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;


class MenuController extends Controller
{
    public function index(){
        try{
          $parentMenu =  Menu::whereNull('parent_id')->get();
          $menus = Menu::paginate(15);
            return view('admin.menus',compact('parentMenu','menus'));
        }
        catch(\Exception $e){
            return abort(404,"Something Went Wrong");

        }
    }

    public function store(Request $request){
        try{
            Menu::create(
                $request->only([
                    'name' ,
                    'url',
                    'is_external',
                    'position',
                    'parent_id'
                ])
            );

            return response()->json([
                'success' => true,
                'msg' => 'Menu created Successfully'
            ]);

        }
        catch(\Exception $e){
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }
    public function update(Request $request){
        try{

            Menu::where('id',$request->id)->update([
                'name' => $request->name,
                'url' => $request->url,
                'is_external' => isset($request->is_external)?$request->is_external: 0,
                'position' => $request->position,
                'parent_id' => $request->parent_id,

            ]);

            return response()->json([
                'success' => true,
                'msg' => 'Menu Update   Successfully'
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
            Menu::where('id',$request->id)->delete();

            return response()->json([
                'success' => true,
                'msg' => 'Menu Delete Successfully'
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
