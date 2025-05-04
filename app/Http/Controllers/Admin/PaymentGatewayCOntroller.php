<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class PaymentGatewayCOntroller extends Controller
{
    public function index()
    {
        try {

            $gateways = PaymentGateway::paginate(5);
            return view('admin.payment-gateway', compact('gateways'));
        } catch (\Exception $e) {
            return abort(404, "something went wrong");
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData =  $request->validate([  
                'name' => 'required|unique:payment_gateways,name',
                'type' => 'required|string',
                'is_enabled' => 'required'
             
            ]);
            PaymentGateway::create($validatedData);

            return response()->json([
                'success' => true,
                'msg' => 'Payment Gateways Created Successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request)
    {
        try {
            $validatedData =  $request->validate([
                'id' => 'required|exists:payment_gateways,id',

              'name' => [
                'required',
                Rule::unique('payment_gateways')->ignore($request->id)
                ],
                'type' => 'required|string',
                'is_enabled' => 'required'
             
            ]);
            $gateway =  PaymentGateway::findOrFail($request->id);
            unset($validatedData['id']);
            $gateway->update($validatedData);

            return response()->json([
                'success' => true,
                'msg' => 'Payment Gateways Updated Successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }

    public function destroy(Request $request)
    {
        try {

            $validatedData =  $request->validate([
                'id' => 'required|exists:payment_gateways,id',

            ]);
            PaymentGateway::where('id', $request->id)->delete();

            return response()->json([
                'success' => true,
                'msg' => 'Payment Gateway Deleted Successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }
}
