@extends('layouts.layout')

@section('content')
<div class="container">
    <h3 class="mt-2 mb-5 text-center">Forget Password</h3>
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
    <form  action="{{ route('forgetPasssword') }}"  method="POST">
        @csrf

        <div class="form-group">
          <label >Email </label>
          <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Enter Your EMail" required >
          @error('email')
          <span class="error-message">{{ $message }}</span>
      @enderror
        </div>


        <button type="submit" class="btn btn-primary">Forget Password</button>
      </form>

</div>

@endsection


