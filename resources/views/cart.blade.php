@extends('layouts.layout')

@section('content')

    @php
      $getSubTotal =  getCartSubTotal();
    @endphp

    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Shopping Cart</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="{{route('index')}}">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Shopping Cart</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

       <!-- Cart Start -->
       <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-bordered text-center mb-0">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th>Products</th>
                            <th>Variations</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle cart-table">
                        @if (count($cartitems) == 0)
                            <tr >
                                <td colspan="6" > Cart Empty ! <a href="{{ route('shop') }}">Shop</a></td>
                            </tr>
                        @endif
                        @foreach ($cartitems as $cart)
                        <tr data-id="{{$cart->id}}" >
                            <td class="align-middle"><img src="{{ asset($cart->product->firstImage->path) }}" alt="" style="width: 50px;">
                                 {{ $cart->product->title }}</td>
                                 <td class="align-middle text-left" >

                                    @foreach ($cart->variation_details as $variation)
                                            <p><b>{{$variation->variation->name}}: </b> {{$variation->value}}</p>
                                    @endforeach

                                 </td>
                            <td class="align-middle">
                                @if (getUserCurrency())
                                Rs {{ $cart->product->pkr_price }}
                                 @else
                              $ {{ $cart->product->usd_price }}
                                  @endif
                              
                            </td>
                            <td class="align-middle">
                                <div class="input-group quantity mx-auto" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-minus" >
                                        <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control form-control-sm bg-secondary text-center" style="pointer-events:none"
                                     value="{{$cart->quantity}}">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-plus">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle CartTotal ">
                                @if (getUserCurrency())
                                Rs {{ $cart->product->pkr_price * $cart->quantity }}
                                 @else
                              $ {{ $cart->product->usd_price * $cart->quantity }}
                                  @endif
                            </td>
                            <td class="align-middle"><button class="btn btn-sm btn-primary cartDelete" data-id="{{$cart->id}}" >
                                <i class="fa fa-times"></i></button></td>
                        </tr>
                            
                        @endforeach
                       
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                {{-- <form class="mb-5" action=""> --}}
                    <div class="coupon-box border p-3 justify-content-between align-items-center  {{ session('applied_coupon') ? 'd-flex' : 'd-none'  }}" style="border: 2px dashed green; border-radius: 5px" >
                        <span>
                            Coupon Applied; <strong id="appliedCode" >{{ session('applied_coupon') ? session('applied_coupon')['code'] : ''  }}</strong>
                            <br>
                            <span id="appliedOff">({{ session('applied_coupon') ? session('applied_coupon')['discount'].'%' : ''  }} Off )</span>
                        </span>
                        <button class="btn btn-danger btn-sm removeCoupon" > <i class="fas fa-times" ></i> </button>
                    </div>
                    <div class="input-group mb-5 {{ session('applied_coupon') ? 'd-none' : ''  }} applyCouponField ">
                        <input type="text" class="form-control p-4" placeholder="Coupon Code" id="couponCodeInput" >
                        <div class="input-group-append">
                            <button class="btn btn-primary" id="applyCouponBtn" >Apply Coupon</button>
                        </div>
                    </div>
                {{-- </form> --}}
                <div class="card border-secondary mb-5 cart-summary {{ count($cartitems) == 0 ? 'd-none' : ''}}">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Cart Summary</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Subtotal</h6>
                            <h6 class="font-weight-medium cart-sub-total ">
                                @if (getUserCurrency())
                                Rs {{  $getSubTotal }}
                                 @else
                              $ {{  $getSubTotal }}
                                  @endif
                                
                            
                            </h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Shipping</h6>
                            <h6 class="font-weight-medium">
                                @if (getUserCurrency())
                                Rs
                                 @else
                              $ 
                                  @endif
                                  {{shippingAmount()}}
                            </h6>
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Total</h5>
                            <h5 class="font-weight-bold cart-total">
                                @if (getUserCurrency())
                                Rs {{ getCartTotal() }}
                                 @else
                              $ {{ getCartTotal() }}
                                  @endif                            
                            </h5>
                        </div>
                        <button class="btn btn-block btn-primary my-3 py-3">Proceed To Checkout</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->


