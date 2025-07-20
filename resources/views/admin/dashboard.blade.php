@extends('layouts.admin-layout')

@section('content')
    <h2 class="mb-4">Admin Dashboard</h2>

    <div class="row">
        <div class="col-md-3">
            <div class="card bg-primary text-white p-3">
               <h5 class="text-white">Total Orders</h5>
               <h3 class="text-white">{{ $totalOrder }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-success text-white p-3">
               <h5 class="text-white">Total Revenue in PKR</h5>
               <h3 class="text-white"> Rs {{ $totalrevenuePkr }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-success text-white p-3">
               <h5 class="text-white">Total Revenue in USD</h5>
               <h3 class="text-white"> $ {{ $totalrevenueUsd }}</h3>
            </div>
        </div>
          <div class="col-md-3">
            <div class="card bg-info text-white p-3">
               <h5 class="text-white">Total User</h5>
               <h3 class="text-white"> {{ $totalUser }}</h3>
            </div>
        </div>

    </div>
        <div class="row mt-4">
            
          <div class="col-md-3">
            <div class="card bg-warning text-white p-3">
               <h5 class="text-white">Total Product In STock</h5>
               <h3 class="text-white"> {{ $productInStock }}</h3>
            </div>
        </div>

    </div>
        <div class="row mt-4">
            
          <div class="col-md-12 ">
            <h5>Recent Orders</h5>
            <table class="table table-bordered  " >
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Order ID</th>
                        <th>User Name</th>
                        <th>Order Status</th>
                        <th>Payment Status</th>
                        <th>Total</th>
                        <th>Placed At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentOrder as $order)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>#{{ $order->id}}</td>
                                <td> {{ $order->user->name}}</td>
                                <td> {{  ucfirst($order->status)}}</td>
                                <td> {{  ucfirst($order->payment_status)}}</td>
                                <td> {{ $order->currency == 'pkr' ? 'Rs' : '$' }} {{ $order->total }} </td>
                                <td>{{ $order->created_at->format('d M Y') }}</td>
                            </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
  
@endsection
