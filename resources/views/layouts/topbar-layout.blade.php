@php
   $facebooklink = getAppData('facebook');
   $twitterlink = getAppData('twitter');
   $linkedlink = getAppData('linkedin');
   $instagramlink = getAppData('instagram');
   $youtubelink = getAppData('youtube');
@endphp
<div class="container-fluid">
    <div class="row bg-secondary py-2 px-xl-5">
        <div class="col-lg-6 d-none d-lg-block">
            <div class="d-inline-flex align-items-center">
                <a class="text-dark" href="">FAQs</a>
                <span class="text-muted px-2">|</span>
                <a class="text-dark" href="">Help</a>
                <span class="text-muted px-2">|</span>
                <a class="text-dark" href="">Support</a>
            </div>
        </div>
        <div class="col-lg-6 text-center text-lg-right">
            <div class="d-inline-flex align-items-center">
                @if (!empty($facebooklink))
                <a class="text-dark px-2" href="{{ $facebooklink }}">
                    <i class="fab fa-facebook-f"></i>
                </a>

                @endif
                @if (!empty($twitterlink))
                <a class="text-dark px-2" href="{{ $twitterlink }}">
                    <i class="fab fa-twitter"></i>
                </a>
                @endif
                @if (!empty($linkedlink))
                <a class="text-dark px-2" href="{{ $linkedlink }}">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                @endif
                @if (!empty($instagramlink))
                <a class="text-dark px-2" href="{{ $instagramlink  }}">
                    <i class="fab fa-instagram"></i>
                </a>
                @endif
                @if (!empty($youtubelink))
                <a class="text-dark pl-2" href="{{ $youtubelink }}">
                    <i class="fab fa-youtube"></i>
                </a>
                @endif
            </div>
        </div>
    </div>
    <div class="row align-items-center py-3 px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
            <a href="" class="text-decoration-none">
                <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">{{ getAppData('logo_first_text') }}</span>{{ getAppData('logo_second_text') }}</h1>
            </a>
        </div>
        <div class="col-lg-6 col-6 text-center">
            <h2>{{ getAppData('heading') }}</h2>
        </div>
        <div class="col-lg-3 col-6 text-right">
            <a href="{{route('wishlist')}}" class="btn border">
                <i class="fas fa-heart text-primary"></i>
                <span class="badge wishlist-badge-count">{{ getWishlistCount() }}</span>
            </a>
            <a href="{{route('cart')}}" class="btn border">
                <i class="fas fa-shopping-cart text-primary"></i>
                <span class="badge cart-badge-count">{{ getCartCount() }}</span>
            </a>
        </div>
    </div>
</div>
