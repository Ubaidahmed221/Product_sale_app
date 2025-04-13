@extends('layouts.admin-layout')

@section('content')
    <h2 class="mb-4">Payment Gateway</h2>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModel">
        Add Payment Gateway
    </button>

    <table class="table table-striped mt-2">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Status</th> 
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($gateways as $gateway)

            <tr>
                <th scope="row">{{ $gateway->id }}</th>
                <td>{{$gateway->name }}</td>   
                <td>{{$gateway->is_enabled ? 'On' : 'Off'}}</td>   
                 
                <td>
                    <button class="btn btn-primary editbtn" data-toggle="modal" data-target="#editModel" data-obj="{{$gateway}}" >Edit</button>
                    <button class="btn btn-danger deletebtn" data-toggle="modal" data-target="#deleteModel" data-id="{{$gateway->id}}" >Delete</button>
                 </td>
            </tr>

            @endforeach
        </tbody>
    </table>
    {{ $gateways->links('pagination::bootstrap-5') }}

     <!--create Modal -->
  <div class="modal fade" id="createModel" data-backdrop="static" data-keyboard="false" tabindex="-1"
     aria-labelledby="createModelLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="staticBackdropLabel">Add Payment Gateway</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <form action="" id="addForm">
                 @csrf
                 <div class="modal-body">
                   
                     <div class="form-group">
                         <label>Name</label>
                         <input type="text" class="form-control" name="name"  placeholder="Name " required>
                     </div>
                     <div class="form-group">
                        <label>Status</label>
                        <select name="is_enabled" class="form-control">
                            <option value="1" selected >On</option>
                            <option value="0" >Off</option>
                        </select>
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
                <h5 class="modal-title" id="staticBackdropLabel">Edit Payment Gateway</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="editForm">
                @csrf
                <input type="hidden" name="id" id="update_id">
                <div class="modal-body">
                   
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" id="name"  placeholder="Name " required>
                    </div>
                    <div class="form-group">
                       <label>Status</label>
                       <select name="is_enabled" id="is_enabled" class="form-control">
                           <option value="1" selected >On</option>
                           <option value="0" >Off</option>
                       </select>
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
              <h5 class="modal-title" id="staticBackdropLabel">Delete Payment Gateway</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <form action="" id="deleteForm">
              @csrf
              <input type="hidden" name="id" id="deleteid">
              <div class="modal-body">
                <p>Are You Sure, You Want To Delete the Payment Gateway?</p>
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
            
            $('.createBtn').prop('disabled', true);

            $.ajax({
                url: "{{ route('admin.gateway.store') }}",
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
         $('#name').val(obj.name);
         $('#is_enabled').val(obj.is_enabled);
 

        });

        $('#editForm').submit(function(e) {
            e.preventDefault();
          
            $('.updateBtn').prop('disabled', true);

            var formData = $(this).serialize();

            $.ajax({
                url: "{{ route('admin.gateway.update') }}",
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
                url: "{{ route('admin.gateway.destroy') }}",
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
