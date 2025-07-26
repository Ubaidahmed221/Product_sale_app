<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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
    
       public function downloadInvoice(Order $order){
        try{

             $pdf = Pdf::loadView('invoices.order', compact('order'));
              return $pdf->download('invoice_#'.$order->id.'.pdf');
        }
        catch(\Exception $e){
           return abort(404,'something went wrong!');
        }
    }
       public function updateStatus(Request $request,Order $order){
        try{
            $request->validate([
                'status' => 'required|in:pending,processing,completed,cancelled,failed',
            ]);

           $order->status = $request->status;
              $order->save();


           return back()->with('success', 'Order status updated successfully.');
            
        }
        catch(\Exception $e){
           return back()->with('error', $e->getMessage());

           
        }
    }

    
}
