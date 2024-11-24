@extends('layouts.admin-layout')

@section('content')
    <h2 class="mb-4">Banners</h2>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModel">
        Add Banner
    </button>

    <table class="table table-striped mt-2">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Banner Image</th>
                <th scope="col">Paragraph</th>
                <th scope="col">Heading</th>
                <th scope="col">Button Text</th>
                <th scope="col">Link</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($banners as $banner)
                <tr>
                    <th scope="row">{{ $banner->id }}</th>
                    <td> <img src="{{ asset($banner->image) }}" width="100px" alt=""> </td>
                    <td>{{ $banner->paragraph }}</td>
                    <td>{{ $banner->heading }}</td>
                    <td>{{ $banner->btn_text }}</td>
                    <td>{{ $banner->link }}</td>
                    <td>{{ $banner->status ? 'Enabled' : 'Disabled' }}</td>
                    <td>
                        <button class="btn btn-primary editbtn" data-toggle="modal" data-target="#UpdateModel"
                            data-obj="{{ $banner }}">Edit</button>
                        <button class="btn btn-danger deletebtn" data-toggle="modal" data-target="#deleteModel"
                            data-id="{{ $banner->id }}">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $banners->links('pagination::bootstrap-5') }}

    <!--create Modal -->
    <div class="modal fade" id="createModel" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="createModelLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Add Banner</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="addForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Banner Image</label>
                            <input type="file" class="form-control" name="image" required>
                        </div>
                        <div class="form-group">
                            <label>Paragraph</label>
                            <input type="text" class="form-control" name="paragraph" placeholder="enter Your Paragraph">
                        </div>
                        <div class="form-group">
                            <label>heading</label>
                            <input type="text" class="form-control" name="heading" placeholder="enter Your Heading"
                                required>
                        </div>
                        <div class="form-group">
                            <label>Button Text</label>
                            <input type="text" class="form-control" name="btn_text" placeholder="enter Your Button Text">
                        </div>
                        <div class="form-group">
                            <label>Link</label>
                            <input type="text" class="form-control" name="link" placeholder="enter Your Link">
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="1">Enable</option>
                                <option value="0">Disable</option>


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
    <div class="modal fade" id="UpdateModel" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="UpdateModelLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Update Banner</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="updateForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="updateid">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Banner Image</label>
                            <input type="file" class="form-control" name="image" >
                        </div>
                        <div class="form-group">
                            <label>Paragraph</label>
                            <input type="text" id="paragraph" class="form-control" name="paragraph" placeholder="enter Your Paragraph">
                        </div>
                        <div class="form-group">
                            <label>heading</label>
                            <input type="text" id="heading" class="form-control" name="heading" placeholder="enter Your Heading"
                                required>
                        </div>
                        <div class="form-group">
                            <label>Button Text</label>
                            <input type="text" id="btn_text" class="form-control" name="btn_text" placeholder="enter Your Button Text">
                        </div>
                        <div class="form-group">
                            <label>Link</label>
                            <input type="text" id="link" class="form-control" name="link" placeholder="enter Your Link">
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control" id="status" >
                                <option value="1">Enable</option>
                                <option value="0">Disable</option>


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
                        <p>Are You Sure, You Want To Delete the Banner ?</p>
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

                var formData = new FormData(this);

                $.ajax({
                    url: "{{ route('admin.banner.store') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        alert(res.msg);
                        $('.createBtn').prop('disabled', false);
                        if (res.success) {
                            location.reload();

                        }

                    }
                });

            });
            // delete banner working
            $('.deletebtn').click(function() {
                var id = $(this).data('id');
                $("#deleteid").val(id);
            });
            $('#deleteForm').submit(function(e) {
                e.preventDefault();
                $('.btnDelete').prop('disabled', true);
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('admin.banner.destory') }}",
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

            // update banner working
            $('.editbtn').click(function(){
             var data = $(this).data('obj');
             console.log(data);
             $('#updateid').val(data.id);
             $('#paragraph').val(data.paragraph);
             $('#heading').val(data.heading);
             $('#btn_text').val(data.btn_text);
             $('#link').val(data.link);
             $('#status').val(data.status);
            });
            $('#updateForm').submit(function(e) {
                e.preventDefault();
                $('.updateBtn').prop('disabled', true);

                var formData = new FormData(this);

                $.ajax({
                    url: "{{ route('admin.banner.update') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        alert(res.msg);
                        $('.updateBtn').prop('disabled', false);
                        if (res.success) {
                            location.reload();

                        }

                    }
                });

            });

        });
    </script>
@endpush
