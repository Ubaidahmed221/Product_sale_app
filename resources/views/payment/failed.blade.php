@extends('layouts.layout')

@section('content')


    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Payment Failed</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="{{route('index')}}">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Order Failed</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

       <!-- Cart Start -->
       <div class="container-fluid pt-5">
        <div class="row px-xl-5">
         <div class="col-12 text-center">
            <div class="alert alert-danger w-100" ><strong>Oops!</strong> You Payment was not Successful. please try again or contact Support. </div>
            <a href="{{route('shop')}}" class="btn btn-primary px-4 mt-3" >Shop</a>
        </div>
        </div>
    </div>
    <!-- Cart End -->


@endsection