@endsection
@push('script')
<script>
    $('document').ready(function(){

        // cart delete
        $('.cartDelete').click(function(){
            $('#page-loader').show();
            var obj = $(this);
        var id =  $(obj).data('id');

        $.ajax({
                url: "{{ route('cart.destory') }}",
                type: "DELETE",
                data: {
                    _token: "{{csrf_token()}}",
                    id: id
                },
                success: function(response){
            $('#page-loader').hide();

                    if(response.success ){
                        $(obj).parent().parent().remove();
                        // var count =  $('.cart-badge-count').text();
                        $('.cart-badge-count').text(response.count);
                        $('.cart-sub-total').text(response.sub_total);
                        $('.cart-total').text(response.total);
                        if(response.count == 0){
                            $('.cart-table').html(`
                             <tr >
                                <td colspan="6" > Cart is Empty ! <a href="{{ route('shop') }}">Shop</a></td>
                            </tr>
                            `);
                            $('.cart-summary').hide();
                        }
                        alert(response.msg);
                    }
                    else{
                        alert(response.msg);

                    }
                },
                error: function(error){
            $('#page-loader').hide();
                    alert(error.msg)
                }
            });

        });

        // cart increment & descrement
        $('.btn-plus, .btn-minus').click(function(){
            $('#page-loader').show();
           var obj =  $(this);
           var input = obj.closest('.quantity').find('input');
           var currentquantity = parseInt(input.val());
           var cartId = obj.closest('tr').data('id');

           $.ajax({
                url: "{{ route('cart.update') }}",
                type: "PUT",
                data: {
                    _token: "{{csrf_token()}}",
                    id: cartId,
                    quantity: currentquantity
                },
                success: function(response){
            $('#page-loader').hide();

                    if(response.success ){
                    
                        $('.cart-sub-total').text(response.sub_total);
                        $('.cart-total').text(response.total);
                       obj.closest('tr').find('.CartTotal').text(response.cartTotal);

                        alert(response.msg);
                    }
                    else{
                        if(obj.hasClass('btn-plus')){
                            currentquantity--;
                            input.val(currentquantity);
                        }
                        alert(response.msg);

                    }
                },
                error: function(error){
            $('#page-loader').hide();
                    alert(error.msg)
                }
            });
        });

        // apply coupon or remove code 
        $('#applyCouponBtn').click(function(){
            var couponCode = $("#couponCodeInput").val();
            if(!couponCode){
                alert("Please enter COupon Code!");
                return false;
            }
            $('#page-loader').show();
            $.ajax({
                url: "{{ route('cart.apply.coupon') }}",
                type: "POST",
                data: {
                    _token: "{{csrf_token()}}",
                    coupon_code : couponCode
                },
                success: function(response){
            $('#page-loader').hide();

                    if(response.success ){
                        $('.cart-sub-total').text(response.sub_total);
                        $('.cart-total').text(response.total);

                        $('.applyCouponField').addClass('d-none');
                        $('.coupon-box').addClass('d-flex');
                        $('.coupon-box').removeClass('d-none');

                        $('#appliedCode').html(response.code);
                        $('#appliedOff').html( "(" + response.discount + "% Off)");
                      
                    }
                    else{
                       
                        alert(response.msg);

                    }
                },
                error: function(error){
            $('#page-loader').hide();
                    alert(error.msg)
                }
            });

        });
        $('.removeCoupon').click(function(){
           
            $('#page-loader').show();

            $.ajax({
                url: "{{ route('cart.remove.coupon') }}",
                type: "DELETE",
                data: {
                    _token: "{{csrf_token()}}"
                },
                success: function(response){
            $('#page-loader').hide();

                    if(response.success ){
                        $('.cart-sub-total').text(response.sub_total);
                        $('.cart-total').text(response.total);
                      
                        $('.applyCouponField').removeClass('d-none');
                        $('.coupon-box').removeClass('d-flex');
                        $('.coupon-box').addClass('d-none');
                    }
                    else{
                       
                        alert(response.msg);

                    }
                },
                error: function(error){
            $('#page-loader').hide();
                    alert(error.msg)
                }
            });

        });
    });

</script>
@endpush