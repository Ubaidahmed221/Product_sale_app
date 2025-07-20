<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
     public function index(Request $request)
    {
        try {

            $query = Order::with('user')->latest();
            if($request->has('status') && $request->status != 'all' ){
                $query->where('status',$request->status);
            }
            $orders =   $query->paginate(5);
            return view('admin.orders.index', compact('orders'));
        } catch (\Exception $e) {
            return abort(404, "something went wrong");
        }
    }

     public function show(Order $order)
    {
        try {
            $order->load('items');
           
            return view('admin.orders.show', compact('order'));
        } catch (\Exception $e) {
            return abort(404, "something went wrong");
        }
    }
}
