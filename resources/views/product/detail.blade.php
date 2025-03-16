@extends('layouts.layout')

@section('content')
       <!-- Page Header Start -->
       <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Product  Detail</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="{{ route('index') }}">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Product Detail</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

      <!-- Shop Detail Start -->
      <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <div class="col-lg-5 pb-5">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner border">
                        @foreach ($product->images as $image)
                        <div class="carousel-item {{ $loop->first ?  'active' : ''}}">
                            <img class="w-100 h-100" src="{{ asset($image->path) }}" alt="Image">
                        </div>

                        @endforeach

                    </div>
                    <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                        <i class="fa fa-2x fa-angle-left text-dark"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                        <i class="fa fa-2x fa-angle-right text-dark"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-7 pb-5">
                <h3 class="font-weight-semi-bold">{{ $product->title }}</h3>
                {{-- <h3 class="font-weight-semi-bold">{{ $product->review_avg_rating }}</h3> --}}
                <div class="d-flex mb-3">
                    <div class="text-primary mr-2">
                        @php
                        $avgrating = round($product->review_avg_rating * 2) / 2;
                        $fullstar =  floor($avgrating);
                        $halfstar = ( $avgrating - $fullstar) >= 0.5? 1: 0;
                        $emptystar = 5 - ($fullstar + $halfstar);
                        @endphp

                        {{-- full star --}}
                        @for ($i = 0; $i < $fullstar; $i++)
                        <small class="fas fa-star"></small>
                        @endfor

                        @if ($halfstar)
                        <small class="fas fa-star-half-alt"></small>
                        @endif

                        {{-- Empty star --}}
                        @for ($i = 0; $i < $emptystar; $i++)
                        <small class="far fa-star"></small>
                        @endfor
                </div>
