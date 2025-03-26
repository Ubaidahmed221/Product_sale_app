@extends('layouts.admin-layout')

@section('content')
    <h2 class="mb-4">Price Filter</h2>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModel">
        Add Price Filter
    </button>

    <table class="table table-striped mt-2">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Label</th>
                <th scope="col">Min Price </th>
                <th scope="col">Max Price</th>
               
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($PriceFilter as $PriceFilters)

            <tr>
                <th scope="row">{{ $PriceFilters->id }}</th>
                <td>{{$PriceFilters->min_price . ' - '. $PriceFilters->max_price }}</td>   
                <td>{{$PriceFilters->min_price}}</td>   
                <td>{{$PriceFilters->max_price}}</td>     
                <td>
                    <button class="btn btn-primary editbtn" data-toggle="modal" data-target="#editModel" data-obj="{{$PriceFilters}}" >Edit</button>
                    <button class="btn btn-danger deletebtn" data-toggle="modal" data-target="#deleteModel" data-id="{{$PriceFilters->id}}" >Delete</button>
                 </td>
            </tr>

            @endforeach
        </tbody>
    </table>
    {{ $PriceFilter->links('pagination::bootstrap-5') }}

     <!--create Modal -->
  <div class="modal fade" id="createModel" data-backdrop="static" data-keyboard="false" tabindex="-1"
     aria-labelledby="createModelLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="staticBackdropLabel">Add Price Filter</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <form action="" id="addForm">
                 @csrf
                 <div class="modal-body">
                   
                     <div class="form-group">
                         <label>Min. Price</label>
                         <input type="number" min="0" class="form-control" name="min_price" id="min_price" placeholder="Min Price " required>
                     </div>
                     <div class="form-group">
                        <label>Max. Price</label>
                        <input type="number" min="0" class="form-control" name="max_price" id="max_price" placeholder="Max Price " required>
                    </div>
                    
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                     <button type="submit" class="btn btn-primary createBtn">Create</button>
                 </div>

             </form>
         </div>
     </div>
 </div>

    <!--Edit Modal -->
    <div class="modal fade" id="editModel" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="editModelLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Price Filter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="editForm">
                @csrf
                <input type="hidden" name="id" id="update_id">
                <div class="modal-body">
                   
                    <div class="form-group">
                        <label>Min. Price</label>
                        <input type="number" min="0" class="form-control" name="min_price" id="u_min_price" placeholder="Min Price " required>
                    </div>
                    <div class="form-group">
                       <label>Max. Price</label>
                       <input type="number" min="0" class="form-control" name="max_price" id="u_max_price" placeholder="Max Price " required>
                   </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary updateBtn">Update</button>
                </div>

            </form>
        </div>
    </div>
</div>

 <!-- Delete Modal -->
 <div class="modal fade" id="deleteModel" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="createModelLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Delete Price Filter</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <form action="" id="deleteForm">
              @csrf
              <input type="hidden" name="id" id="deleteid">
              <div class="modal-body">
                <p>Are You Sure, You Want To Delete the Price Filter?</p>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-danger btnDelete">Delete</button>
              </div>

          </form>
      </div>
  </div>
</div>

    @endsection

@push('script')
<script>
    $(document).ready(function() {
        $('#addForm').submit(function(e) {
            e.preventDefault();
            
            var formData = $(this).serialize();
            if(parseInt($("#min_price").val()) >= parseInt($("#max_price").val()) ){
                alert('Minium price should be less than Maximum price!');
                return;
            }
            $('.createBtn').prop('disabled', true);

            $.ajax({
                url: "{{ route('admin.price.filter.store') }}",
                type: 'POST',
                data: formData,
               
                success: function(res) {
                    alert(res.msg);
                    $('.createBtn').prop('disabled', false);
                    if (res.success) {
                        location.reload();

                    }

                }
            });

        });

        $('.editbtn').click(function(){
         var obj =  $(this).data('obj');
     
         $('#update_id').val(obj.id);
         $('#u_min_price').val(obj.min_price);
         $('#u_max_price').val(obj.max_price);
 

        });

        $('#editForm').submit(function(e) {
            e.preventDefault();
            if(parseInt($("#u_min_price").val()) >= parseInt($("#u_max_price").val()) ){
                alert('Minium price should be less than Maximum price!');
                return;
            }
            $('.updateBtn').prop('disabled', true);

            var formData = $(this).serialize();

            $.ajax({
                url: "{{ route('admin.price.filter.update') }}",
                type: 'PUT',
                data: formData,
               
                success: function(res) {
                    alert(res.msg);
                    $('.updateBtn').prop('disabled', false);
                    if (res.success) {
                        location.reload();

                    }

                }
            });

        });

        $('.deletebtn').click(function(){
            $('#deleteid').val($(this).data('id'));
        });
        
        $('#deleteForm').submit(function(e) {
            e.preventDefault();
            $('.btnDelete').prop('disabled', true);

            var formData = $(this).serialize();

            $.ajax({
                url: "{{ route('admin.price.filter.destroy') }}",
                type: 'DELETE',
                data: formData,
               
                success: function(res) {
                    alert(res.msg);
                    $('.btnDelete').prop('disabled', false);
                    if (res.success) {
                        location.reload();

                    }

                }
            });

        });
    
        });
</script>

@endpush
