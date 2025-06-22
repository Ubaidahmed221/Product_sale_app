@extends('dashboard.layout')

@section('dashboard-content')
    <h4>Orders</h4>
    @if ($orders->count())
        <table class="table table-bordered table-striped mt-3" >
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th> Order Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr>

                    <td># {{ $order->id }}</td>
                    <td> {{ $order->created_at->format('d M Y ') }}</td>
                    <td> {!!$order->currency == 'pkr' ? 'Rs' : '$';!!} {{ $order->total }}</td>
                    <td> {{ $order->payment_method }}</td>
                    <td> 
                        <span class="badge bg-{{$order->payment_status  === 'success' ?
                         'success text-white' : ($order->payment_status  === 'failed' ? 
                         'danger text-white' : 'secondary') }}" >{{ $order->payment_status }}</span>
                    </td>
                    <td>
                        <span class="badge bg-{{$order->status  === 'completed' ?
                         'primary ' : ($order->status  === 'processing' ? 
                         'info text-white' : (($order->status  === 'cancelled' || $order->status  === 'failed' ) ? 
                         'danger text-white' : 'secondary') )  }}" >{{ $order->status }}</span>
                    </td>
                    <td>
                        <a href="{{route('user.orders.information',$order->id)}}" class="btn btn-sm btn-outline-dark ">View</a>
                    </td>
                </tr>
                    @endforeach

            </tbody>
        </table>
        <div class="col-12 pb-1 justify-content-center">

        {{ $orders->links('pagination::bootstrap-5') }}
</div>
    @else
        <p class="mt-3" >You have not places any Order yet.</p>
    @endif
@endsection