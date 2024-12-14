@extends('layouts.admin-layout')

@section('content')
    <h2 class="mb-4">Variation</h2>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModel">
        Add Variation
    </button>

    <table class="table table-striped mt-2">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($variation as $variations)
                <tr>
                    <th scope="row">{{ $variations->id }}</th>
                    <th scope="row">{{ $variations->name }}</th>

                    <td>
                        <button class="btn btn-primary editbtn" data-toggle="modal" data-target="#UpdateModel"
                            data-obj="{{ $variations }}">Edit</button>
                        <button class="btn btn-danger deletebtn" data-toggle="modal" data-target="#deleteModel"
                            data-id="{{ $variations->id }}">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $variation->links('pagination::bootstrap-5') }}

    <!--create Modal -->
    <div class="modal fade" id="createModel" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="createModelLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Add Variation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="addForm" >
                    @csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" placeholder="enter Your variation">
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

     <!--Update Modal -->
     <div class="modal fade" id="UpdateModel" data-backdrop="static" data-keyboard="false" tabindex="-1"
     aria-labelledby="UpdateModelLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="staticBackdropLabel">Update Variation</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <form action="" id="updateForm" >
                 @csrf
                 <input type="hidden" name="id" id="updateid">
                 <div class="modal-body">

                     <div class="form-group">
                         <label>name</label>
                         <input type="text" id="name" class="form-control" name="name" placeholder="enter Your Variation">
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
   aria-labelledby="createCategoryModelLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title" id="staticBackdropLabel">Delete Bannner</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
           </div>
           <form action="" id="deleteForm">
               @csrf
               <input type="hidden" name="id" id="deleteid">
               <div class="modal-body">
                   <p>Are You Sure, You Want To Delete the Variation ?</p>
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
                    url: "{{ route('admin.variation.store') }}",
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
               // update variation working
               $('.editbtn').click(function(){
             var data = $(this).data('obj');
             console.log(data);
             $('#updateid').val(data.id);
             $('#name').val(data.name);

            });
            $('#updateForm').submit(function(e) {
                e.preventDefault();
                $('.updateBtn').prop('disabled', true);

                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('admin.variation.update') }}",
                    type: 'POST',
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
              // delete Variation working
              $('.deletebtn').click(function() {
                var id = $(this).data('id');
                $("#deleteid").val(id);
            });
            $('#deleteForm').submit(function(e) {
                e.preventDefault();
                $('.btnDelete').prop('disabled', true);
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('admin.variation.destory') }}",
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
