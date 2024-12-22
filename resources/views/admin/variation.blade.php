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
                <th scope="col">values</th>
                <th scope="col">Add Value</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($variation as $variations)
                <tr>
                    <th scope="row">{{ $variations->id }}</th>
                    <th scope="row">{{ $variations->name }}</th>
                    <th>
                        @foreach ($variations->values as $value)
                          <button class="btn btn-info" >  {{$value->value}}
                        <i class="fa fa-times deleteValue" data-id="{{$value->id}}" ></i>    
                        </button>
                        @endforeach
                    </th>
                    <th >
                        <button class="btn btn-secondary addvariation" data-id="{{ $variations->id}}"  data-name="{{ $variations->name}}"
                             data-toggle="modal" data-target="#addVariationModel" >Add Value</button>
                    </th>

                    <td>
                        <button class="btn btn-primary editbtn" data-toggle="modal" data-target="#UpdateModel"
                            data-obj="{{ $variations }}">Edit</button>
                        <button class="btn btn-danger deletebtn" data-toggle="modal" data-target="#deleteModel"
                            data-obj="{{ $variations }}">Delete</button>
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
                            <input type="text" class="form-control" name="name" placeholder="enter Your variation" required >
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
    <!--Add Variation Modal -->
    <div class="modal fade" id="addVariationModel" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="addVariationModelLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Add <span class="add-variation-name" ></span> value</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="addvariationForm" >
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="variation_id" id="add-variation-id" />

                        <div class="form-group">
                            <label>Value</label>
                            <input type="text" class="form-control" name="value" placeholder="enter Your value" required >
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary addvariationBtn">Create</button>
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
                 <input type="hidden" name="id" id="edit-id">
                 <div class="modal-body">

                     <div class="form-group">
                         <label>name</label>
                         <input type="text" id="edit-name" class="form-control" name="name" placeholder="enter Your Variation">
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
               <h5 class="modal-title" id="staticBackdropLabel">Delete Variation</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
           </div>
           <form action="" id="deleteForm">
               @csrf
               <input type="hidden" name="id" id="deleteid">
               <div class="modal-body">
                   <p>Are You Sure, You Want To Delete the  <b id="delete-name"></b> Variation</p>
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
             $('#edit-name').val(data.name);

            });
            $('#updateForm').submit(function(e) {
                e.preventDefault();
                $('.updateBtn').prop('disabled', true);

                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('admin.variation.update') }}",
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
              // delete Variation working
              $('.deletebtn').click(function() {
                var obj = $(this).data('obj');
                $("#deleteid").val(obj.id);
                $("#delete-name").text(obj.name);
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
            //  add variation Value working
            $('.addvariation').click(function() {
                $('#add-variation-id').val($(this).data('id'));
                $('.add-variation-name').text($(this).data('name'));

            });
            $('#addvariationForm').submit(function(e) {
                e.preventDefault();
                $('.addvariationBtn').prop('disabled', true);

                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('admin.variation.value.store') }}",
                    type: 'POST',
                    data: formData,
                    success: function(res) {
                        alert(res.msg);
                        $('.addvariationBtn').prop('disabled', false);
                        if (res.success) {
                            location.reload();

                        }

                    }
                });

            });

            $('.deleteValue').click(function () {
                var id = $(this).data('id');
                var confirmDelete = confirm("Are you sure you want to remove the value?");
                var obj = $(this); 
                if(confirmDelete){
                    $.ajax({
                    url: "{{ route('admin.variation.value.destory') }}",
                    type: 'DELETE',
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        alert(res.msg);
                        $('.addvariationBtn').prop('disabled', false);
                        if (res.success) {
                            $(obj).parent().remove();

                        }

                    }
                });

                }
            });

        });
    </script>
@endpush
