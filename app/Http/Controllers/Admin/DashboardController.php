<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppData;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
     public function index(){
        try{
           $totalOrder = Order::count();
           $totalrevenuePkr = Order::where(['payment_status' => 'success', 'currency' => 'pkr'])->sum('total');
           $totalrevenueUsd = Order::where(['payment_status' => 'success', 'currency' => 'usd'])->sum('total');
           $totalUser =  User::where('is_admin', 0)->count();
           $productInStock =  Product::sum('stock');
           $recentOrder =   Order::latest()->take(5)->get();

           return view('admin.dashboard'
           ,compact(
               'totalOrder',
               'totalrevenuePkr',
               'totalrevenueUsd',
               'totalUser',
               'productInStock',
               'recentOrder'
           )
        );
        }
        catch(\Exception $e){
            return abort(404,"Something Went Wrong");
        }
    }
}
