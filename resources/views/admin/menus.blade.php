@extends('layouts.admin-layout')

@section('content')
    <h2 class="mb-4">Menus</h2>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createMenuModel">
        Creat Menu
    </button>

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
                            <label >Menu Name</label>
                            <input type="text" class="form-control" name="name" placeholder="MenuName" required>
                          </div>
                          <div class="form-group">
                            <label >URL</label>
                            <input type="text" class="form-control" name="url" placeholder="URL" required>
                          </div>
                          <div class="form-group">
                            <label >Is External Link</label>
                            <input type="checkbox" name="is_external" value="1" >
                          </div>
                          <div class="form-group">
                            <label >Position</label>
                            <select name="position" class="form-control">
                                <option value="main">Main</option>
                                <option value="quik_link_1">Quik Links 1</option>
                                <option value="quik_link_2">Quik Links 2</option>
                            </select>
                          </div>
                          <div class="form-group">
                            <label >Parent Menu (optional)</label>
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
@endsection

@push('script')
<script>
    $(document).ready(function(){
        $('#createMenuForm').submit(function(e){
            e.preventDefault();
            $('.createBtn').prop('disabled', true);

                var formData  = $(this).serialize();

            $.ajax({
                url: "{{ route('admin.menus.store') }}",
                type: 'POST',
                data: formData,
                success: function(res){
                    alert(res.msg);
                    $('.createBtn').prop('disabled', false);
                    if(res.success){
                        location.reload();

                    }

                }
            });

        })
    });
</script>
    
@endpush
