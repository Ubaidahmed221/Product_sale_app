@extends('layouts.admin-layout')

@section('content')
    <h2 class="mb-4">All Users</h2>

     <table class="table table-bordered  " >
                <thead>
                    <tr>
               
                        <th>ID</th>
                        <th> Name </th>
                        <th>Email</th>
                        <th>Status</th>
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
                               
                                <td><a href="" class="btn btn-sm btn-outline-info">View Order</a></td>
                               
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
                </tbody>
            </table>
            <div class="col-12 pb-1 d-flex justify-content-center">
                {{ $users->links('pagination::bootstrap-5')}}
            </div>
    @endsection 