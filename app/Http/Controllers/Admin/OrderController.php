<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\sendPushNotificationJob;
use App\Models\AffiliateCommission;
use App\Models\Order;
use App\Services\AffiliateCommissionService;
use App\Services\GoogleAccessTokenServices;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

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
          $approvedCommission =  AffiliateCommission::where(['order_id' => $order->id, 'status' => 'approved' ])->first();
            if($request->status != 'completed' && $approvedCommission){
                return back()->with('error', 'The affiliate commission for this order has already been approved. Please go to commission section and dissapprove the transaction.');

            }
           $order->status = $request->status;
           $order->save();
           if($request->status == 'completed'){
                  Log::info("Order commsion add");
                // add affiliate commission
                AffiliateCommissionService::addCommission($order);
                }else{
                     Log::info("Order commsion rollback");
                    // roll back commission if any
                    AffiliateCommissionService::rollBackCommission($order);
                }
            // Dispatch the job to send push notification
            dispatch(new sendPushNotificationJob($order));
        //    sendPushNotification($order->user_id,$order->id,"#{$order->id} status updated","Your order status is ".ucfirst($order->status));

           return back()->with('success', 'Order status updated successfully.');
            
        }
        catch(\Exception $e){
           return back()->with('error', $e->getMessage());

           
        }
    }

    
}
