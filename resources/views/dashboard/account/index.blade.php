@extends('dashboard.layout')

@section('dashboard-content')
    <h4>Account Information</h4>
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
    <form  action="{{ route('user.account.update') }}"  method="POST">
        @csrf
        <div class="form-group">
            <label >Name </label>
            <input type="text"  name="name" value="{{ auth()->user()->name }}" class="form-control" placeholder="Enter Your Name"  >
          
          </div>
        <div class="form-group">
          <label >Email </label>
          <input type="email" disabled name="email" value="{{ auth()->user()->email }}" class="form-control" placeholder="Enter Your EMail" required >
        
        </div>
        <div class="form-group">
            <label >Gender </label>
           <select name="gender" required class="form-control">
            <option value="">Select Gender</option>
            <option value="1" {{auth()->user()->gender === 1 ? 'selected' : '' }} >Male</option>
            <option value="0" {{auth()->user()->gender === 0 ? 'selected' : '' }}>Female</option>
           </select>
          </div>


        <button type="submit" class="btn btn-primary">Update</button>
      </form>
@endsection