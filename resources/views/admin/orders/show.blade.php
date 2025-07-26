@extends('layouts.admin-layout')

@section('content')
    <h2 class="mb-4">Orders #{{$order->id}}</h2>
     @if (Session::has('success'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('success') }}
      </div>

    @endif
    @if (Session::has('error'))
    <div class="alert alert-danger" role="alert">
        {{ Session::get('error') }}
      </div>

    @endif

    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
    <p><strong>Payment:</strong> {{ ucfirst($order->payment_status) }} | {{$order->payment_method}} </p>
    <p><strong>Shipping Amount:</strong>{{ $order->currency == 'pkr' ? 'Rs' : '$' }} {{ $order->shipping_amount }}</p>
    <form action="{{route('admin.orders.update.status', $order->id)}}" method="POST" class="mb-4">
        @csrf
        @method('PUT')
       <select name="status"  class="form-control w-25 d-inline">
            <option value="all">All</option>
            @foreach (['pending','processing','completed','cancelled','failed'] as $status)
                <option value="{{$status}}" {{ $order->status == $status ? 'selected' : '' }}> {{ucfirst($status)}} </option>
            @endforeach
        </select>
        <button class="btn btn-warning btn-sm" >Update</button>
    </form>

    @include('admin.orders.partials.detail', ['order' => $order]);

    @endsection