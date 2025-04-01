@extends('layouts.layout')

@section('content')
 <!-- Categories Start -->
 <div class="container-fluid pt-5">
    <div class="row px-xl-5 pb-3">
        @foreach (getCategoryWithProductCount() as $category )
        <div class="col-lg-4 col-md-6 pb-1">
            <div class="cat-item d-flex flex-column border mb-4" style="padding: 30px;">
                <p class="text-right">{{$category->products_count}} Products</p>
                <a href="" class="cat-img position-relative overflow-hidden mb-3">
                    @if ($category->image)

                    <img class="img-fluid" src="{{asset($category->image)}}" alt="">
                    @else
                    <img class="img-fluid" src="{{asset('categories/default.jpg')}}" alt="">

                    @endif
                </a>
                <h5 class="font-weight-semi-bold m-0">{{$category->name}}</h5>
            </div>
        </div>

        @endforeach

    </div>
</div>
<!-- Categories End -->
 <!-- Offer Start -->
 <div class="container-fluid offer pt-5">
    <div class="row px-xl-5">
        @foreach (getOffers() as $offer)


        <div class="col-md-6 pb-4">
            <div class="position-relative bg-secondary text-center text-md-right text-white mb-2 py-5 px-5">
                <img src="{{asset($offer->image)}}" alt="">
                <div class="position-relative" style="z-index: 1;">
                    <h5 class="text-uppercase text-primary mb-3">{{$offer->offer_heading}}</h5>
                    <h1 class="mb-4 font-weight-semi-bold">{{$offer->heading}}</h1>
                    <a href="{{$offer->btn_link}}" class="btn btn-outline-primary py-md-2 px-md-3">{{$offer->btn_text}}</a>
                </div>
            </div>
        </div>
        @endforeach

    </div>
</div>
<!-- Offer End -->
<!-- Subscribe Start -->
<div class="container-fluid bg-secondary my-5">
    <div class="row justify-content-md-center py-5 px-xl-5">
        <div class="col-md-6 col-12 py-5">
            <div class="text-center mb-2 pb-2">
                <h2 class="section-title px-5 mb-3"><span class="bg-secondary px-2">Stay Updated</span></h2>
                <p>Subscribe to get more update.</p>
            </div>
            <form action="" class="subscribe-form">
                @csrf
                <div class="input-group">
                    <input type="text" name="email" class="form-control border-white p-4" placeholder="Email Goes Here">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary px-4">Subscribe</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Subscribe End -->

 <!--Just Arrived  Products Start -->
 <div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Just Arrived</span></h2>
    </div>
    <div class="row px-xl-5 pb-3">
        @foreach (getJustArrivedProducts() as $product)
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="card product-item border-0 mb-4">
                <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                    <img class="img-fluid w-100" src="{{ $product->firstImage->path }}" alt="">
                    {{-- <img class="img-fluid w-100" src="img/product-1.jpg" alt=""> --}}
                </div>
                <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                    <h6 class="text-truncate mb-3">{{ $product->title }}</h6>
                    <div class="d-flex justify-content-center">
                        @if (getUserCurrency())
                            
                        <h6>Rs {{ number_format($product->pkr_price,2) }}</h6>
                        <h6 class="text-muted ml-2"><del>Rs {{ number_format($product->pkr_price,2) }}</del></h6>

                        @else
                        
                        <h6>${{ number_format($product->usd_price,2) }}</h6>
                        <h6 class="text-muted ml-2"><del>${{ number_format($product->usd_price,2) }}</del></h6>
                        @endif
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between bg-light border">
                    <a href="{{ route('product.detail',\Crypt::encrypt($product->id)) }}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                    <a class="btn btn-sm text-dark p-0 add-to-cart " data-product-id="{{$product->id}}" ><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<!--Just Arrived Products End -->

@endsection
@push('script')

<script>
    $(document).ready(function(){
      
       
    })
</script>

@endpush
