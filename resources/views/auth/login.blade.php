@extends('layouts.layout')

@section('content')
<div class="container">
    <h1 class="mt-2 mb-5 text-center">Login</h1>
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
    <form  action="{{ route('login') }}"  method="POST">
        @csrf

        <div class="form-group">
          <label >Email </label>
          <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Enter Your EMail" required >
          @error('email')
          <span class="error-message">{{ $message }}</span>
      @enderror
        </div>

        <div class="form-group">
          <label >Password</label>
          <input type="password" name="password"  class="form-control"  placeholder="Enter Your Password" required  >
          @error('password')
          <span class="error-message">{{ $message }}</span>
      @enderror
        </div>


        <button type="submit" class="btn btn-primary">Login</button>
      </form>
      <a href="{{ route('forgetpasswordView') }}">Forget Password</a> |  <a href="{{ route('mailverificationView') }}">Mail Verification</a>
</div>

@endsection


