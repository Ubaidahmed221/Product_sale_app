
<div class="card mt-4 ">
    <div class="card-header">Order Items</div>
    <div class="card-body">
        <table class="table" >
            <thead>

                <tr>
                    <th>#</th>
                    <th>Product </th>
                    <th>Quantity</th>
                    <th>Price</th>
              
                    <th>Total</th>
                </tr>
                
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->product_title }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $order->currency == 'pkr' ? 'Rs' : '$' }} {{  $item->price }}</td>
                  
                    <td>{{ $order->currency == 'pkr' ? 'Rs' : '$' }} {{ $item->price * $item->quantity }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>