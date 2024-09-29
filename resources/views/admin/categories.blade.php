@extends('layouts.admin-layout')

@section('content')
    <h2 class="mb-4">Category</h2>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createCategoryModel">
        Add Category
    </button>

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

    });

</script>

@endpush