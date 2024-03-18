<div class="hidden " id="modal_search">
    <div class= " absolute top-0 opacity-50 bg-black  w-full h-screen">
    </div>
    <div class=" absolute top-0  w-full h-screen flex justify-center">
        <div class=" w-1/3 self-start p-4 h-full relative ">
            <button onclick="closeModal('modal_search')" class="w-8 h-8 text-white hover:bg-red-500 rounded-full absolute top-0 right-0 bg-gray-200">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div class="w-full h-full bg-white p-4 rounded-lg">
                <form action="#" id="search_room_name" class="py-6 px-6">
                    @csrf
                    <h3 class="flex justify-center font-bold text-xl pb-5"> Search Room</h3>
                    <div class="relative">
                        <label for="search_room"></label>
                        <input type="text" id="search_room" name="search_room"
                               class="w-full py-1.5 border-blue-400 border-2 rounded-lg outline-none  " required>
                        <button class="absolute top-1.5 right-3 text-blue-500" ><i class="fa-solid fa-magnifying-glass"></i> </button>
                    </div>
                </form>
                <div class="px-6">
                    <h4 class="font-semibold "> Rooms</h4>
                    <div class="w-full pl-4 font-bold  " id="search_room_detail">
                        @foreach($rooms as $item)
                            <a href="#" class=" hover:bg-amber-300 w-full bg-[#262948] py-2 px-4 my-3 rounded-lg grid grid-cols-3 text-blue-500  gap-2  relative">
                                <div class="col-span-2 ">
                                    <div class="flex justify-start items-center gap-4">
                                        <div class="w-9 h-9 rounded-full">
                                            @include('components.avatar',['avatar_path'=>'images/avatar.jpg'])
                                        </div>
                                        <p class="font-bold">
                                            {{$item->name}}
                                        </p>
                                    </div>
                                </div>
                                <div class=" font-bold text-xs top-0 right-0  mr-2 mt-1 flex justify-end items-center gap-4">
                                    <button onclick="sendJoinRoom('{{$item->id}}')"> <i class="fa-solid fa-right-to-bracket"></i></button>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" ></script>
<script>
    $(document).ready(function (){
        $('#search_room_name').on('input',function (){
            console.log('a')
            $.ajax({
                url:"{{route('room.search')}}",
                type:'POST',
                data:$(this).serialize(),
            success: function (response) {
                let rooms = response;
                console.log(rooms)
                let html = "";
                for(i = 0; i < rooms.length; i++ ){
                    html += `
                        <a href="#" class=" hover:bg-amber-300 w-full bg-[#262948] py-2 px-4 my-3 rounded-lg grid grid-cols-3 text-blue-500  gap-2  relative">
                            <div class="col-span-2 ">
                                <div class="flex justify-start items-center gap-4">
                                    <div class="w-9 h-9 rounded-full">
                                        <img src=" ${rooms[i].icon ?? 'images/avatar.jpg'}" alt="avatar" class="w-full h-full rounded-full border-2 border-red-500" />
                                    </div>
                                    <p class="font-bold">
                                        ${rooms[i].name}
                                    </p>
                                </div>
                             </div>
                           <div class=" font-bold text-xs top-0 right-0  mr-2 mt-1 flex justify-end items-center gap-4">
                                    <button onclick="sendJoinRoom(${rooms[i].id})"> <i class="fa-solid fa-right-to-bracket"></i></button>
                                </div>
                         </a> `
                }
                if(rooms.length === 0){
                    html = `<p class="font-bold text-red-500 flex justify-center">
                    Room not found !
                    </p>`
                }
                $('#search_room_detail').html(html);
            },
            error: function (error){
                    console.log(error)
            },
            })
        });
    });
    function sendJoinRoom(room_id) {
        console.log('aaaaa',room_id);
        $.ajax({
            url:"{{route('room.join')}}",
            type:'POST',
            data:{
                _token: '{{csrf_token()}}',
                room_id: room_id
            },
            success:function (response){
                turnOnNotification(response.message,'success');
                const room = response.room;
                if(!room) return
                const html = `
                    <a href="#" class=" hover:bg-amber-300 w-full bg-[#262948] py-2 px-4 my-3 rounded-lg grid grid-cols-3 text-blue-500  gap-2  relative">
                        <div class="col-span-1 ">
                            <div class="flex justify-start items-center gap-4">
                                <div class="w-9 h-9 rounded-full">
                                    @include('components.avatar',['avatar_path'=>'images/avatar.jpg'])
                                </div>
                                <p class="font-bold  ">
                                    ${room.name}
                                </p>
                            </div>
                        </div>
                        <div class="col-span-2 flex items-center ">
                            <p > ${room.description}</p>
                        </div>
                     </a>`
                const joinedRoomList = document.getElementById('join_rooms_list')
                if (joinedRoomList) joinedRoomList.innerHTML +=html;
                // Remove this room out of search result list
                const searchRoomResultElement = document.getElementById("search_room_detail-"+room.id);
                if (searchRoomResultElement) searchRoomResultElement.remove();
            },
            error: function(error) {
                turnOnNotification(error.message, "error");
            },
        });
    }
</script>
