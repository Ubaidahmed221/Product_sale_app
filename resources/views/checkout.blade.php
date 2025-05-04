@extends('layouts.layout')

@section('content')

    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Checkout</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="{{route('index')}}">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Checkout</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Checkout Start -->
    <div class="container-fluid pt-5">
        <form id="place-order-form" >
            @csrf
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <div class="mb-4">
                    <h4 class="font-weight-semi-bold mb-4">Billing Address</h4>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>First Name</label>
                            <input class="form-control" name="first_name" value="{{old('first_name', $billing->first_name ?? '')}}" type="text" placeholder="John">
                            <small class="text-danger error-first_name" ></small>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Last Name</label>
                            <input class="form-control" name="last_name" value="{{old('last_name', $billing->last_name ?? '')}}" type="text" placeholder="Doe">
                            <small class="text-danger error-last_name" ></small>
                      
                        </div>
                        <div class="col-md-6 form-group">
                            <label>E-mail</label>
                            <input class="form-control" name="email" value="{{old('email', $billing->email ?? '')}}" type="text" placeholder="example@email.com">
                            <small class="text-danger error-email" ></small>

                        </div>
                        <div class="col-md-6 form-group">
                            <label>Mobile No</label>
                            <input class="form-control" name="phone" value="{{old('phone', $billing->phone ?? '')}}" type="text" placeholder="+123 456 789">
                            <small class="text-danger error-phone" ></small>

                        </div>
                        <div class="col-md-6 form-group">
                            <label>Address Line 1</label>
                            <input class="form-control" name="address_1" value="{{old('address_1', $billing->address_1 ?? '')}}" type="text" placeholder="123 Street">
                            <small class="text-danger error-address_1" ></small>

                        </div>
                        <div class="col-md-6 form-group">
                            <label>Address Line 2</label>
                            <input class="form-control" name="address_2" value="{{old('address_2', $billing->address_2 ?? '')}}" type="text" placeholder="123 Street">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Country</label>
                            <select name="country" id="billing_country" class="custom-select"  >
                                <option value="">Select Country</option>
                                @foreach (countries() as $country )
                                    <option value="{{$country->iso2}}"  {{old('country', $billing->country ?? '') == $country->iso2 ? 'selected' : '' }} >{{$country->name}}</option>
                                @endforeach
                              </select>
                              <small class="text-danger error-country" ></small>

                        </div>
                        <div class="col-md-6 form-group">
                            <label>City</label>
                            <input class="form-control" name="city" value="{{old('city', $billing->city ?? '')}}" type="text" placeholder="New York">
                            <small class="text-danger error-city" ></small>
                       
                        </div>
                        <div class="col-md-6 form-group">
                            <label>State</label>
                            <select class="custom-select" id="billing_state" name="state" >
                                <option value="">Select State</option>
                            </select>
                            <small class="text-danger error-state" ></small>

                        </div>
                        <div class="col-md-6 form-group">
                            <label>ZIP Code</label>
                            <input class="form-control" name="zip" value="{{old('zip', $billing->zip ?? '')}}" type="text" placeholder="123">
                            <small class="text-danger error-zip" ></small>
                       
                        </div>
                        
                        <div class="col-md-12 form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="shipto" name="ship_to_different" {{ old('ship_to_different') ? 'checked' : '' }} >
                                <label class="custom-control-label" for="shipto"  data-toggle="collapse" data-target="#shipping-address">Ship to different address</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="collapse mb-4" id="shipping-address">
                    <p><input type="checkbox" id="same_address">same as billing address.</p>
                    <h4 class="font-weight-semi-bold mb-4">Shipping Address</h4>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>First Name</label>
                            <input class="form-control"  name="shipping_first_name" value="{{old('shipping_first_name', $shipping->first_name ?? '')}}" type="text" placeholder="John">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Last Name</label>
                            <input class="form-control"  name="shipping_last_name" value="{{old('shipping_last_name', $shipping->last_name ?? '')}}"  type="text" placeholder="Doe">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>E-mail</label>
                            <input class="form-control"  name="shipping_email" value="{{old('shipping_email', $shipping->email ?? '')}}"  type="text" placeholder="example@email.com">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Mobile No</label>
                            <input class="form-control"  name="shipping_phone" value="{{old('shipping_phone', $shipping->phone ?? '')}}"  type="text" placeholder="+123 456 789">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Address Line 1</label>
                            <input class="form-control"  name="shipping_address_1" value="{{old('shipping_address_1', $shipping->address_1 ?? '')}}"  type="text" placeholder="123 Street">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Address Line 2</label>
                            <input class="form-control" name="shipping_address_2" value="{{old('shipping_address_2', $shipping->address_2 ?? '')}}" type="text" placeholder="123 Street">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Country</label>
                            <select name="shipping_country" id="shipping_country" class="custom-select"  >
                                <option value="">Select Country</option>
                                @foreach (countries() as $country )
                                    <option value="{{$country->iso2}}" {{old('shipping_country', $shipping->country ?? '') == $country->iso2 ? 'selected' : '' }} >{{$country->name}}</option>
                                @endforeach
                              </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>City</label>
                            <input class="form-control" name="shipping_city" value="{{old('shipping_city', $shipping->city ?? '')}}" type="text" placeholder="New York">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>State</label>
                            <select class="custom-select" id="shipping_state" name="shipping_state" >
                                <option >Select State</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">   
                            <label>ZIP Code</label>
                            <input class="form-control" name="shipping_zip" value="{{old('shipping_zip', $shipping->zip ?? '')}}" type="text" placeholder="123">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Order Total</h4>
                    </div>
                    <div class="card-body">
                        <h5 class="font-weight-medium mb-3">Products</h5>
                        @foreach ($cartitems as $cart)

                        <div class="d-flex justify-content-between">
                            <p> {{ $cart->product->title }} - {{$cart->quantity}} </p>
                            <p>
                                @if (getUserCurrency())
                                Rs {{ number_format($cart->product->pkr_price,2) }}
                                 @else
                              $ {{ number_format($cart->product->usd_price,2) }}
                                  @endif
                            </p>
                        </div>
                     @endforeach
                        <hr class="mt-0">
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Subtotal</h6>
                            <h6 class="font-weight-medium">
                                @if (getUserCurrency())
                                Rs {{  getCartSubTotal() }}
                                 @else
                              $ {{  getCartSubTotal() }}
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
                            <h5 class="font-weight-bold">
                                @if (getUserCurrency())
                                Rs {{ getCartTotal() }}
                                 @else
                              $ {{ getCartTotal() }}
                                  @endif  
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Payment</h4>
                    </div>
                    <div class="card-body">
                        @foreach (getPaymentGateways() as $paymenyName)
                            
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" value="{{ $paymenyName->id }}" name="payment" id="{{ strtolower($paymenyName->name) }}">
                                <label class="custom-control-label" for="{{ strtolower($paymenyName->name) }}">{{ $paymenyName->name }}</label>
                            </div>
                        </div>
                        @endforeach 
                        <small class="text-danger error-payment" ></small>

                      
                       
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <button type="submit" class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">Place Order</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    </div>
    <!-- Checkout End -->


