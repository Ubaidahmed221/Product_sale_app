@extends('layouts.admin-layout')

@section('content')
    <h2 class="mb-4">Chat Message </h2>
    <div class="container-fluid">
        <div class="row overflow-hidden" style="height: 85vh;">
            <!-- Sidebar -->
            <div class="col-md-3 border-end p-0">
                <div class="p-3 border-bottom"><strong>Conversations</strong></div>
                <ul class="list-group list-group-flush" id="userList" style="height: calc(85vh - 60px); overflow-y:auto;">
                </ul>
            </div>

            <!-- Chat -->
            <div class="col-md-9 d-flex flex-column p-0">
                <div id="chatHeader" class="p-3 border-bottom">
                    <span class="text-muted">Select a user to start chatting</span>
                </div>

                <div id="chatWindow" class="flex-grow-1 p-3 overflow-auto" style="max-height: 70vh;;"></div>
                {{-- <div id="chatWindow" class="flex-grow-1 p-3"  style="overflow-y:auto;"></div> --}}

                <div class="p-3 border-top">
                    <form id="chatForm" class="d-flex">
                        <input type="hidden" id="to_id">
                        <input type="text" id="messageInput" class="form-control me-2" placeholder="Type a message..."
                            autocomplete="off">
                        <button type="submit" class="btn btn-primary">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

  
    @endsection 
    @push('script')
        <script>
            const authid = {{ auth()->id() }};

             //  Load Messages of User
        function messageBubble(data){
            const mine = data.from_id === authid;
          const align =  mine ? 'd-flex justify-content-end' : 'd-flex justify-content-start';
          const bubble = mine ? 'text-light bg-dark' : 'bg-light';
          const name =  mine ? 'You' : data.sender.name;
            console.log(data);
          return `
            <div class="mb-2 ${align}">
                <div>
                <div class="small text-muted" >${name}</div>
                <span class="d-inline-block px-3 py-2 rounded ${bubble}" style=" max-width: 100%;">${data.message}</span>
               </div>
                </div>
                `;
              
        }
          function loadMessages(userid){
            $.ajax({
                url: "{{ route('admin.chat.message',':id') }}".replace(':id', userid),
                method: "GET",
                success: function(response){
                    if(response.success){
                        console.log(response);
                          $("#chatWindow").html(
                            response.data.map(messageBubble).join('') || 
                            '<p class=" text-muted">No messages yet. Start the conversation!</p>');
                            // $("#chatwindow").html(html);
                            // $("#chatwindow").scrollTop($("#chatwindow")[0].scrollHeight);
                             const el = $("#chatWindow");
                            el.scrollTop(el[0].scrollHeight);
                            //  const el = $("#chatwindow");
                            // if (el.length > 0) {
                            //     el.scrollTop(el[0].scrollHeight);
                            // }

                            $.ajax({
                url: "{{ route('user.messages.read',':id') }}".replace(':id', userid),
                method: "POST",
               headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }} '
                },
                success: function(response){
                    if(response.success){
                      
                     
                    } else {
                        alert('Failed to send message.');
                    }
                },
                error: function(){
                    alert('Error sending message.');
                }
            });
                     } else {
                        alert('Failed to load messages.');
                    }
                },
                error: function(){
                    alert('Error loading messages.');
                }
            });
        }

            function formChatDate(created_at){
                const date = new Date(created_at);
                const now = new Date();
                const isToday = new Date(now.getFullYear(), now.getMonth(), now.getDate());
                const yesterday = new Date(isToday);
                yesterday.setDate(isToday.getDate() - 1);
                const messageDate = new Date(date.getFullYear(), date.getMonth(), date.getDate());
                if(messageDate.getTime() === isToday.getTime()){
                    return date.toLocaleTimeString([],{
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: true
                    });

                }
                else if(messageDate.getTime() === yesterday.getTime()){
                    return "Yesterday"
                }
                else{
                    return date.getDate().toString().padStart(2,'0')+'-'+(date.getMonth() + 1).toString().padStart(2,'0')+ '-' +
                    date.getFullYear();
                }

            }

                function userItemTeplate(u){
                    const lastText = u.last_message ?  u.last_message.text : 'No message yet';
                    const lastAt = u.last_message ? u.last_message.time : '';

                                return `<li class="list-group-item list-group-item-action d-flex justify-content-between align-items-start user-item" data-id="${u.id}" >
                    <div class="ms-2 me-auto">
                        <div class="fw-bold"> ${u.name}</div>
                        <small class="text-muted text-truncate d-block" style="max-width: 220px;">${lastText} </small>
                    </div>
                    <small class="text-muted">${lastAt} </small>
                </li>`;

            }
           
              function loadUsers(){
                $.ajax({
                    url: "{{ route('admin.chat.users') }}",
                    method: "GET",
                    success: function(response){
                        if(response.success){
                            console.log(response.data);
                        const html =  response.data.map(userItemTeplate).join('');
                            $('#userList').html(html);

                            $('.user-item').off('click').on('click', function(){
                            var selectedUserId = $(this).data('id');
                            var selectedUserName = $(this).find('.fw-bold').text();
                            $('#to_id').val(selectedUserId);
                            $('#chatHeader').html(`<strong>Chatting with  ${selectedUserName}</strong>`);
                                loadMessages(selectedUserId);
                            });
                        } else {
                            alert('Failed to load messages.');
                        }
                    },
                    error: function(){
                        alert('Error loading messages.');
                    }
                });
        }
        loadUsers();

        // send message
           $("#chatForm").on('submit', function(e){
            e.preventDefault();
            const message = $("#messageInput").val().trim();
            if(!message){
                return;
            }
            console.log(message);
          const to_id =  $("#to_id").val(); 
            if(!to_id){
                alert('Please select a user to chat with.');
                return;
            }
            $.ajax({
                url: "{{ route('admin.chat.send.message') }}",
                method: "POST",
               data: JSON.stringify({
                to_id: to_id,
                message: message
               }),
               contentType: "application/json",
               headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }} '
                },
                success: function(response){
                    if(response.success){
                        $("#messageInput").val('');
                     const html =   $("#chatWindow").html() + messageBubble(response.data);
                            $("#chatWindow").html(html);
                           const el = $("#chatWindow");
                            el.scrollTop(el[0].scrollHeight);
                        loadUsers();
                    } else {
                        alert('Failed to send message.');
                    }
                },
                error: function(){
                    alert('Error sending message.');
                }
            });
        });
        document.addEventListener('DOMContentLoaded', () => {
    const authId = {{ auth()->id() }};
    console.log('Subscribing to private channel chat.' + authId);

    if (!window.Echo) {
        console.error('Echo not loaded yet');
        return;
    }

    window.Echo.private(`chat.${authId}`)
        .listen('.message.sent', (e) => {
          
             console.log('Message:', e);
             const messagehtml =   messageBubble(e);
             $("#chatWindow").append(messagehtml);
               const el = $("#chatWindow");
             el.scrollTop(el[0].scrollHeight);
              loadUsers();
        })
        .error((err) => console.error('Echo error:', err));
});
        </script>
    @endpush
    <style>
  #chatWindow {
      scroll-behavior: smooth;
  }
</style>
