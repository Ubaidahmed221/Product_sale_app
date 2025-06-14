<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{ env('APP_NAME') }}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="{{ asset('img/favicon.ico') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }} " rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>
    <div id="page-loader"  style="display: none">
        <div class="spinner">

        </div>
    </div>
    <!-- Topbar Start -->
    @include('layouts.topbar-layout')
    <!-- Topbar End -->


    <!-- Navbar Start -->
    @include('layouts.navbar-layout')
    <!-- Navbar End -->

    @yield('content')

    <!-- Footer Start -->
   @include('layouts.footer-layout')
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('lib/easing/easing.min.js') }} "></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }} "></script>

    <!-- Contact Javascript File -->
    <script src="{{ asset('mail/jqBootstrapValidation.min.js') }} "></script>
    <script src="{{ asset('mail/contact.js') }} "></script>

    <!-- Template Javascript -->
    <script src="{{ asset('js/main.js') }} "></script>

    <script>
        $(document).ready(function(){
            $('.subscribe-form').submit(function(e){
                e.preventDefault();

                var formdata = $(this).serialize();
                var obj = $(this);
                $.ajax({
                    url:"{{route('subscribe')}}",
                    type: "POST",
                    data: formdata,
                    success: function(res){
                        alert(res.message);
                        if(res.success){
                            $(obj)[0].reset();

                        }

                    }
                })

            });
            // logout work
            $('.logout-btn').click(function(){

                $.ajax({
                    url:"{{route('logout')}}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res){
                        if(res.success){
                          location.reload();

                        }
                        else{
                            alert(res.message);
                        }

                    }
                });

            });
            $('.currencyupdate').click(function(){
                $('#page-loader').show();
                var currency = $(this).data('currency');

                $.ajax({
                    url: "{{ route('user.currency.update') }}",
                    type: "PUT",
                    data:{
                        _token: "{{ csrf_token() }}",
                        currency: currency
                    },
                    success: function(response){
                        if(response.success){
                            location.reload();
                        }
                        else{
                            alert(response.message);
                            $('#page-loader').hide();
                        }
                    }
                    
                });
            });
             // add to cart
        $(document).on("click",".add-to-cart",function(){
            let obj = $(this);
            $(obj).html(`<div class="spinner-border text-danger"></div>`);
            $(obj).prop('disabled',true);
         
            var productId = $(this).data('product-id');

            $.ajax({
                url: "{{ route('cart.store') }}",
                type: "POST",
                data: {
                    _token: "{{csrf_token()}}",
                    product_id: productId,
                    quantity: 1
                },
                success: function(response){
                    $(obj).html(`<i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart`);
                    $(obj).prop('disabled',false);

                    alert(response.msg);
                    if(response.success && response.cart_added){
                      var count =  $('.cart-badge-count').text();
                      $('.cart-badge-count').text(parseInt(count) + 1);
                    }
                },
                error: function(error){
                    $(obj).html(`<i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart`);
                    $(obj).prop('disabled',false);
                    alert(error.msg)
                }
            });


        });

        // wishlist  Add/remove
        $(document).on("click",".wishlist-btn",function(){
            var button = $(this);
            var productId = $(this).data('id');

            $.ajax({
                url: "{{ route('wishlist.toggle') }}",
                type: "POST",
                data: {
                    _token: "{{csrf_token()}}",
                    product_id: productId,
                },
                success: function(response){
                    alert(response.message);
                    if(response.success ){
                        var count = parseInt( $('.wishlist-badge-count').text());
                    if(response.status == 1){
                 
                  $('.wishlist-badge-count').text(count + 1);
                        button.find('i').removeClass('far').addClass('fas');
                    }else{
                       
                        $('.wishlist-badge-count').text(count - 1);
                        button.find('i').removeClass('fas').addClass('far');

                    }
                    }
                },
                error: function(error){
                   
                    alert("Something went Wrong..")
                }
            });


        });
        });
    </script>

    @stack('script')
</body>

</html>
