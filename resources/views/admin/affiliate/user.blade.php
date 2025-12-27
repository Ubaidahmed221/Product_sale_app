@extends('layouts.admin-layout')

@section('content')
    <h2 class="mb-4">Affiliate Users</h2>

     <table class="table table-bordered  " >
                <thead>
                    <tr>

                        <th> ID </th>
                        <th>User </th>
                        <th>Referral Code</th>
                        <th>Total Referrals</th>
                        <th>Total Orders</th>
                        <th>Total Earned</th>
                        <th>Wallet Balance </th>
                       
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                            <tr>
                                <td> {{$loop->iteration}} </td>
                                <td>
                                    <strong> {{ $user->name }}  </strong><br>
                                    <small> {{ $user->email }} </small>
                                </td>
                                <td>
                                    <span  class="badge bg-primary text-white" >{{ $user->referral_code }}</span>
                                </td>
                                <td>
                                    {{ $user->referrals->count() }}
                                </td>
                                <td>
                                    {{ $user->orders->count() }}
                                </td>
                                <td>
                                    Rs {{ number_format($user->total_earned ?? 0,2) }}
                                </td>
                                <td>
                                    Rs {{ number_format($user->wallet_balance ?? 0,2) }}
                                </td>
                            </tr>
                    @endforeach
                    @if (count($users) == 0)
                        <tr>
                            <td colspan="6" class="text-center">No Affiliate user found</td>
                        </tr>
                        
                    @endif
                </tbody>
            </table>
            <div class="col-12 pb-1 d-flex justify-content-center">
                {{ $users->links('pagination::bootstrap-5')}}
            </div>
    @endsection 