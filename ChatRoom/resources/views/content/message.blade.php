<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{asset('images/favicon.png')}}">
    <title>COMBAT </title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css"  rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    @vite('resources/css/app.css')
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
</head>
<body>
<div class="grid grid-cols-3 gap-1 w-full h-screen ">
    <div class="col-span-1  w-full h-full">
        <div class="grid grid-cols-6 gap-0 h-full relative  ">
            <div class="col-span-1 w-full h-full bg-indigo-950 ">
                <h2 class=" font-bold flex justify-center mt-3 text-amber-200"> COMBAT</h2>
                <div class="w-full mt-9 py-4 px-6 text-white font-semibold ">
                    <div class="flex justify-between items-center py-2">
                        <a class="flex justify-start items-center gap-4 hover:text-blue-400" title="Dashboard" href="#">
                            <i class="fa-solid fa-house"></i>
                            <p class=" lg:block md:hidden"></p>
                        </a>
                    </div>
                    <div class="flex justify-between items-center py-4">
                        <a class="flex justify-start items-center gap-4 hover:text-blue-400" title="Chat Room" href="#" >
                            <i class="fa-solid fa-users"></i>
                            <p class="lg:block md:hidden"></p>
                        </a>
                    </div>
                    <div class="flex justify-between items-center py-4">
                        <a class="flex justify-start items-center gap-4 hover:text-blue-400" title="Calendar" href="#">
                            <i class="fa-solid fa-calendar-days"></i>
                            <p class=" lg:block md:hidden"></p>
                        </a>
                    </div>
                </div>
                <div class="w-full absolute bottom-0 py-12 px-6 text-white font-semibold">
                    <a class="flex justify-start items-center gap-4 py-2 hover:text-red-500" title="Setting" href="#">
                        <i class="fa-solid fa-gear"></i>
                        <p class="lg:block md:hidden"></p>
                    </a>
                    <a href="{{ route('logout') }}" title="Log Out" class="flex justify-start items-center gap-4 py-2
                     hover:text-red-500"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa-solid fa-right-from-bracket"> </i>
                        <p class="lg:block md:hidden" ></p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>

            </div>
            <div class="col-span-5 w-full h-full bg-[#202441] ">
                <div class="flex justify-start items-center gap-4 p-3 w-full">
                    <div class="w-12 h-12 rounded-full">
                        @include('components.avatar',['avatar_path'=>'images/avatar.jpg'])
                    </div>
                    <div class="font-bold text-lg text-white">
                        <p class="lg:block md:hidden" > {{Auth::user()->name}}</p>
                    </div>
                </div>
                <div class="w-full pl-4 pr-2 mt-3 relative">
                    <input class="w-full focus:ring-0 border-0  rounded-lg p-1.5 pr-9" type="text">
                    <button class="absolute top-0 right-2 p-1 pr-3 text-xl " type="button"> <i class="fa-solid fa-magnifying-glass"></i> </button>
                </div>
                <div class="w-full o" >
                    <div class="w-full pl-4 font-bold mt-9 pr-2 overflow-y-auto" >
                        @foreach($rooms as $item)
                        <a href="#" onclick="joinRoomChat({{$item->id}})"  class="hover:bg-[#4289f3] w-full bg-[#262948] py-2 px-4 my-3 rounded-lg grid
                         grid-cols-3 text-white  gap-2  relative">
                            <div class="col-span-1 ">
                                <div class="flex justify-start items-center gap-4">
                                    <div class="w-9 h-9 rounded-full">
                                        @include('components.avatar',['avatar_path'=> 'images/avatar.jpg'])
                                    </div>
                                    <p class="font-bold  ">
                                        {{$item -> name}}
                                    </p>
                                </div>
                            </div>
                            <div class="col-span-2 flex items-center ">
                                <p class=" w-2/3 overflow-hidden whitespace-nowrap overflow-ellipsis" >
                                   {{$item -> description}}
                                </p>
                            </div>
                            <div class="absolute  font-bold text-xs top-0 right-0  mr-2 mt-1 flex justify-end
                             items-center gap-4">
                                <p class="text-gray-400"> 2 min ago</p>
                                @include('components.countMessenger',['number'=> 1])
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-span-2 bg-lime-100 w-full h-full overflow-y-auto">
       <div class="w-full sticky top-0 z-30 ">
           <div class="   flex border-b-2 w-full p-3 bg-lime-300 ">
               <div class=" w-12 h-11 rounded-full">
                   @include('components.avatar',['avatar_path'=>'images/avatar.jpg'])
               </div>
               <div class=" flex ml-3 relative w-full">
                   <div>
                       <p id="room_name" class="font-semibold text-xl  text-blue-600 ">
                           Hello
                       </p>
                       <p class=" absolute bottom-0 left-0  top-7 font-bold text-xs text-gray-400">
                           <i class="fa-solid fa-users"></i>
                           <span> 20</span>
                       </p>
                   </div>
                   <p class="font-bold ml-4 text-gray-600"> aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa </p>
               </div>
           </div>
       </div>
{{--        Content Message--}}
        <div class="w-full h-full grid grid-rows-4 px-4 mt-3 ">
            <div class="row-span-3 w-full overflow-y-auto end-0 flex-end  ">
                <div class="edit_hover flex self-center gap-4 ">
                    <div class="flex gap-2 ">
                        <div class="w-9 h-9 rounded-full">
                            @include('components.avatar',['avatar_path'=>'images/avatar.jpg'])
                        </div>
                        <p class="text-sm font-semibold bg-gray-200 rounded-lg p-2">
                            Chào các bạnnnnnnnnnnnn
                        </p>
                    </div>
                    @include('components.modalEditMessage')
                </div>
                <div class=" edit_hover flex self-center gap-4 flex-row-reverse  ">
                    <div class=" items-end  ">
                        <p class="text-sm font-semibold bg-gray-200 rounded-lg p-2">
                            Chào các bạn
                        </p>
                    </div>
                    @include('components.modalEditMessage')
                </div>
            </div>
            <div class="  row-span-1 w-full fixed bottom-0 box-border pl-12 p-3 bg-amber-50  ">
                <form action="#" class="flex w-full" id="messageSubmit">
                    @csrf
                    <div >
                        <label for="input_image"></label>
                        <input id="input_image" name="image" type="file">
                    </div>
                    <div class="w-full ">
                        <label for="input_message"></label>
                        <input placeholder="Aa" class=" w-2/4 rounded-full border-1 focus:ring-0" id="input_message" name="text" type="text">
                    </div>
                    <button type="submit" class="text-black" >  </button>
                </form>

            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    function openModal(modal){
        var openModal = document.getElementById(modal);
        let btnSelec = document.getElementById('btn_selector')
        openModal.classList.remove('hidden');
        openModal.classList.add('visible');
        btnSelec.classList.remove('visible');
        btnSelec.classList.add('hidden');
    }

    function joinRoomChat(roomId){
        console.log(roomId)
        $.ajax({
            url:'{{route('room.detail')}}',
            type:'POST',
            data:{
                _token: '{{csrf_token()}}',
                roomId: roomId
            },
            success:function (response){
                let user = response.user;
                let messages = response.message;
                console.log(messages)
                for(i = 0 ; i < messages.length; i++){
                    if(user === messages[i].user_id){
                        
                    }
                }
            }
        })

    }

    $(document).ready(function (){
        $('#messageSubmit').on(function (){
            $.ajax({
                url: '{{route("message.content")}}',
                type:'POST',
                data:$(this).serialize(),
            });
        })
    })

</script>
</body>
</html>
