@extends('layouts.layout')

@section('content')
<div class="container">
    <h3 class="mt-2 mb-5 text-center">Reset Password</h3>

    @if (Session::has('error'))
    <div class="alert alert-danger" role="alert">
        {{ Session::get('error') }}
      </div>

    @endif
    <form  action="{{ route('resetPasssword') }}"  method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $user->id }}">

        <div class="form-group">
          <label >New Password</label>
          <input type="password" name="password"  class="form-control"  placeholder="Enter New Password" required  >
          @error('password')
          <span class="error-message">{{ $message }}</span>
      @enderror
        </div>

        <div class="form-group">
            <label >Confirm Password</label>
            <input type="password" name="password_confirmation"  class="form-control"  placeholder="Enter Confirmation Password" required  >
            @error('password_confirmation')
            <span class="error-message">{{ $message }}</span>
        @enderror
          </div>


        <button type="submit" class="btn btn-primary">Reset</button>
      </form>

</div>

@endsection


