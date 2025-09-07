<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChatController extends Controller
{
     public function index(Request $request)
    {
         try {
            return view('admin.chat.index');
        } catch (\Exception $e) {
            return abort(404, "something went wrong");
        }
    }
}
