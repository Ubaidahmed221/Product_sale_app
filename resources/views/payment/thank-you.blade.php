@extends('layouts.layout')

@section('content')

    @php
      $currency =  $order->currency == 'pkr' ? 'Rs' : '$';
    @endphp

    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Thank Information</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="{{route('index')}}">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Thank You For Your Order</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

       <!-- Thank You session -->
       <div class="container py-2">
        <div class="row ">
          <div class="col-md-8 bg-light p-4 shadow rounded offset-md-2" >
            <h4 class="mb-4">Order Summery
                  <a href="{{route('user.orders.invoice',$order->id)}}" class="btn btn-primary btn-sm float-right btn-outline-primary text-white " >Download Invoice</a>
            </h4>
            <p><strong>Order ID:</strong> {{$order->id}} </p>
            @if ($order->transaction_id)
            <p><strong>Transaction ID:</strong> {{$order->transaction_id}} </p>
            @endif
            <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }} </p>
            <p><strong>Payment Status:</strong>
               <span class="badge bg-{{$order->payment_status  === 'success' ?
                         'success text-white' : ($order->payment_status  === 'failed' ? 
                         'danger text-white' : 'secondary') }}" >
                  {{ ucfirst($order->payment_status) }} </span> 
                </p>
                <hr>
                <h5>Billing Address</h5>
                <p> <strong>Full Name:</strong>  {{ $order->billing_address['first_name'] ?? '' }} {{ $order->billing_address['last_name'] ?? '' }}</p>
                <p><strong>Email:</strong> {{ $order->billing_address['email'] ?? '' }} </p>
                <p><strong>Phone :</strong> {{ $order->billing_address['phone'] ?? '' }} </p>
                <p><strong>Address No 1:</strong> {{ $order->billing_address['address_1'] ?? '' }} </p>
                <p><strong>Address No 2:</strong> {{ $order->billing_address['address_2'] ?? '' }} </p>
                <p><strong>City:</strong> {{ $order->billing_address['city'] ?? '' }}, <strong>State:</strong> {{ $order->billing_address['state'] ?? '' }}  </p>
                <p><strong>Country:</strong> {{ $order->billing_address['country'] ?? '' }} </p>
                <p><strong>Zip:</strong> {{ $order->billing_address['zip'] ?? '' }} </p>

                @if ($order->shipping_address)
                <h5>Shipping Address</h5>
                <p><strong>Full Name:</strong>  {{ $order->shipping_address['first_name'] ?? '' }} {{ $order->shipping_address['last_name'] ?? '' }}</p>
                <p><strong>Email:</strong> {{ $order->shipping_address['email'] ?? '' }} </p>
                <p><strong>Phone :</strong> {{ $order->shipping_address['phone'] ?? '' }} </p>
                <p><strong>Address No 1:</strong> {{ $order->shipping_address['address_1'] ?? '' }} </p>
                <p><strong>Address No 2:</strong>  {{ $order->shipping_address['address_2'] ?? '' }} </p>
                <p><strong>City:</strong> {{ $order->shipping_address['city'] ?? '' }},<strong>State:</strong>  {{ $order->shipping_address['state'] ?? '' }}  </p>
                <p><strong>Country:</strong>  {{ $order->shipping_address['country'] ?? '' }} </p>
                <p><strong>Zip:</strong> {{ $order->shipping_address['zip'] ?? '' }} </p>

                @endif
                <hr>
                <h5>Order Total</h5>
                <p>SubTotal: {!! $currency !!} {{number_format($order->subtotal,2)}}</p>
                <p>Shipping: {!!$currency!!}{{number_format($order->shipping_amount,2)}}</p>
                <p> <strong> Total Paid: {!!$currency!!}{{number_format($order->total,2)}}</strong></p>

                @if ($order->items && $order->items->count())
                    <hr>
                    <h5 class="mt-4" >Items Ordered</h5>
                    <ul>
                        @foreach ($order->items as $item)
                            <li>{{ $item->product_title ?? 'Product' }} x {{$item->quantity}} -  {!!$currency!!}{{number_format($item->price,2)}} </li>
                        @endforeach
                    </ul>
                @endif
          </div>
        </div>
    </div>
    <!-- Thank You session -->


@endsection