<small class="pt-1">({{ $product->review_count }} Reviews)</small>
                </div>
                <h3 class="font-weight-semi-bold mb-4">${{ $product->usd_price }}</h3>
                <p class="mb-4">{{ $product->description }}</p>

                @foreach ($variations as $variationName => $values)
                <div class="d-flex mb-3">
                    <p class="text-dark font-weight-medium mb-0 mr-3">{{ ucfirst($variationName) }} {{ $values[0]['value']  }}:</p>
                    @foreach ($values as $key => $variation)
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input product-variations" id="{{ strtolower($variationName) }} - {{ $variation['id'] }}"
                             name="{{ strtolower($variationName) }}" value="{{ $variation['id'] }}" >
                            <label class="custom-control-label" for="{{ strtolower($variationName) }} - {{  $variation['id'] }}">{{ $variation['value'] }}</label>
                        </div>
                        @endforeach

                </div>

                @endforeach

                <div class="d-flex align-items-center mb-4 pt-2">
                    <div class="input-group quantity mr-3" style="width: 130px;">
                        <div class="input-group-btn">
                            <button class="btn btn-primary btn-minus" >
                            <i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <input type="text" class="form-control bg-secondary text-center quantity-input" value="1">
                        <div class="input-group-btn">
                            <button class="btn btn-primary btn-plus">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    @if (auth()->check())

                    <button class="btn btn-primary px-3 add-to-cart "  >
                        <i class="fa fa-shopping-cart mr-1"></i> Add To Cart
                    </button>
                    @else
                    <span class="text-danger mt-3"><a href="{{ route('loginView') }}"> Login </a> to add to cart. </span>
                    @endif
                </div>
                <div class="d-flex pt-2">
                    <p class="text-dark font-weight-medium mb-0 mr-2">Share on:</p>
                    <div class="d-inline-flex">

                        {!! Share::page(url()->current(), $product->title)->facebook()
                        ->twitter()
                        ->whatsapp()
                        ->linkedin()
                        ->pinterest($product->images->first()->path)

                        !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                    <a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1">Description</a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-2">Information</a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-3">Reviews ({{ $product->review_count }} )</a>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-pane-1">
                        <h4 class="mb-3">Product Description</h4>
                        <p>{{ $product->description }}</p>
                    </div>
                    <div class="tab-pane fade" id="tab-pane-2">
                        <h4 class="mb-3">Additional Information</h4>
                        <p>{{ $product->add_information }}</p>
                    </div>
                    <div class="tab-pane fade" id="tab-pane-3">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="mb-4">{{ $product->review_count }} review for "{{ $product->title }}"</h4>
                                @foreach ($product->review->take(5) as $review)

                                <div class="media mb-4">
                                    <img src="{{ $reiew->user->image ?? asset('img/user.jpg') }}" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
                                    <div class="media-body">
                                        <h6>{{ $review->user->name }}</i></small></h6>

                                         @php
                        $avgrating = round($review->rating);
                        $emptystar = 5 - $avgrating;
                        @endphp

                        {{-- full star --}}
                        @for ($i = 0; $i < $avgrating; $i++)
                        <small class="fas fa-star"></small>
                        @endfor
                        {{-- Empty star --}}
                        @for ($i = 0; $i < $emptystar; $i++)
                        <small class="far fa-star"></small>
                        @endfor
                        <p>{{$review->review}}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @if (auth()->check())

                            <div class="col-md-6">
                                <h4 class="mb-4">Leave a review</h4>
                                <small>Your email address will not be published. Required fields are marked *</small>
                                <div class="d-flex my-3">
                                    <p class="mb-0 mr-2">Your Rating * :</p>
                                    <div class="text-primary ratings">
                                        <i class="far fa-star" data-value="1" ></i>
                                        <i class="far fa-star" data-value="2" ></i>
                                        <i class="far fa-star" data-value="3" ></i>
                                        <i class="far fa-star" data-value="4" ></i>
                                        <i class="far fa-star" data-value="5" ></i>
                                    </div>
                                </div>
                                <form id="review-form" >
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="rating" id="rating-value" >
                                    <div class="form-group">
                                        <label for="message">Your Review *</label>
                                        <textarea id="message" name="review" cols="30" rows="5" class="form-control" required ></textarea>
                                    </div>

                                    <div class="form-group mb-0">
                                        <button type="submit" class="btn btn-primary px-3 reviewBtn" >Leave Your Review</button>

                                    </div>
                                </form>
                            </div>
                            @else
                            <p>You Must <a href="{{ route('loginView') }}">Login in</a> to leave a review..</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->


@endsection

@push('script')

<script>
    $(document).ready(function(){
        $(".ratings i").click(function(){

            console.log($(this).data('value'));

           let rating = $(this).data('value');
           console.log(rating);
           $("#rating-value").val(rating);

           $(".ratings i").removeClass("fas").addClass("far");

           $(".ratings i").each(function(index){
            if(index < rating){
                $(this).removeClass("far").addClass("fas");
            }
           })
        });

        $('#review-form').submit(function(e){
            e.preventDefault();

            $('reviewBtn').html(`<div class="spinner-border" ></div>`);
            $('.reviewBtn').prop('disabled', true);

            var formData = $(this).serialize();

            $.ajax({
                url: "{{ route('review.store') }}",
                type: "POST",
                data: formData,
                success: function(res){
                    $('reviewBtn').html(`Leave Your Review`);
                    $('.reviewBtn').prop('disabled', false);
                    alert(res.message);
                    if(res.success){
                        location.reload();
                    }

                },
                error: function(err){
                    alert(err.responseText);
                }
            });
        });

        // add to cart
        $('.add-to-cart').click(function(){
            let obj = $(this);
            $(obj).html(`<div class="spinner-border"></div>`);
            $(obj).prop('disabled',true);
            var variationValues = [];
            var productId = "{{$product->id}}";
            var quantity = $('.quantity-input').val();
            if(quantity < 1){
                alert('Minimum quatity should be atleast 1.');
            }

            $('.product-variations:checked').each(function(){
                variationValues.push($(this).val());
            });

            $.ajax({
                url: "{{ route('cart.store') }}",
                type: "POST",
                data: {
                    _token: "{{csrf_token()}}",
                    product_id: productId,
                    quantity: quantity,
                    variation_values: variationValues
                },
                success: function(response){
                    $(obj).html(`<i class="fa fa-shopping-cart mr-1"></i> Add To Cart`);
                    $(obj).prop('disabled',false);

                    alert(response.msg);
                    if(response.success && response.cart_added){
                      var count =  $('.cart-badge-count').text();
                      $('.cart-badge-count').text(parseInt(count) + 1);
                    }
                },
                error: function(error){
                    $(obj).html(`<i class="fa fa-shopping-cart mr-1"></i> Add To Cart`);
                    $(obj).prop('disabled',false);
                    alert(error.msg)
                }
            });


        })
    })
</script>

@endpush
