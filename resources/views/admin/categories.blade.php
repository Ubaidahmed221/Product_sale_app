@extends('layouts.admin-layout')

@section('content')
    <h2 class="mb-4">Category</h2>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createCategoryModel">
        Add Category
    </button>

    <table class="table table-striped mt-2">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Category Name</th>
                <th scope="col">Parent Category Name</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($allcategory as $categories)

            <tr>
                <th scope="row">{{ $categories->id }}</th>
                <td>{{ $categories->name }}</td>
                <td>{{ $categories->parent?$categories->parent->name: '-' }}</td>

                <td>
                    <button class="btn btn-primary editbtn" data-toggle="modal" data-target="#UpdateCategoryModel" data-obj="{{ $categories }}" >Edit</button>
                    <button class="btn btn-danger deletebtn" data-toggle="modal" data-target="#deleteCategoryModel" data-id="{{ $categories->id }}" >Delete</button>
                </td>
            </tr>

            @endforeach
        </tbody>
    </table>
    {{ $allcategory->links('pagination::bootstrap-5') }}

     <!--create Modal -->
  <div class="modal fade" id="createCategoryModel" data-backdrop="static" data-keyboard="false" tabindex="-1"
     aria-labelledby="createCategoryModelLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="staticBackdropLabel">Add Catagory</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <form action="" id="addCategoryForm">
                 @csrf
                 <div class="modal-body">
                     <div class="form-group">
                         <label>Category Name</label>
                         <input type="text" class="form-control" name="category_name" placeholder="MenuName" required>
                     </div>
                     <div class="form-group">
                        <label>Parent Categroy </label>
                        <select name="parent_id" class="form-control">
                            <option value="">None</option>
                            @foreach ($category as $categories)
                                <option value="{{ $categories->id }}">{{ $categories->name }}</option>
                            @endforeach
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

  <!--Update Modal -->
  <div class="modal fade" id="UpdateCategoryModel" data-backdrop="static" data-keyboard="false" tabindex="-1"
     aria-labelledby="createCategoryModelLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="staticBackdropLabel">Update Catagory</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <form action="" id="UpdateCategoryForm">
                <input type="hidden" name="id" id="updateCategoryId"  >

                 @csrf
                 <div class="modal-body">
                     <div class="form-group">
                         <label>Category Name</label>
                         <input type="text" class="form-control" name="category_name" id="category_name" placeholder="MenuName" required>
                     </div>
                     <div class="form-group">
                        <label>Parent Categroy </label>
                        <select name="parent_id" id="parent_id" class="form-control">
                            <option value="">None</option>
                            @foreach ($category as $categories)
                                <option value="{{ $categories->id }}">{{ $categories->name }}</option>
                            @endforeach
                        </select>
                    </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                     <button type="submit" class="btn btn-primary UpdateBtn">Create</button>
                 </div>

             </form>
         </div>
     </div>
 </div>

  <!-- Delete Modal -->
<div class="modal fade" id="deleteCategoryModel" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="createCategoryModelLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Delete Categroy</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <form action="" id="deletecategoryForm">
              @csrf
              <input type="hidden" name="id" id="deleteCategoryid">
              <div class="modal-body">
                <p>Are You Sure, You Want To Delete the Category (also deleted child categories?) ?</p>
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
        $('#addCategoryForm').submit(function(e) {
            e.preventDefault();
            $('.createBtn').prop('disabled', true);

            var formData = $(this).serialize();

            $.ajax({
                url: "{{ route('admin.category.store') }}",
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

        $('.deletebtn').click(function(){
              var id =  $(this).data('id');
              $("#deleteCategoryid").val(id);
         });
              $('#deletecategoryForm').submit(function(e) {
                e.preventDefault();
                $('.btnDelete').prop('disabled', true);
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('admin.category.destory') }}",
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

    // Edit Work
    $('.editbtn').click(function(){
             var data = $(this).data('obj');
             console.log(data);
             $('#updateCategoryId').val(data.id);
             $('#category_name').val(data.name);
             $('#parent_id').val(data.parent_id);
            });
            $('#UpdateCategoryForm').submit(function(e) {
                e.preventDefault();
                $('.UpdateBtn').prop('disabled', true);

                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('admin.category.update') }}",
                    type: 'PUT',
                    data: formData,
                    success: function(res) {
                        alert(res.msg);
                        $('.UpdateBtn').prop('disabled', false);
                        if (res.success) {
                            location.reload();

                        }

                    }
                });

            });

</script>

@endpush
