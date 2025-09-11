@extends('dashboard.layout')

@section('dashboard-content')
<div class="container" style="max-width: 860px;">
        <h4>Chat Support</h4>
        <div class="card">
            <div class="card-header">
                <strong>Chat with Admin</strong>
            </div>
            <div class="card-body p-0 d-flex flex-column" style="height: 40vh;">
                <div id="chatwindow" class="flex-grow-1 p-3" style="overflow-y: auto;"  ></div>
                <div class="border-top p-3" >
                    <form id="chatform" class="d-flex" >
                        <input type="text" id="messageInput" class="form-control me-2" placeholder="Type a Message..." autocomplete="off" required >
                        <button type="submit" class="btn btn-primary" >Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('child-script')
    <script>
        const authId = {{ auth()->id() }};
        const adminId = {{ $admin->id }};

        function messageBubble(data){
            const mine = data.from_id === authId;
          const align =  mine ? 'text-start' : 'text-end';
          const bubble = mine ? 'text-light bg-dark' : 'bg-light';
          const name =  mine ? 'You' : 'Admin';

          return `
            <div class="mb-2 ${align}">
                <div class="d-inline-block p-2 ${bubble}" style="border-radius: 10px; max-width: 70%;">
                    <strong>${name}:</strong> ${data.message}
                    <div class="text-muted
                        <small>${new Date(data.created_at).toLocaleTimeString()}</small>
                    </div>
                </div>
            </div>
          `;
        }

        $("#chatform").on('submit', function(e){
            e.preventDefault();
            const message = $("#messageInput").val().trim();
            if(!message){
                return;
            }
            $.ajax({
                url: "{{ route('user.chat.send') }}",
                method: "POST",
               data: JSON.stringify({
                to_id: adminId,
                message: message
               }),
               contentType: "application/json",
               headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }} '
                },
                success: function(response){
                    if(response.success){
                        $("#messageInput").val('');
                     const html =   $("#chatwindow").html() + messageBubble(response.data);
                            $("#chatwindow").html(html);
                            $("#chatwindow").scrollTop($("#chatwindow")[0].scrollHeight);
                     
                    } else {
                        alert('Failed to send message.');
                    }
                },
                error: function(){
                    alert('Error sending message.');
                }
            });
        });
    </script>
@endpush