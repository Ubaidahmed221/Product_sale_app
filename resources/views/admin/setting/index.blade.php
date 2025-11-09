@extends('layouts.admin-layout')

@section('content')
    <h2 class="mb-4">Setting </h2>

    <h4>Affiliate Setting</h4>
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

   <form action="{{ route('admin.setting.affiliate.update') }}" method="POST" >
                 @csrf
                    @method('PUT')            
            <div class="form-group">
                <label>Commission Percenatge (%):</label>
                <input type="number" min="0" step="0.01" class="form-control" name="commission_percentage" 
                placeholder="Commission Percentage" required value="{{$affiliate ? $affiliate->commission_percentage : ''}}" >
                @error('commission_percentage')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Min Payout: </label>
                <input type="number" min="1" class="form-control" name="min_payout" 
                placeholder="min payout" required value="{{$affiliate ? $affiliate->min_payout : ''}}" >
                @error('min_payout')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
               <div class="form-group">
                <label >Auto Credit Wallet:</label>
                <input type="checkbox" name="auto_credit_wallet"  value="1" {{ $affiliate?->auto_credit_wallet ? 'checked' : '' }} >
               </div>
               
                     <button type="submit" class="btn btn-primary createBtn">Update</button>
            

             </form>

 @endsection