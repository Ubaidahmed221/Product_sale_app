@extends('layouts.admin-layout')

@section('content')
    <h2 class="mb-4">Offers</h2>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModel">
        Add Offer
    </button>
    <table class="table table-striped mt-2">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Image</th>
                <th scope="col">Heading</th>
                <th scope="col">Offer Heading</th>
                <th scope="col">Button Text</th>
                <th scope="col">Button Link</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($alloffer as $offer)

            <tr>
                <th scope="row">{{ $offer->id }}</th>
                <td>
                    @if ($offer->image)
                    <img src="{{'/'.$offer->image}}" alt="{{$offer->heading}}" width="50px" height="50px" >
                        @else
                        --
                    @endif
                </td>
                <td>{{ $offer->heading }}</td>
                <td>{{ $offer->offer_heading }}</td>
                <td>{{ $offer->btn_text }}</td>
                <td>{{ $offer->btn_link }}</td>
                 
                <td>
                    <button class="btn btn-primary editbtn" data-toggle="modal" data-target="#UpdateModel" data-obj="{{ $offer }}" >Edit</button>
                    <button class="btn btn-danger deletebtn" data-toggle="modal" data-target="#deleteModel" data-id="{{ $offer->id }}" >Delete</button>
                </td>
            </tr>

            @endforeach
        </tbody>
    </table>
  
    {{ $alloffer->links('pagination::bootstrap-5') }}

     <!--create Modal -->
  <div class="modal fade" id="addModel" data-backdrop="static" data-keyboard="false" tabindex="-1"
     aria-labelledby="addModelLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="staticBackdropLabel">Add Offer</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <form action="" id="addForm">
                 @csrf
                 <div class="modal-body">
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" class="form-control" name="image" >
                    </div>
                     <div class="form-group">
                         <label>Heading</label>
                         <input type="text" class="form-control" name="heading" placeholder="Heading" required>
                     </div>
                     <div class="form-group">
                        <label>Offer Heading</label>
                        <input type="text" class="form-control" name="offer_heading" placeholder="Offer Heading" required>
                    </div>
                    <div class="form-group">
                        <label>Button Text</label>
                        <input type="text" class="form-control" name="btn_text" placeholder="Button Text" >
                    </div>
                    <div class="form-group">
                        <label>Button Link</label>
                        <input type="text" class="form-control" name="btn_link" placeholder="Button Link" >
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
                 <h5 class="modal-title" id="staticBackdropLabel">Update Offer</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <form action="" id="UpdateForm">
                <input type="hidden" name="id" id="updateId"  >

                 @csrf
                 <div class="modal-body">
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" class="form-control" name="image" >
                    </div>
                    <div class="form-group">
                        <label>Heading</label>
                        <input type="text" class="form-control" name="heading" id="heading" placeholder="Heading" required>
                    </div>
                    <div class="form-group">
                       <label>Offer Heading</label>
                       <input type="text" class="form-control" name="offer_heading" id="offer_heading" placeholder="Offer Heading" required>
                   </div>
                   <div class="form-group">
                       <label>Button Text</label>
                       <input type="text" class="form-control" name="btn_text" id="btn_text" placeholder="Button Text" >
                   </div>
                   <div class="form-group">
                       <label>Button Link</label>
                       <input type="text" class="form-control" name="btn_link" id="btn_link" placeholder="Button Link" >
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
<div class="modal fade" id="deleteModel" data-backdrop="static" data-keyboard="false" tabindex="-1"
aria-labelledby="deleteModelLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Delete Offer</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="" id="deleteForm">
            @csrf
            <input type="hidden" name="id" id="deleteid">
            <div class="modal-body">
              <p>Are You Sure, You Want To Delete the offer</p>
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
        // create Offer 
        $('#addForm').submit(function(e) {
            e.preventDefault();
            $('.createBtn').prop('disabled', true);

            var formData = new FormData(this);

            $.ajax({
                url: "{{ route('admin.offer.store') }}",
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

      

        // Update Offer
        
    $('.editbtn').click(function(){
             var data = $(this).data('obj');
             console.log(data);
             $('#updateId').val(data.id);
             $('#heading').val(data.heading);
             $('#offer_heading').val(data.offer_heading);
             $('#btn_text').val(data.btn_text);
             $('#btn_link').val(data.btn_link);
             
            });
            $('#UpdateForm').submit(function(e) {
                e.preventDefault();
                $('.UpdateBtn').prop('disabled', true);

                var formData = new FormData(this);
 
                $.ajax({
                    url: "{{ route('admin.offer.update') }}",
                    type: 'POST',
                    data: formData,
                processData: false,
                contentType: false,
                    success: function(res) {
                        alert(res.msg);
                        $('.UpdateBtn').prop('disabled', false);
                        if (res.success) {
                            location.reload();

                        }

                    }
                });
                });

                $('.deletebtn').click(function(){
              var id =  $(this).data('id');
              $("#deleteid").val(id);
         });
              $('#deleteForm').submit(function(e) {
                e.preventDefault();
                $('.btnDelete').prop('disabled', true);
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('admin.offer.destory') }}",
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
