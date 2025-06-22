@extends('layouts.layout')

@section('content')
 <!-- Page Header Start -->
 <div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Dashboard</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="{{route('index')}}">Home</a></p>
           
        </div>
    </div>
</div>
<!-- Page Header End -->

<div class="container pt-5">
    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <a href="{{route('user.dashboard')}}" 
                class="list-group-item {{ request()->routeIs('user.dashboard') ? 'active': ''}}" >Account Information</a>
                <a href="{{route('user.orders')}}" 
                class="list-group-item {{ request()->routeIs('user.orders') ? 'active': ''}}" >My Orders</a>
                <a href="{{route('user.address')}}" 
                class="list-group-item {{ request()->routeIs('user.address') ? 'active': ''}}" >Shipping & Billing Address</a>
                <a href="{{route('user.change-password')}}" 
                class="list-group-item {{ request()->routeIs('user.change-password') ? 'active': ''}}" >Change Password</a>
           
            </div>
        </div>
        <div class="col-md-9">
            @yield('dashboard-content')
        </div>
    </div>
</div>


@endsection
@push('script')
    @stack('child-script')
@endpush