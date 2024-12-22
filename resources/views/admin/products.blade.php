@extends('layouts.admin-layout')

@section('content')
    <h2 class="mb-4">Products</h2>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModel">
        Creat Product
    </button>


     <!-- Modal -->
     <div class="modal fade" id="createModel" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="createModelLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="staticBackdropLabel">Add Product</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <form action="" id="createForm" enctype="multipart/form-data" >
                 @csrf
                 <div class="modal-body">
                     <div class="form-group">
                         <label>Image</label>
                         <input type="file" class="form-control" name="images" required multiple accept=".jpg, .jpeg, .png" >
                     </div>
                     <div class="form-group">
                         <label>Title</label>
                         <input type="text" class="form-control" name="title" placeholder="enter product title" required>
                     </div>
                     <div class="form-group">
                        <div class="row" >
                        <div class="col-sm-6" >
                            <label>Price (PKR):</label>
                            <input type="number" class="form-control" name="pkr_price"
                             placeholder="enter Price (PKR)" step="0.01" min="1" >
                       
                        </div>
                        <div class="col-sm-6" >
                            <label>Price (USD):</label>
                            <input type="number" class="form-control" name="usd_price"
                             placeholder="enter Price (USD)" step="0.01" min="1" >
                       
                        </div>
                    </div>
                 </div>
                 <div class="form-group">
                    <label>Stock</label>
                    <input type="number" min="1" class="form-control" name="stock"
                     placeholder="enter Qty" >
                </div>
                <div class="form-group">
                    <label>Category:</label>
                    <div class="dropdown w-100" >
                        <div class="dropdown-btn" onclick="toggleDropdown()" >Select Option</div>
                        <div class="dropdown-content" >
                            @foreach (getAllCategory() as $category)
                            <label><input type="checkbox" data-name="{{$category->name}}" value="{{$category->id}}" onchange="updateSelected()">{{$category->name}}
                            </label>
                            @if ($category->children->isNotEmpty())
                                @foreach ($category->children as  $childCategory)
                                <label><input type="checkbox" data-name="{{$childCategory->name}}" value="{{$childCategory->id}}" onchange="updateSelected()">{{$childCategory->name}}
                                </label>
                                @endforeach
                            @endif
                            @endforeach
                    </div>
                    </div>
                  </div>
                  {{-- <div class="form-group">
                      <label>Variation:</label>
                      @foreach (getVariations() as $variation)
                      <div class="mb-3">
                          <label class="form-label" >{{$variation->name}}</label>
                          <select name="variations[{{$loop->index}}][variation_value_ids]"  class="form-control" multiple style="
                            min-height: max-content;
                        " >
                            @foreach ($variation->values as $value)
                            <option value="{{$value->id}}" >{{$value->value}}</option>
                                
                            @endforeach
                        </select>
                        <input type="hidden" name="variations[{{$loop->index}}][variation_id]" value="{{$variation->id}}" >

                    </div>
                        
                    @endforeach
                  </div> --}}
                  <div class="form-group">
                    <label>Variation:</label>
                    @foreach (getVariations() as $variation)
                        <div class="mb-3">
                            <label class="form-label">{{ $variation->name }}</label>
                            <select 
                                name="variations[{{ $loop->index }}][variation_value_ids][]" 
                             
                                class="form-control" 
                                multiple 
                                style="min-height: max-content;">
                                @foreach ($variation->values as $value)
                                    <option value="{{ $value->id }}">{{ $value->value }}</option>
                                @endforeach
                            </select>
                            <input 
                                type="hidden" 
                                name="variations[{{ $loop->index }}][variation_id]" 
                                value="{{ $variation->id }}" 
                            >
                        </div>
                    @endforeach
                </div>
                
                  <div class="form-group">
    <label>Description</label>
    <textarea name="description" class="form-control" placeholder="Enter Description" cols="30" rows="10"></textarea>
</div>
                  <div class="form-group">
    <label>Addition Information</label>
    <textarea name="add_information" class="form-control" placeholder="Enter Additional Information" cols="30" rows="10"></textarea>
</div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                     <button type="submit" class="btn btn-primary createBtn">Create</button>
                 </div>

             </form>
         </div>
     </div>
 </div>
 @endsection
 @push('script')
 <script>
    function toggleDropdown() {
        const dropdown =  document.querySelector('.dropdown');
        dropdown.classList.toggle('open');
        
    }
    function updateSelected() {
    const checkboxes = document.querySelectorAll('.dropdown-content input[type="checkbox"]');
    const selected = [];
    const showName = [];
    checkboxes.forEach(checkbox => { // Corrected "foreach" to "forEach"
        if (checkbox.checked) {
            selected.push(checkbox.value);
            showName.push(checkbox.getAttribute('data-name'));
        }
    });
    document.querySelector('.dropdown-btn').textContent = showName.length > 0 ? showName.join(', ') : 'Select Option';
}
        // close dropdown if clicked outside
        document.addEventListener('click',function (event) {
            const dropdown  = document.querySelector('.dropdown');
            if(!dropdown.contains(event.target)){
                dropdown.classList.remove('open');

            }
            
        });


    </script>
  @endpush