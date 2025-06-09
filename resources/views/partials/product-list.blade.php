@foreach ($products as $product)
<div class="col-lg-4 col-md-6 col-sm-12 pb-1 appendData">
    <div class="card product-item border-0 mb-4">
        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
            <img class="img-fluid w-100" src="{{ $product->firstImage->path }}" alt="">
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
            <a href="javascript:void(0)" class="wishlist-btn" data-id="{{$product->id}}" >
              <i class="far fa-heart " ></i>
            </a>
            <a  class="btn btn-sm text-dark p-0 add-to-cart" data-product-id="{{$product->id}}" ><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
        </div>
    </div>
</div>
@endforeach
@if (count($products) == 0)
    <div class="container text-center appendData">
      <h5>No Product Found</h5>
    </div>
@endif



<div class="col-12 pb-1 justify-content-center">
   

        {{ $products->links('pagination::bootstrap-5') }}
    
    {{-- <nav aria-label="Page navigation">
      <ul class="pagination justify-content-center mb-3">
        <li class="page-item disabled">
          <a class="page-link" href="#" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
            <span class="sr-only">Previous</span>
          </a>
        </li>
        <li class="page-item active"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item">
          <a class="page-link" href="#" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
            <span class="sr-only">Next</span>
          </a>
        </li>
      </ul>
    </nav> --}}
</div>