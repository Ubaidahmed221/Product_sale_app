<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function states(Request $request){
        try{
            $request->validate([
                'countryCode' => 'nullable'
            ]);

         $state =  State::where('country_code',$request->countryCode)->get();

            return response()->json([
                'success' => true,
                'msg' => 'states',
                'data' =>  $state
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
