@extends('layouts.admin-layout')

@section('content')
    <h2 class="mb-4">All Users</h2>

    <form action="{{route('admin.users.index')}}" method="GET" class="mb-3" >
        <div class="input-group w-25">
            <input type="text" name="search" class="form-control" placeholder="Search by name or email" value="{{ request('search') }}">
            <button class="btn btn-primary ml-3" type="submit">Search</button>
        </div>

    </form>

    @if (request('search'))
        <div class="alert alert-info">
            Search results for: <strong>{{ request('search') }}</strong>
        </div>
        
    @endif


     <table class="table table-bordered  " >
                <thead>
                    <tr>
               
                        <th>ID</th>
                        <th> Name </th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Affiliate Commission</th>
                        <th>Orders</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                            <tr>
                                <td>#{{ $user->id}}</td>
                                <td> {{ $user->name}}</td>
                                <td> {{ $user->email}}</td>
                                <td>
                                    @if ($user->is_block)
                                        <span class="badge bg-danger text-white">Blocked</span>

                                    @else
                                        <span class="badge bg-success text-white">Active</span>
                                        
                                    @endif
                                </td>
                               <td>
                                <a href="{{route('admin.affiliate-users',$user->id)}}"  class="btn btn-sm btn-outline-primary" > View Commission </a>
                               </td>
                                <td><a href="{{route('admin.users.orders',$user->id)}}" class="btn btn-sm btn-outline-info">View Order</a></td>
                               
                                <td>
                                  <form action="{{route('admin.users.toggle-block',$user->id)}}" method="POST" style="display:inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $user->is_block ? 'btn-success' : 'btn-danger' }}">
                                        {{ $user->is_block ? 'Unblock' : 'Block' }}
                                    </button>
                                  </form>
                                   <form action="{{route('admin.users.destroy',$user->id)}}" method="POST" onsubmit="return confirm('Are You Sure?')" style="display:inline-block;" >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger "> Delete
                                      
                                    </button>
                                  </form>
                                 
                                </td>
                            </tr>
                    @endforeach
                    @if (count($users) == 0)
                        <tr>
                            <td colspan="6" class="text-center">No users found</td>
                        </tr>
                        
                    @endif
                </tbody>
            </table>
            <div class="col-12 pb-1 d-flex justify-content-center">
                {{ $users->links('pagination::bootstrap-5')}}
            </div>
    @endsection 