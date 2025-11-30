@extends('layouts.admin-layout')

@section('content')
    <h2 class="mb-4">Affiliate Commissions</h2>

     <table class="table table-bordered  " >
                <thead>
                    <tr>

                        <th> ID </th>
                        <th>Affiliate </th>
                        <th>Order ID</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($commission as $commissions)
                            <tr>
                                <td> {{ $commissions->id}}</td>
                                <td> {{ $commissions->affiliate->name}} ({{ $commissions->affiliate->email}}) </td>
                                <td> {{ $commissions->order_id}}</td>
                                <td> {{ number_format($commissions->commission_amount,2) }}</td>
                                <td> {{ $commissions->status}}</td>
                              <td>
                                @if ($commissions->status == 'pending')
                                  
                                        <button class="btn btn-sm btn-success">Approve</button>
                                        <button class="btn btn-sm btn-danger">Reject</button>
                                    @elseif ($commissions->status == 'approved')
                                        <button class="btn btn-sm btn-success">Mark Paid</button>
                                @else
                                    <span class="text-muted" >No Action</span>
                                @endif
                              </td>
                            </tr>
                    @endforeach
                    @if (count($commission) == 0)
                        <tr>
                            <td colspan="6" class="text-center">No Affiliate Commission found</td>
                        </tr>
                        
                    @endif
                </tbody>
            </table>
            <div class="col-12 pb-1 d-flex justify-content-center">
                {{ $commission->links('pagination::bootstrap-5')}}
            </div>
    @endsection 