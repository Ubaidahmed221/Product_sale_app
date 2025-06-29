<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Models\Address;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;


class UserController extends Controller
{
    public function account(){
        try{
           return view('dashboard.account.index');
        }
        catch(\Exception $e){
           return abort(404,'something went wrong!');
        }
    }
    public function orders(){
        try{
      $orders =  Order::where('user_id',auth()->user()->id)->latest()->paginate(5);
           return view('dashboard.orders.index',compact('orders'));
        }
        catch(\Exception $e){
           return abort(404,'something went wrong!');
        }
    }
    public function orderInformation($id){
        try{
      $order =  Order::with('items')->findOrFail($id);
           return view('dashboard.orders.order-information',compact('order'));
        }
        catch(\Exception $e){
           return abort(404,'something went wrong!');
        }
    }
    public function address(){
        try{
        $addresses = Address::where('user_id',auth()->user()->id)->get();

           return view('dashboard.address.index',compact('addresses'));
        }
        catch(\Exception $e){
           return abort(404,'something went wrong!');
        }
    }
     public function Updateaddress(AddressRequest $request){
        try{
        
            $user_id = auth()->user()->id;
          
         $billingAddress =[
            'first_name' => $request->input("first_name"),
            'last_name' => $request->input("last_name"),
            'email' => $request->input("email"),
            'phone' => $request->input("phone"),
            'address_1' => $request->input("address_1"),
            'address_2' => $request->input("address_2") ? $request->input("address_2"): null,
            'country' => $request->input("country"),
            'state' => $request->input("state"),
            'city' => $request->input("city"),
            'zip' => $request->input("zip"),
        ];

        Address::updateOrCreate([
            'user_id' => $user_id,
            'type' => 'billing'],
            $billingAddress
        );

         $shippingAddress =[
            'first_name' => $request->input("shipping_first_name"),
            'last_name' => $request->input("shipping_last_name"),
            'email' => $request->input("shipping_email"),
            'phone' => $request->input("phone"),
            'address_1' => $request->input("shipping_address_1"),
            'address_2' => $request->input("shipping_address_2") ? $request->input("shipping_address_2"): null,
            'country' => $request->input("shipping_country"),
            'state' => $request->input("shipping_state"),
            'city' => $request->input("shipping_city"),
            'zip' => $request->input("shipping_zip"),
        ];

        Address::updateOrCreate([
            'user_id' => $user_id,
            'type' => 'shipping'],
            $shippingAddress
        );


        return response()->json([
            'success' => true,
            'message' => 'Address Updated Successfully',
           
        ]);
      

        }
        catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function changePassword(){
        try{
           return view('dashboard.change-password.index');
        }
        catch(\Exception $e){
           return abort(404,'something went wrong!');
        }
    }
       public function updatePassword(Request $request){
        try{
       $validator =  Validator::make($request->all(),[
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed'
         ]);
         if($validator->fails()){
                      return back()->withErrors($validator)->withInput();

         }
            $user = Auth::user();

            if(!Hash::check($request->current_password,$user->password)){
                      return back()->withErrors(['current_password' => 'Current Password does not match.'])->withInput();

            }
            $user->password = Hash::make($request->new_password);
            $user->save();

            return back()->with(['success' => 'password Changed Successfully']);

        }
        catch(\Exception $e){
            return back()->with(['error' => $e->getMessage()]);
         }
    }

    public function accountUpdate(Request $request){
        try{
            $user = User::findOrFail(auth()->user()->id);
            $user->name = $request->name;
            $user->gender = $request->gender;
            $user->save();
            return back()->with(['success' => 'Updated Successfully']);

        }
        catch(\Exception $e){
            return back()->with(['error' => $e->getMessage()]);
         }
    }

       public function downloadInvoice(Order $order){
        try{

            if($order->user_id !== auth()->id()){
                abort(403,"Unauthorized");
            }


             $pdf = Pdf::loadView('invoices.order', compact('order'));
              return $pdf->download('invoice_user_order_'.$order->id.'.pdf');
        }
        catch(\Exception $e){
           return abort(404,'something went wrong!');
        }
    }
}
