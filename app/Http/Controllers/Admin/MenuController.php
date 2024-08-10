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
            return view('admin.menus',compact('parentMenu'));
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
}