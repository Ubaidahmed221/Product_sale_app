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

@endsection
