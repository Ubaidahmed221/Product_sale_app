@extends('layouts.layout')

@section('content')

    @php
      $getSubTotal =  getCartSubTotal();
    @endphp

    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Wishlist</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="{{route('index')}}">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Wishlist</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

       <!-- Cart Start -->
       <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-12 table-responsive mb-5">
                <table class="table table-bordered text-center mb-0">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Add To Cart</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle cart-table">
                        @if (count($wishlist) == 0)
                            <tr >
                                <td colspan="6" > Wishlist is Empty ! <a href="{{ route('shop') }}">Shop</a></td>
                            </tr>
                        @endif
                        @foreach ($wishlist as $wishlists)
                        <tr data-id="{{$wishlists->id}}" >
                            <td class="align-middle"><img src="{{ asset($wishlists->product->firstImage->path) }}" alt="" style="width: 50px;">
                                 {{ $wishlists->product->title }}</td>
                               
                            <td class="align-middle">
                                @if (getUserCurrency())
                                Rs {{ number_format($wishlists->product->pkr_price,2) }}
                                 @else
                              $ {{ number_format($wishlists->product->usd_price,2) }}
                                  @endif
                              
                            </td>
                            <td class="align-middle">
                                @if ($wishlists->product['stock'] > 0)
                                    <span class="badge badge-primary" >In Stock</span>    
                                @else
                                <span class="badge badge-danger" >Out Of Stock</span>    

                                @endif
                            </td>
                            <td class="align-middle">
                                @if ($wishlists->product->stock > 0)
                                <a class="btn btn-sm text-dark p-0 add-to-cart" data-product-id="{{$wishlists->product->id }}"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>   
                                @else
                                <button class="btn btn-sm btn-secondary" >Out Of Stock</button>    

                                @endif
                            </td>
                           
                            <td class="align-middle"><button class="btn btn-sm btn-primary wishlistDelete" data-id="{{$wishlists->id}}" >
                                <i class="fa fa-times"></i></button></td>
                        </tr>
                            
                        @endforeach
                       
                    </tbody>
                </table>
            </div>
          
        </div>
    </div>
    <!-- Cart End -->


@endsection
@push('script')
<script>
    $('document').ready(function(){

        // wishlist delete
        $('.wishlistDelete').click(function(){
            $('#page-loader').show();
            var obj = $(this);
             var id =  $(obj).data('id');

        $.ajax({
                url: "{{ route('wishlist.destory') }}",
                type: "DELETE",
                data: {
                    _token: "{{csrf_token()}}",
                    id: id
                },
                success: function(response){
            $('#page-loader').hide();

                    if(response.success ){
                        $(obj).parent().parent().remove();
                       
                        $('.wishlist-badge-count').text(response.count);

                        if(response.count == 0){
                            $('.cart-table').html(`
                             <tr >
                                <td colspan="6" > Wishlist is Empty ! <a href="{{ route('shop') }}">Shop</a></td>
                            </tr>
                            `);
                            
                        }
                        alert(response.message);
                    }
                    else{
                        alert(response.message);

                    }
                },
                error: function(error){
            $('#page-loader').hide();
                    alert(error.message)
                }
            });

        });

    
    });

</script>
@endpush