@extends('layouts.admin-layout')

@section('content')
    <h2 class="mb-4">Contact Message </h2>

    <form action="{{route('admin.contact.index')}}" method="GET" class="mb-3" >
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

                        <th> Name </th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Recieved</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($message as $messages)
                            <tr>
                                <td> {{ $messages->name}}</td>
                                <td> {{ $messages->email}}</td>
                                <td> {{ $messages->subject}}</td>
                                <td>
                                    @if ($messages->status == 0)
                                        <span class="badge bg-danger text-white">Unread</span>
                                    @elseif ($messages->status == 1)
                                        <span class="badge bg-info text-white" >Read</span>
                                    @else
                                        <span class="badge bg-success text-white">Replied</span>
                                        
                                    @endif
                                </td>
                               <td>
                              {{ $messages->created_at->diffForHumans() }}
                               </td>
                               
                                <td>
                                    <a class="btn btn-primary" href="{{ route('admin.contact.show', $messages->id) }}">View</a>
                                    <form action="{{ route('admin.contact.distroy', $messages->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Delete this message?')" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                    @endforeach
                    @if (count($message) == 0)
                        <tr>
                            <td colspan="6" class="text-center">No users found</td>
                        </tr>
                        
                    @endif
                </tbody>
            </table>
            <div class="col-12 pb-1 d-flex justify-content-center">
                {{ $message->links('pagination::bootstrap-5')}}
            </div>
    @endsection 