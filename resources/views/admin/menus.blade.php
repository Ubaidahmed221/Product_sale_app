@extends('layouts.admin-layout')

@section('content')
    <h2 class="mb-4">Menus</h2>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createMenuModel">
        Creat Menu
    </button>

    <table class="table table-striped mt-2">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Menus Name</th>
                <th scope="col">Menus URL</th>
                <th scope="col">External </th>
                <th scope="col">Menu Position</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($menus as $menu)

            <tr>
                <th scope="row">{{ $menu->id }}</th>
                <td>{{ $menu->name }}</td>
                <td>{{ $menu->url }}</td>
                <td>{{ $menu->is_external == 1 ? 'Yes' : 'No' }}</td>
                <td>{{ $menu->position }}</td>
                <td>
                    <button class="btn btn-danger deletebtn" data-toggle="modal" data-target="#deleteMenuModel" data-id="{{ $menu->id }}" >Delete</button>
                    <button class="btn btn-primary editbtn" data-toggle="modal" data-target="#UpdateMenuModel" data-obj="{{ $menu }}" >Edit</button>
                </td>
            </tr>

            @endforeach
        </tbody>
    </table>
    {{ $menus->links('pagination::bootstrap-5') }}

    <!-- Modal -->
    <div class="modal fade" id="createMenuModel" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="createMenuModelLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Create Menu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="createMenuForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Menu Name</label>
                            <input type="text" class="form-control" name="name" placeholder="MenuName" required>
                        </div>
                        <div class="form-group">
                            <label>URL</label>
                            <input type="text" class="form-control" name="url" placeholder="URL" required>
                        </div>
                        <div class="form-group">
                            <label>Is External Link</label>
                            <input type="checkbox" name="is_external" value="1">
                        </div>
                        <div class="form-group">
                            <label>Position</label>
                            <select name="position" class="form-control">
                                <option value="main">Main</option>
                                <option value="quik_link_1">Quik Links 1</option>
                                <option value="quik_link_2">Quik Links 2</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Parent Menu (optional)</label>
                            <select name="parent_id" class="form-control">
                                <option value="">None</option>
                                @foreach ($parentMenu as $menu)
                                    <option value="{{ $menu->id }}">{{ $menu->name }}</option>
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

    <!-- Update Modal -->
    <div class="modal fade" id="UpdateMenuModel" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="createMenuModelLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Update Menu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="updateMenuForm">
                    <input type="hidden" name="id" id="updateMenuId"  >
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Menu Name</label>
                            <input type="text" class="form-control" name="name" placeholder="MenuName" id="menuName" required>
                        </div>
                        <div class="form-group">
                            <label>URL</label>
                            <input type="text" class="form-control" name="url" id="menuURL" placeholder="URL" required>
                        </div>
                        <div class="form-group">
                            <label>Is External Link</label>
                            <input type="checkbox" id="menusIs_external" name="is_external" value="1">
                        </div>
                        <div class="form-group">
                            <label>Position</label>
                            <select name="position" class="form-control" id="menuPosition" >
                                <option value="main">Main</option>
                                <option value="quik_link_1">Quik Links 1</option>
                                <option value="quik_link_2">Quik Links 2</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Parent Menu (optional)</label>
                            <select name="parent_id" class="form-control" id="menu_parent_id">
                                <option value="">None</option>
                                @foreach ($parentMenu as $menu)
                                    <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary UpdateBtn">Update</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

     <!-- Delete Modal -->
 <div class="modal fade" id="deleteMenuModel" data-backdrop="static" data-keyboard="false" tabindex="-1"
     aria-labelledby="createMenuModelLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="staticBackdropLabel">Delete Menu</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <form action="" id="deleteMenuForm">
                 @csrf
                 <input type="hidden" name="id" id="deleteMenuid">
                 <div class="modal-body">
                   <p>Are You Sure, You Want To Delete the Menu ?</p>
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
            $('#createMenuForm').submit(function(e) {
                e.preventDefault();
                $('.createBtn').prop('disabled', true);

                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('admin.menus.store') }}",
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
              $("#deleteMenuid").val(id);
            });
              $('#deleteMenuForm').submit(function(e) {
                e.preventDefault();
                $('.btnDelete').prop('disabled', true);
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('admin.menus.destory') }}",
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
            // Edit Work
            $('.editbtn').click(function(){
             var data = $(this).data('obj');
             console.log(data);
             $('#updateMenuId').val(data.id);
             $('#menuName').val(data.name);
             $('#menuURL').val(data.url);
             if(data.is_external){
                 $('#menusIs_external').prop('checked',true);
              }else{
                    $('#menusIs_external').prop('checked',false);

                }
             $('#menuPosition').val(data.position);
             $('#menu_parent_id').val(data.parent_id);
            });
            $('#updateMenuForm').submit(function(e) {
                e.preventDefault();
                $('.UpdateBtn').prop('disabled', true);

                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('admin.menus.update') }}",
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


        });
    </script>
@endpush
