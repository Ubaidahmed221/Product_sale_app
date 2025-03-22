@extends('layouts.admin-layout')

@section('content')
    <h2 class="mb-4">Shipping Zones</h2>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModel">
        Add Shipping Zones
    </button>

    <table class="table table-striped mt-2">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Country</th>
                <th scope="col">State</th>
                <th scope="col">Cost In PKR</th>
                <th scope="col">Cost In USD</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($zone as $zones)

            <tr>
                <th scope="row">{{ $zones->id }}</th>
                <td>{{$zones->countryRelation->name}}</td>   
                <td>{{ optional($zones->stateRelation)->name ?? 'N/A' }}</td>   
                <td>{{$zones->shipping_cost_pkr}}</td>   
                <td>{{$zones->shipping_cost_usd}}</td>   
                <td>
                    <button class="btn btn-primary editbtn" data-toggle="modal" data-target="#editModel" data-obj="{{$zones}}" >Edit</button>
                    <button class="btn btn-danger deletebtn" data-toggle="modal" data-target="#deleteModel" data-id="{{$zones->id}}" >Delete</button>
                </td>
            </tr>

            @endforeach
        </tbody>
    </table>
    {{ $zone->links('pagination::bootstrap-5') }}

     <!--create Modal -->
  <div class="modal fade" id="createModel" data-backdrop="static" data-keyboard="false" tabindex="-1"
     aria-labelledby="createModelLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="staticBackdropLabel">Add Shipping Zones</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <form action="" id="addForm">
                 @csrf
                 <div class="modal-body">
                  
                     <div class="form-group">
                        <label>Country </label>
                        <select name="country" id="country" class="form-control" required >
                            <option value="">Select Country</option>
                            @foreach (countries() as $country )
                                <option value="{{$country->iso2}}">{{$country->name}}</option>
                            @endforeach
                          </select>
                    </div>
                    <div class="form-group">
                        <label >State </label>
                        <select name="state" id="state" class="form-control"  >
                          <option value="">Select State</option>
                        
                        </select>
                      
                    </div>
                     <div class="form-group">
                         <label>Shipping Cost (PKR)</label>
                         <input type="number" min="1" class="form-control" name="shipping_cost_pkr" placeholder="Shipping Cost PKR" required>
                     </div>
                     <div class="form-group">
                         <label>Shipping Cost (USD)</label>
                         <input type="number" min="1" class="form-control" name="shipping_cost_usd" placeholder="Shipping Cost USD" required>
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
    <div class="modal fade" id="editModel" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="editModelLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Shipping Zones</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="editForm">
                <input type="hidden" name="id" id="updateId">
                @csrf
                <div class="modal-body">
                 
                    <div class="form-group">
                       <label>Country </label>
                       <select name="country" id="updatecountry" class="form-control" required >
                           <option value="">Select Country</option>
                           @foreach (countries() as $country )
                               <option value="{{$country->iso2}}">{{$country->name}}</option>
                           @endforeach
                         </select>
                   </div>
                   <div class="form-group">
                       <label >State </label>
                       <select name="state" id="updatestate" class="form-control"  >
                         <option value="">Select State</option>
                       
                       </select>
                     
                   </div>
                    <div class="form-group">
                        <label>Shipping Cost (PKR)</label>
                        <input type="number" min="1" class="form-control" id="shipping_cost_pkr" name="shipping_cost_pkr" placeholder="Shipping Cost PKR" required>
                    </div>
                    <div class="form-group">
                        <label>Shipping Cost (USD)</label>
                        <input type="number" min="1" class="form-control"  id="shipping_cost_usd" name="shipping_cost_usd" placeholder="Shipping Cost USD" required>
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
              <h5 class="modal-title" id="staticBackdropLabel">Delete Shipping Zones</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <form action="" id="deleteForm">
              @csrf
              <input type="hidden" name="id" id="deleteid">
              <div class="modal-body">
                <p>Are You Sure, You Want To Delete the Shipping Zone?</p>
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
                url: "{{ route('admin.shipping.store') }}",
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
        // country & state
        $('#country').change(function(){
          var countryCode = $(this).val();

          $.ajax({
                url: "{{ route('states') }}",
                type: "POST",
                data: {
                    _token: "{{csrf_token()}}",
                    countryCode: countryCode
                },
                success: function(response){
                    if(response.success){
                      let data = response.data;
                      let html = '<option value="" >Select State</option>';
                      data.forEach(element => {
                         html += `<option value="`+element.state_code+`" >`+element.name+`</option>`;

                      });
                      $('#state').html(html);
                    }else{
                      alert(response.msg);
                    }
                },
                error: function(error){
                   alert(error.message);
                }
            });
        });
    
          // Update country & state
         $('#updatecountry').change(function(){
          var countryCode = $(this).val();

          $.ajax({
                url: "{{ route('states') }}",
                type: "POST",
                data: {
                    _token: "{{csrf_token()}}",
                    countryCode: countryCode
                },
                success: function(response){
                    if(response.success){
                      let data = response.data;
                      let html = '<option value="" >Select State</option>';
                      data.forEach(element => {
                         html += `<option value="`+element.state_code+`" >`+element.name+`</option>`;

                      });
                      $('#updatestate').html(html);
                    }else{
                      alert(response.msg);
                    }
                },
                error: function(error){
                   alert(error.message);
                }
            });
        });

        //  Edit Work
        $('.editbtn').click(function(){
            var objdata = $(this).data('obj');
            // console.log(objdata);
            $('#updateId').val(objdata.id);
            $('#updatecountry').val(objdata.country);
            $.ajax({
                url: "{{ route('states') }}",
                type: "POST",
                data: {
                    _token: "{{csrf_token()}}",
                    countryCode: objdata.country
                },
                success: function(response){
                    if(response.success){
                      let data = response.data;
                      let html = '<option value="" >Select State</option>';
                      data.forEach(element => {
                         html += `<option value="`+element.state_code+`" >`+element.name+`</option>`;

                      });
                      $('#updatestate').html(html);
                      $('#updatestate').val(objdata.state);
                    }else{
                      alert(response.msg);
                    }
                },
                error: function(error){
                   alert(error.message);
                }
            });
          
            $('#shipping_cost_pkr').val(objdata.shipping_cost_pkr);
            $('#shipping_cost_usd').val(objdata.shipping_cost_usd);
        });

        // update form 
        $('#editForm').submit(function(e) {
            e.preventDefault();
            $('.updateBtn').prop('disabled', true);

            var formData = $(this).serialize();

            $.ajax({
                url: "{{ route('admin.shipping.update') }}",
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

        // delete form
        $('.deletebtn').click(function(){
            var id = $(this).data('id');
            $('#deleteid').val(id);

        });

        // Delete data
        $('#deleteForm').submit(function(e) {
            e.preventDefault();
            $('.btnDelete').prop('disabled', true);

            var formData = $(this).serialize();

            $.ajax({
                url: "{{ route('admin.shipping.destory') }}",
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
