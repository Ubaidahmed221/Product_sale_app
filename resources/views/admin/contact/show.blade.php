@extends('layouts.admin-layout')

@section('content')
    <h2 class="mb-4">Contact Message </h2>
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
    <h3>Message From {{ $message->name }}</h3>
    <p><strong>Email: </strong>{{ $message->email }}</p>
    <p><strong>Subject: </strong>{{ $message->subject }}</p>
    <p><strong>Message: </strong>{{ $message->message }}</p>


    <form action="{{ route('admin.contact.update',$message->id) }}" method="POST" class="mb-5" >
        @csrf
        @method('PUT')

        <select name="status" class="form-control w-25">
            <option value="0" {{$message->status == 0 ? 'selected' : ''}} >Unread</option>
            <option value="1" {{$message->status == 1 ? 'selected' : ''}} >Read</option>
            <option value="2" {{$message->status == 2 ? 'selected' : ''}} >Replied</option>
        </select>
        <button  class="btn btn-primary mt-2" type="submit" >Update Status</button>
    </form>
        <a href="{{route('admin.contact.index')}}" class="btn btn-secondary" >Back</a>

    @endsection 