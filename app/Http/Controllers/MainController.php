<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(){
        try{
            return view('index');
        }
        catch(\Exception $e){
            return abort(404,"Something Went Wrong");

        }
    }
}
