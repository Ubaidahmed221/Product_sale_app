@extends('layouts.admin-layout')

@section('content')
    <h2 class="mb-4">Coupons</h2>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModel">
        Add Coupons
    </button>

    <table class="table table-striped mt-2">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Code</th>
                <th scope="col">Discount</th>
                <th scope="col">Usage Limit</th>
                <th scope="col">Used Count</th>
                <th scope="col">Expires At</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($coupon as $coupons)

            <tr>
                <th scope="row">{{ $coupons->id }}</th>
                <td>{{$coupons->code}}</td>   
                <td>{{$coupons->discount}}</td>   
                <td>{{$coupons->user_limit}}</td>   
                <td>{{$coupons->used_count}}</td>   
                <td>{{$coupons->expires_at}}</td>   
                <td>
                    <button class="btn btn-primary editbtn" data-toggle="modal" data-target="#editModel" data-obj="{{$coupons}}" >Edit</button>
                    <button class="btn btn-danger deletebtn" data-toggle="modal" data-target="#deleteModel" data-id="{{$coupons->id}}" >Delete</button>
               
                 </td>
            </tr>

            @endforeach
        </tbody>
    </table>
    {{ $coupon->links('pagination::bootstrap-5') }}

     <!--create Modal -->
  <div class="modal fade" id="createModel" data-backdrop="static" data-keyboard="false" tabindex="-1"
     aria-labelledby="createModelLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="staticBackdropLabel">Add Coupon</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <form action="" id="addForm">
                 @csrf
                 <div class="modal-body">
                    
                     <div class="form-group">
                         <label>Code</label>
                         <input type="text" class="form-control" name="code" placeholder="Code " required>
                     </div>
                     <div class="form-group">
                         <label>Discount</label>
                         <input type="number" min="1" class="form-control" name="discount" placeholder="Discount " required>
                     </div>
                     <div class="form-group">
                        <label>Usage Limit</label>
                        <input type="number" min="1" class="form-control" name="user_limit" placeholder="Usage Limit " >
                    </div>
                    <div class="form-group">
                        <label>Expires At</label>
                        <input type="date"  class="form-control" name="expires_at" placeholder="Expires At " >
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
                <h5 class="modal-title" id="staticBackdropLabel">edit Coupon</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="editForm">
                @csrf
                <input type="hidden" name="id" id="update_id">
                <div class="modal-body">
                   
                    <div class="form-group">
                        <label>Code</label>
                        <input type="text" class="form-control" name="code" id="code" placeholder="Code " required>
                    </div>
                    <div class="form-group">
                        <label>Discount</label>
                        <input type="number" min="1" class="form-control" name="discount" id="discount" placeholder="Discount " required>
                    </div>
                    <div class="form-group">
                       <label>Usage Limit</label>
                       <input type="number" min="1" class="form-control" name="user_limit" id="user_limit" placeholder="Usage Limit " >
                   </div>
                   <div class="form-group">
                       <label>Expires At</label>
                       <input type="date"  class="form-control" name="expires_at" id="expires_at" placeholder="Expires At " >
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
              <h5 class="modal-title" id="staticBackdropLabel">Delete Coupon</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <form action="" id="deleteForm">
              @csrf
              <input type="hidden" name="id" id="deleteid">
              <div class="modal-body">
                <p>Are You Sure, You Want To Delete the Coupon?</p>
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
            $('.createBtn').prop('disabled', true);

            var formData = $(this).serialize();

            $.ajax({
                url: "{{ route('admin.coupon.store') }}",
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
         var coupon =  $(this).data('obj');
         console.log(coupon);
         $('#update_id').val(coupon.id);
         $('#code').val(coupon.code);
         $('#discount').val(coupon.discount);
         $('#user_limit').val(coupon.user_limit);
         $('#expires_at').val(coupon.expires_at);

        });

        $('#editForm').submit(function(e) {
            e.preventDefault();
            $('.updateBtn').prop('disabled', true);

            var formData = $(this).serialize();

            $.ajax({
                url: "{{ route('admin.coupon.update') }}",
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
                url: "{{ route('admin.coupon.destroy') }}",
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
