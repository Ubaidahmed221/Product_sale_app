@extends('layouts.admin-layout')

@section('content')
    <h2 class="mb-4">Orders #{{$order->id}}</h2>

    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
    <p><strong>Payment:</strong> {{ ucfirst($order->payment_status) }} | {{$order->payment_method}} </p>
    <p><strong>Shipping Amount:</strong>{{ $order->currency == 'pkr' ? 'Rs' : '$' }} {{ $order->shipping_amount }}</p>

    @include('admin.orders.partials.detail', ['order' => $order]);

    @endsection