@extends('layouts.layout')

@section('content')

    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Affiliate Dashboard</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="{{route('index')}}">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Affiliate</p>
            </div>
        </div>  
    </div>

    
    <!-- Contact Start -->
    <div class="container pt-5">
        <div class="card">
            <div class="card-body">
                <p><strong>Your Referral Link: </strong> {{url('?ref='.auth()->user()->referral_code)}} </p>
                <p><strong>Total Referral : </strong> {{ $referrals }} </p>
                <p><strong>Wallet Balance : </strong> <i class="fas fa-rupe-sign"> &nbsp; {{ number_format(auth()->user()->wallet_balance,2) }} PKR</i> </p>
          
          <h4>Commissions</h4>
          <table class="table mb-5" >
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($commissions as $commission) 
                <tr>
                    <td>{{ $commission->order_id }}</td>
                    <td>{{  number_format($commission->commission_amount,2)  }}</td>
                    <td>{{ $commission->status }}</td>
                    <td>{{ $commission->created_at->format('Y-m-d') }}</td>
                </tr>
                    
                @endforeach
                @if (count($commissions) == 0 )
                    <tr>
                        <td colspan="4" >No Commission data available!</td>
                    </tr>
                @endif
            </tbody>
          </table>
          {{$commissions->links()}}
          <h4>Request Withdrawl </h4>
          <form action="" method="POST" >
            @csrf
            <div class="form-group" >
                <label >Amount</label>
                <input type="number" placeholder="Enter Withdrawl Amount" name="amount" min="1" step="0.01" class="form-control" required >
            </div>
            <button class="btn btn-primary mt-2" >  Request</button>
          </form>
            </div>
        </div>
      
    </div>
    <!-- Contact End -->
@endsection