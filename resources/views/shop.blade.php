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
                        {{-- <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" checked id="{{ strtolower($variation->name) }}-all">
                            <label class="custom-control-label" for="price-all">All {{ ucfirst($variation->name) }}</label>
                            <span class="badge border font-weight-normal">{{getVariationProductCount($variation->id)}}</span>
                        </div> --}}
                        @foreach ($variation->values as $key => $value )
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input variation-filter" id="{{ strtolower($variation->name) }}-{{$key}}"
                            name="variation[]" value="{{$value->value}}" >
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
            <div class="row pb-3"  >
                <div class="col-12 pb-1">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <form action="">
                            <div class="input-group">
                                <input type="text" id="search-input" class="form-control" placeholder="Search by name">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-transparent text-primary">
                                        <i class="fa fa-search"></i>
                                    </span>
                                </div>
                            </div>
                        </form>
                        <div class="dropdown ml-4">
                            <button class="btn border dropdown-toggle" type="button" id="sort-dropdown" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                        Sort by
                                    </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="sort-dropdown">
                                <a class="dropdown-item sort-option active" data-sort="latest" href="#">Latest</a>
                                <a class="dropdown-item sort-option"  data-sort="oldest" href="#">Oldest</a>
                                <a class="dropdown-item sort-option"  data-sort="popularity" href="#">Popularity</a>
                                <a class="dropdown-item sort-option"  data-sort="rating" href="#">Best Rating</a>
                            </div>
                        </div>
                    </div>
                </div>
               
                
            </div>
            <div class="row pb-3" id="product-list" >

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

        let selectedSort = "latest";

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
        
        function fetchfilteredProducts(page = 1){

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
            var variationFilter = [];
            $('input[name^="variation"]:checked').each(function(){
                variationFilter.push($(this).val());
            });

         var searchQuery = $("#search-input").val();

            var formdata = {
                price: priceFilter,
                variations: variationFilter,
                page: page,
                sort: selectedSort,
                search: searchQuery
            }

            $.ajax({
                url: "{{ route('shop.filter') }}",
                type: "GET",
                data: formdata,
                success: function(response){
                 
                    if(response.success ){
                        
                            // $("#product-list").append(response.html);
                            $("#product-list").html(response.html);

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

        $(".variation-filter").on("change",function(){
        fetchfilteredProducts();

        });

        $(document).on("click",".pagination a",function(e){
            e.preventDefault();

          var page =  $(this).attr("href").split('page=')[1];
          fetchfilteredProducts(page);
        });

        let searchTimeout;
        $("#search-input").on("keyup",function(){
            clearTimeout(searchTimeout);
          searchTimeout = setTimeout(() => {
                fetchfilteredProducts();
                
            }, 500);
        });

        $(".sort-option").on("click",function(e){
            e.preventDefault();
            $(".sort-option").removeClass("active");
            $(this).addClass("active");
            selectedSort =  $(this).data("sort");
            fetchfilteredProducts();
        });
    });
</script>

@endpush