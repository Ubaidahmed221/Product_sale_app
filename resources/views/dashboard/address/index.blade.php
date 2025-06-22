@extends('dashboard.layout')

@section('dashboard-content')
  <form action="" id="address-form" >
    @csrf
    <div class="row">
        <div class="col-md-6">
            <h4>Billing Address</h4>
                @php
             $billing =   $addresses->where('type','billing')->first();
            @endphp
                        <div class="form-group">
                            <label>First Name</label>
                            <input class="form-control" name="first_name" value="{{old('first_name', $billing->first_name ?? '')}}" type="text" placeholder="John">
                            <small class="text-danger error-first_name" ></small>
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input class="form-control" name="last_name" value="{{old('last_name', $billing->last_name ?? '')}}" type="text" placeholder="Doe">
                            <small class="text-danger error-last_name" ></small>
                      
                        </div>
                        <div class="form-group">
                            <label>E-mail</label>
                            <input class="form-control" name="email" value="{{old('email', $billing->email ?? '')}}" type="text" placeholder="example@email.com">
                            <small class="text-danger error-email" ></small>

                        </div>
                        <div class="form-group">
                            <label>Mobile No</label>
                            <input class="form-control" name="phone" value="{{old('phone', $billing->phone ?? '')}}" type="text" placeholder="+123 456 789">
                            <small class="text-danger error-phone" ></small>

                        </div>
                        <div class="form-group">
                            <label>Address Line 1</label>
                            <input class="form-control" name="address_1" value="{{old('address_1', $billing->address_1 ?? '')}}" type="text" placeholder="123 Street">
                            <small class="text-danger error-address_1" ></small>

                        </div>
                        <div class="form-group">
                            <label>Address Line 2</label>
                            <input class="form-control" name="address_2" value="{{old('address_2', $billing->address_2 ?? '')}}" type="text" placeholder="123 Street">
                        </div>
                        <div class="row">

                       
                        <div class=" col-md-6 form-group">
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
                            <label>State</label>
                            <select class="custom-select" id="billing_state" name="state" >
                                <option value="">Select State</option>
                            </select>
                            <small class="text-danger error-state" ></small>

                        </div>
                         </div>
                          <div class="form-group">
                            <label>City</label>
                            <input class="form-control" name="city" value="{{old('city', $billing->city ?? '')}}" type="text" placeholder="New York">
                            <small class="text-danger error-city" ></small>
                       
                        </div>
                        <div class="form-group">
                            <label>ZIP Code</label>
                            <input class="form-control" name="zip" value="{{old('zip', $billing->zip ?? '')}}" type="text" placeholder="123">
                            <small class="text-danger error-zip" ></small>
                       
                        </div>
                        
                        
                    </div>
       
        <div class="col-md-6">
            <h4>Shipping Address</h4>
            @php
             $shipping =   $addresses->where('type','shipping')->first();
            @endphp
            
                        <div class="form-group">
                            <label>First Name</label>
                            <input class="form-control"  name="shipping_first_name" value="{{old('shipping_first_name', $shipping->first_name ?? '')}}" type="text" placeholder="John">
                            <small class="text-danger error-shipping_first_name" ></small>

                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input class="form-control"  name="shipping_last_name" value="{{old('shipping_last_name', $shipping->last_name ?? '')}}"  type="text" placeholder="Doe">
                                                    <small class="text-danger error-shipping_last_name" ></small>

                        </div>
                        <div class="form-group">
                            <label>E-mail</label>
                            <input class="form-control"  name="shipping_email" value="{{old('shipping_email', $shipping->email ?? '')}}"  type="text" placeholder="example@email.com">
                                                  <small class="text-danger error-shipping_email" ></small>

                        </div>
                        <div class="form-group">
                            <label>Mobile No</label>
                            <input class="form-control"  name="shipping_phone" value="{{old('shipping_phone', $shipping->phone ?? '')}}"  type="text" placeholder="+123 456 789">
                            <small class="text-danger error-shipping_phone" ></small>
                     
                        </div>
                        <div class="form-group">
                            <label>Address Line 1</label>
                            <input class="form-control"  name="shipping_address_1" value="{{old('shipping_address_1', $shipping->address_1 ?? '')}}"  type="text" placeholder="123 Street">
                            <small class="text-danger error-shipping_address_1" ></small>
                            
                        </div>
                        <div class="form-group">
                            <label>Address Line 2</label>
                            <input class="form-control" name="shipping_address_2" value="{{old('shipping_address_2', $shipping->address_2 ?? '')}}" type="text" placeholder="123 Street">
                            <small class="text-danger error-shipping_address_2" ></small>
                       
                        </div>
                        <div class="row">

                        <div class=" col-md-6 form-group">
                            <label>Country</label>
                            <select name="shipping_country" id="shipping_country" class="custom-select"  >
                                <option value="">Select Country</option>
                                @foreach (countries() as $country )
                                    <option value="{{$country->iso2}}" {{old('shipping_country', $shipping->country ?? '') == $country->iso2 ? 'selected' : '' }} >{{$country->name}}</option>
                                @endforeach
                              </select>
                              <small class="text-danger error-shipping_country" ></small>

                        </div>
                     
                        <div class="col-md-6 form-group">
                            <label>State</label>
                            <select class="custom-select" id="shipping_state" name="shipping_state" >
                                <option >Select State</option>
                            </select>
                            <small class="text-danger error-shipping_state" ></small>

                        </div>
                  </div>
                           <div class="form-group">
                            <label>City</label>
                            <input class="form-control" name="shipping_city" value="{{old('shipping_city', $shipping->city ?? '')}}" type="text" placeholder="New York">
                            <small class="text-danger error-shipping_city" ></small>
                     
                        </div>
                        <div class="form-group">   
                            <label>ZIP Code</label>
                            <input class="form-control" name="shipping_zip" value="{{old('shipping_zip', $shipping->zip ?? '')}}" type="text" placeholder="123">
                            <small class="text-danger error-shipping_zip" ></small>
                        
                        </div>
                  
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary" >Update Address</button>

        </div>
    </div>
</form>
@endsection

@push('child-script')
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

        // place Order 
        $("#address-form").submit(function(e){
            e.preventDefault();
            $('#page-loader').show();
            $("small.text-danger").text("");

            var formData = $(this).serialize();
            $.ajax({
                url: "{{ route('user.update.address') }}",
                type: "POST",
                data: formData,
                success: function(response){
            $('#page-loader').hide();

                    if(response.success ){

                        alert(response.message);
                    location.reload();
                    }
                   
                    else{
                      alert(response.message || "something went wrong");
                    }
                },
                error: function(xhr){
                     $('#page-loader').hide();
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