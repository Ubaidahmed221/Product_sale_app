@extends('layouts.admin-layout')

@section('content')
    <h2 class="mb-4"> {{$user->name}}'s Orders</h2>
<table class="table table-bordered  " >
                <thead>
                    <tr>
               
                        <th>Order ID</th>
                      
                        <th>Total</th>
                        <th>Order Status</th>
                        <th>Payment Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                            <tr>
                                <td>#{{ $order->id}}</td>
                      
                                <td> {{ $order->currency == 'pkr' ? 'Rs' : '$' }} {{ $order->total }} </td>
                                <td> {{  ucfirst($order->status)}}</td>
                                <td> {{  ucfirst($order->payment_status)}}</td>
                                <td>{{ $order->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{route('admin.orders.show',$order->id)}}"  class="btn btn-sm btn-primary" >Show</a>
                                    <a href="{{route('admin.orders.invoice',$order->id)}}"  class="btn btn-sm btn-success" >Invoice</a>
                                </td>
                            </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="col-12 pb-1 d-flex justify-content-center">
                {{ $orders->links('pagination::bootstrap-5')}}
            </div>
    @endsection 