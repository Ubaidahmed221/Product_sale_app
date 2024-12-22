<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        try{

            return view('admin.products');
        }
        catch(\Exception $e){
            return abort(404,"Something Went Wrong");

        }
    }
}
