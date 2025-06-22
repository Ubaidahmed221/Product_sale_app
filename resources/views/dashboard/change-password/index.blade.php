@extends('dashboard.layout')

@section('dashboard-content')
<h4>Change Password</h4>
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

    <form action="{{route('user.update.password')}}" method="POST" > 
        @csrf
        @method('PUT')
        <div class="form-group" >
            <label >Current Password</label>
            <input type="password" name="current_password" class="form-control" placeholder="Confirm Password" >
            @error('current_password')
                    <div class="text-dnager" >{{ $message}}</div>
            @enderror
        </div>
         <div class="form-group" >
            <label >New Password</label>
            <input type="password" name="new_password" class="form-control" placeholder="New Password" >
            @error('new_password')
                    <div class="text-dnager" >{{ $message}}</div>
            @enderror
        </div>
          <div class="form-group" >
            <label >Confirm New Password</label>
            <input type="password" name="new_password_confirmation" class="form-control" placeholder="Confirm New Password" >
         
        </div>
        <button type="submit" class="btn btn-primary" >Change Password</button>
    </form>
@endsection