@endsection
@push('script')
<script>
    $(document).ready(function(){

        let initialCountry = '{{ old("country", $billing->country ?? "" ) }}'
        let initialState = '{{ old("state", $billing->state ?? "" ) }}'

        if(initialCountry){
            $("#billing_country").val(initialCountry);
            loadBillingStates(initialCountry,initialState )
        }

         // country & state
         $('#billing_country').change(function(){
          var countryCode = $(this).val();

          loadBillingStates(countryCode);
        //   $.ajax({
        //         url: "{{ route('states') }}",
        //         type: "POST",
        //         data: {
        //             _token: "{{csrf_token()}}",
        //             countryCode: countryCode
        //         },
        //         success: function(response){
        //             if(response.success){
        //               let data = response.data;
        //               let html = '<option value="" >Select State</option>';
        //               data.forEach(element => {
        //                  html += `<option value="`+element.state_code+`" >`+element.name+`</option>`;

        //               });
        //               $('#billing_state').html(html);
        //             }else{
        //               alert(response.msg);
        //             }
        //         },
        //         error: function(error){
        //            alert(error.message);
        //         }
        //     });
        });

        function loadBillingStates(country_code,selectedState = ''){
            if(!country_code){
                return;
            }
            $.ajax({
                url: "{{ route('states') }}",
                type: "POST",
                data: {
                    _token: "{{csrf_token()}}",
                    countryCode: country_code
                },
                success: function(response){
                    if(response.success){
                      let data = response.data;
                      let html = '<option value="" >Select State</option>';
                      data.forEach(element => {
                      let selected =  element.state_code === selectedState ? 'selected' : '';
                         html += `<option value="`+element.state_code+`" ${selected} >`+element.name+`</option>`;

                      });
                      $('#billing_state').html(html);
                    }else{
                      alert(response.msg);
                    }
                },
                error: function(error){
                   alert(error.message);
                }
            });
        }
         // shipping country & state

         let initialShippingCountry = '{{ old("shipping_country", $shipping->country ?? "" ) }}'
        let initialShippingState = '{{ old("shipping_state", $shipping->state ?? "" ) }}'

        if(initialShippingCountry){
            $("#shipping_country").val(initialShippingCountry);
            loadShippingStates(initialShippingCountry,initialShippingState )
        }

         // country & state
         $('#shipping_country').change(function(){
          var countryCode = $(this).val();

          loadShippingStates(countryCode);
      
        });

        function loadShippingStates(country_code,selectedState = ''){
            if(!country_code){
                return;
            }
            $.ajax({
                url: "{{ route('states') }}",
                type: "POST",
                data: {
                    _token: "{{csrf_token()}}",
                    countryCode: country_code
                },
                success: function(response){
                    if(response.success){
                      let data = response.data;
                      let html = '<option value="" >Select State</option>';
                      data.forEach(element => {
                      let selected =  element.state_code === selectedState ? 'selected' : '';
                         html += `<option value="`+element.state_code+`" ${selected} >`+element.name+`</option>`;

                      });
                      $('#shipping_state').html(html);
                    }else{
                      alert(response.msg);
                    }
                },
                error: function(error){
                   alert(error.message);
                }
            });
        }

        $("#same_address").change(function(){
            if($(this).is(':checked')){
                $('[name="shipping_first_name"]').val($('[name="first_name"]').val());
                $('[name="shipping_last_name"]').val($('[name="last_name"]').val());
                $('[name="shipping_email"]').val($('[name="email"]').val());
                $('[name="shipping_phone"]').val($('[name="phone"]').val());
                $('[name="shipping_address_1"]').val($('[name="address_1"]').val());
                $('[name="shipping_address_2"]').val($('[name="address_2"]').val());
             
                $('[name="shipping_city"]').val($('[name="city"]').val());
                $('[name="shipping_zip"]').val($('[name="zip"]').val());


              let billing_country =  $('[name="country"]').val();
              $('[name="shipping_country"]').val(billing_country).trigger('change');

              setTimeout(() => {
                let billingState =  $('[name="state"]').val();
                $('[name="shipping_state"]').val(billingState); 
              }, 500);


            }
            else{
                $('[name="shipping_first_name"]').val('{{old('shipping_first_name', $shipping->first_name ?? '')}}');
                $('[name="shipping_last_name"]').val('{{old('shipping_last_name', $shipping->last_name ?? '')}}');
                $('[name="shipping_email"]').val('{{old('shipping_email', $shipping->email ?? '')}}');
                $('[name="shipping_phone"]').val('{{old('shipping_phone', $shipping->phone ?? '')}}');
                $('[name="shipping_address_1"]').val('{{old('shipping_address_1', $shipping->address_1 ?? '')}}');
                $('[name="shipping_address_2"]').val('{{old('shipping_address_2', $shipping->address_2 ?? '')}}');
             
                $('[name="shipping_city"]').val('{{old('shipping_city', $shipping->city ?? '')}}');
                $('[name="shipping_zip"]').val('{{old('shipping_zip', $shipping->zip ?? '')}}');
                $('[name="shipping_country"]').val('{{old('shipping_country', $shipping->country ?? '')}}').trigger('change');


              setTimeout(() => {
                $('[name="shipping_state"]').val('{{old('shipping_state', $shipping->state ?? '')}}');

              }, 500);
            }
        });

        // place Order 
        $("#place-order-form").submit(function(e){
            e.preventDefault();
            $("small.text-danger").text("");

            var formData = $(this).serialize();
            $.ajax({
                url: "{{ route('place.order') }}",
                type: "POST",
                data: formData,
                success: function(response){
                    if(response.success){
                        alert(response.message);
                        location.reload();
                    }else{
                      alert(response.message || "something went wrong");
                    }
                },
                error: function(xhr){
                    if(xhr.status === 422){
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(field, messages) {
                            $(".error-" + field).text(messages[0]);
                        });
                    }
                    else{
                        alert("Unexprected error occured. please try again.")
                    }
                }
            });



        }); 
    });

</script>
@endpush