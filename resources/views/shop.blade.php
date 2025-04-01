@extends('layouts.layout')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Our Shop</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="{{route('index')}}">Home</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Shop</p>
        </div>
    </div>
</div>
<!-- Page Header End -->

  <!-- Shop Start -->
  <div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <!-- Shop Sidebar Start -->
        <div class="col-lg-3 col-md-12">
            <!-- Price Start -->
            <div class="border-bottom mb-4 pb-4">
                <h5 class="font-weight-semi-bold mb-4">Filter by price</h5>
                <form>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" checked id="price-all" name="price_all" >
                        <label class="custom-control-label" for="price-all">All Price</label>
                        <span class="badge border font-weight-normal">{{ totalProductCount() }}</span>
                    </div>
                    @foreach (getPriceFilter() as $key => $range)
                        
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input price-filter" id="price-{{$key}}"
                        name="price[]" value="{{$range['min_price']}}-{{$range['max_price']}}" >
                        <label class="custom-control-label" for="price-{{$key}}">
                            @if (getUserCurrency())
                            Rs  {{$range['min_price']}} -  Rs {{$range['max_price']}}
                            @else
                            $ {{$range['min_price']}} - $ {{$range['max_price']}}
                            @endif
                          
                        </label>
                        <span class="badge border font-weight-normal">{{$range->product_count}}</span>
                    </div>
                    @endforeach
                  
                </form>
            </div>
            <!-- Price End -->
                @foreach (getVariationFilter() as $variation)
               
                <div class="border-bottom mb-4 pb-4">
                    <h5 class="font-weight-semi-bold mb-4">Filter by {{ ucfirst($variation->name) }}</h5>
                    <form>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" checked id="{{ strtolower($variation->name) }}-all">
                            <label class="custom-control-label" for="price-all">All {{ ucfirst($variation->name) }}</label>
                            <span class="badge border font-weight-normal">{{getVariationProductCount($variation->id)}}</span>
                        </div>
                        @foreach ($variation->values as $key => $value )
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="{{ strtolower($variation->name) }}-{{$key}}"
                            name="{{strtolower($variation->name)}}[]" value="{{$value->value}}" >
                            <label class="custom-control-label" for="{{ strtolower($variation->name) }}-{{$key}}">{{ ucfirst($value->value) }}</label>
                            <span class="badge border font-weight-normal">{{ $value->product_count }}</span>
                        </div>
                            
                        @endforeach
                       
                    </form>
                </div>
               
                    
                @endforeach

         
        </div>
        <!-- Shop Sidebar End -->


        <!-- Shop Product Start -->
        <div class="col-lg-9 col-md-12" id="outer-column">
            <div class="row pb-3" id="product-list" >
                <div class="col-12 pb-1">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <form action="">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search by name">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-transparent text-primary">
                                        <i class="fa fa-search"></i>
                                    </span>
                                </div>
                            </div>
                        </form>
                        <div class="dropdown ml-4">
                            <button class="btn border dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                        Sort by
                                    </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId">
                                <a class="dropdown-item" href="#">Latest</a>
                                <a class="dropdown-item" href="#">Popularity</a>
                                <a class="dropdown-item" href="#">Best Rating</a>
                            </div>
                        </div>
                    </div>
                </div>
               
                
            </div>
           
        </div>
        <!-- Shop Product End -->
    </div>
</div>
<!-- Shop End -->

@endsection
@push('script')

<script>
    $(document).ready(function(){

        $("#price-all").on("change", function(){
           if($(this).is(":checked")){
            $(".price-filter").prop("checked",false);
           }
           fetchfilteredProducts();
        });
        $(".price-filter").on("change", function(){
           if($(".price-filter:checked").length > 0){
            $("#price-all").prop("checked",false);
           }
           else{
            $("#price-all").prop("checked",true);

           }
           fetchfilteredProducts();
        });
        
        function fetchfilteredProducts(){

            $(".appendData").remove();

            $("#outer-column").append(`
             <div class="d-flex justify-content-center product-loader">
                <div class="spinner-border text-danger"></div>
            </div>
            `);

            var priceFilter = [];
            $(".price-filter:checked").each(function(){
                priceFilter.push($(this).val());
            });

            var formdata = {
                price: priceFilter
            }

            $.ajax({
                url: "{{ route('shop.filter') }}",
                type: "GET",
                data: formdata,
                success: function(response){
                 
                    if(response.success ){
                        
                            $("#product-list").append(response.html);
                    }else{
                        alert(response.message);
                    }
                    $(".product-loader").remove();
                },
                error: function(error){
                  
                    alert(error.msg)
                }
            });
        }
        fetchfilteredProducts();
    });
</script>

@endpush