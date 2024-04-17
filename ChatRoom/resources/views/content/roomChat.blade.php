<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{asset('images/favicon.png')}}">
    <title>COMBAT </title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css"  rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite('resources/css/app.css')
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
{{--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">--}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
    <script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
</head>
<body>
<div class="app h-screen lg:w-full grid  grid-cols-6 text-base  md:w-10 sm:w-10" >
    {{--  Sidebar--}}
    <div class="col-span-1 w-full h-full bg-[#262948] relative">
        <div class="w-full py-8 px-4">
            <div class="flex justify-start items-center gap-4">
                <div class="w-12 h-12 rounded-full">
                    @include('components.avatar',['avatar_path'=>'images/avatar.jpg'])
                </div>
                <div class="font-bold text-lg text-white">
                    <p class="lg:block md:hidden" > {{Auth::user()->name}}</p>
                </div>
            </div>
        </div>
        <div class="w-full py-4 px-6 text-white font-semibold ">
            <div class="flex justify-between items-center py-2">
                <a class="flex justify-start items-center gap-4 hover:text-blue-400" href="#">
                    <i class="fa-solid fa-house"></i>
                    <p class=" lg:block md:hidden">Dashboard</p>
                </a>
            </div>
            <div class="flex justify-between items-center py-2">
                <a class="flex justify-start items-center gap-4 hover:text-blue-400" href="#" >
                    <i class="fa-solid fa-users"></i>
                    <p class="lg:block md:hidden">Chat Room</p>
                </a>
                @include('components.countMessenger',['number'=> 2])
            </div>
            <div class="flex justify-between items-center py-2">
                <a class="flex justify-start items-center gap-4 hover:text-blue-400" href="#">
                    <i class="fa-solid fa-calendar-days"></i>
                    <p class=" lg:block md:hidden">Calendar</p>
                </a>
                @include('components.countMessenger',['number'=> 1])
            </div>
        </div>
        <div class="w-full absolute bottom-0 py-8 px-6 text-white font-semibold">
            <a class="flex justify-start items-center gap-4 py-2 hover:text-red-500" href="#">
                <i class="fa-solid fa-gear"></i>
                <p class="lg:block md:hidden">Setting</p>
            </a>
            <a href="{{ route('logout') }}" class="flex justify-start items-center gap-4 py-2 hover:text-red-500"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa-solid fa-right-from-bracket"> </i>
                    <p class="lg:block md:hidden" > Logout</p>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
    {{--   End Sidebar--}}
    {{--   Rooms--}}
    <div class="col-span-5 w-full h-full bg-[#3c425e]">
        <div class="grid grid-cols-3 gap-1 h-full">
        {{--    Col 1--}}
            <div class="col-span-2 w-full h-full bg-lime-200 pl-12 pr-12 py-8 text-base">
               <div class=" text-gray-800 text-3xl flex justify-between mt-5">
                   <div class="flex justify-start gap-4">
                       <i class="fa-solid fa-users"></i>
                       <p class="font-bold">Chat Room</p>
                   </div>
                   <div class="flex gap-4">
                       <button type="button" onclick="openModal('modal_search')"> <i class="fa-solid fa-magnifying-glass"></i> </button>
                       <!-- Modal toggle -->
                       <button data-modal-target="default-modal" data-modal-toggle="default-modal" class="block  dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                           <i class="fa-solid fa-plus"></i>
                       </button>
                   </div>
                   <!-- Main modal -->
                   @include('components.modalAddRoom')
               </div>
                <div class="w-full pl-4 font-bold mt-9 " id="rooms_list">
                    <p> My Room</p>
                    @foreach($rooms as $item)
                    <a href="#" onclick="openRoomChat('{{$item->id}}')" class="hover:bg-amber-300 w-full bg-[#262948] py-2 px-4 my-3 rounded-lg grid grid-cols-3 text-blue-500  gap-2  relative">
                        <div class="col-span-1 ">
                            <div class="flex justify-start items-center gap-4">
                                <div class="w-9 h-9 rounded-full">
                                    @include('components.avatar',['avatar_path'=>'images/avatar.jpg'])
                                </div>
                                <p class="font-bold  ">
                                    {{$item->name}}
                                </p>
                            </div>
                        </div>
                        <div class="col-span-2 flex items-center ">
                            <p class="overscroll-auto" > {{$item -> description}}</p>
                        </div>
                        <div class="absolute  font-bold text-xs top-0 right-0  mr-2 mt-1 flex justify-end items-center gap-4">
                            <p class="text-gray-400"> 2 min ago</p>
                            @include('components.countMessenger',['number'=> 1])
                        </div>
                    </a>
                        @endforeach
                </div>
                <div class="w-full pl-4 font-bold mt-9 " id="join_rooms_list">
                    <p> Join Room</p>
                    @foreach($join_rooms_list as $item)
                        <a href="#" onclick="openRoomChat('{{$item->id}}')"  class=" hover:bg-amber-300 w-full bg-[#262948] py-2 px-4 my-3 rounded-lg grid grid-cols-3 text-blue-500  gap-2  relative">
                            <div class="col-span-1 flex ">
                                <div class="flex justify-start items-center gap-4">
                                    <div class="w-9 h-9 rounded-full">
                                        @include('components.avatar',['avatar_path'=>'images/avatar.jpg'])
                                    </div>
                                    <p class="font-bold  ">
                                        {{$item->name}}
                                    </p>
                                </div>

                            </div>
                            <div class="col-span-2 flex items-center ">
                                <p > {{$item -> description}}</p>
                            </div>
                            <div class="absolute  font-bold text-xs top-0 right-0  mr-2 mt-1 flex justify-end items-center gap-4">
                                <p class="text-gray-400"> 2 min ago</p>
                                @include('components.countMessenger',['number'=> 1])
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            <div  class=" col-span-1 w-full h-full bg-lime-200 text-white pl-6 pr-10">
               <div id="member" class="hidden w-full">
                   <div class=" flex h-1/6  bg-lime-300 pt-6 pb-12 pl-12 gap-4">
                       <div class=" w-32 h-16 rounded-full">
                           @include('components.avatar',['avatar_path'=>'images/avatar.jpg'])
                       </div>
                       <div class=" relative w-full">
                           <p id="room_name" class="font-bold text-xl  text-blue-500 ">
                            {{--   Room Name--}}
                           </p>
                           <p class=" absolute bottom-0 left-0  top-8 font-bold text-xs text-gray-400">
                               <i class="fa-solid fa-users"></i>
                               <span> 20</span>
                           </p>
                       </div>
                       <div class="grid gap-3 pr-4">
                           <button  class="text-blue-600 hover:text-emerald-400 text-xl" title="Join Room" >
                               <a id="room_id" href="{{route('room.message')}}">  <i class="fa-brands fa-facebook-messenger"></i> </a>
                           </button>
                           <button class="text-red-400" title="Out Room"> <i class="fa-solid fa-right-from-bracket"></i> </button>
                       </div>
                   </div>
                   <div class=" relative mt-3 mx-3 ">
                       <input type="text" class=" pr-12 text-black focus:ring-0  rounded-lg w-full border-0  ">
                       <button class="absolute top-0 right-0 h-full flex pr-4  ">
                           <i class="fa-solid fa-magnifying-glass self-center text-gray-500 text-xl"></i>
                       </button>
                   </div>
                   <div id="list_member" class=" px-10 py-2 relative mt-3  w-auto  h-96  bg-gray-100 rounded-lg overscroll-none overflow-y-auto">
                                {{--List Member--}}
                   </div>
               </div>
            </div>
        </div>
    </div>
    {{--  End Rooms--}}
</div>
@include('components.notification')
@include('components.modalSearch')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" ></script>
<script>
    //TODO  Modal : Open and Close
    function openModal(modal_id){
        let openFormModal = document.getElementById(modal_id);
        openFormModal.classList.remove('hidden');
        openFormModal.classList.add('visible');
    }
    function closeModal(modal_id) {
        let closeFormModal = document.getElementById(modal_id);
        closeFormModal.classList.remove('visible');
        closeFormModal.classList.add('hidden');
    }
    // TODO: Message notification
    function turnOnNotification (message ,type) {
        const notification = document.getElementById('notification-'+type);
        const notificationMessenger = document.getElementById('notification-' + type + '-message');
        notificationMessenger.innerText = message;
        notification.classList.remove('hidden');
        notification.classList.add('visible');
        setTimeout(function () {
           notification.classList.remove('visible');
           notification.classList.add('hidden');
        },3000);
    }
</script>


<script>
   $(document).ready(function (){
        $('#submitForm').submit(function (e){
            e.preventDefault();
            $.ajax({
                url:"{{route('room.store')}}",
                type:'POST',
                data:$(this).serialize(),
                beforeSend: function () {
                    $('.spin-image').css('display', 'block');
                },
                success:function (response){
                   if(response.icon == null){
                       response.icon = '/images/avatar.jpg';
                   }
                   if(response.description == null){
                        response.description = '';
                   }
                   let html = '';
                   html +=
                       `
                       <a href="#" class=" hover:bg-amber-300 w-full bg-[#262948] py-2 px-4 my-3 rounded-lg grid grid-cols-3 text-blue-500  gap-2  relative">
                            <div class="col-span-1 flex ">
                                <div class="flex justify-start items-center gap-4">
                                    <div class="w-9 h-9 rounded-full">
                                        <img src=" ${response.icon}" alt="avatar" class="w-full h-full rounded-full border-2 border-red-500" />
                                     </div>
                               </div>
                               <p class="font-bold  ">
                                     ${response.name}
                               </p>
                            </div>
                           <div class="col-span-2 flex items-center ">
                                <p > ${response.description}</p>
                           </div>
                         <div class="absolute  font-bold text-xs top-0 right-0  mr-2 mt-1 flex justify-end items-center gap-4">
                            <p class="text-gray-400"> 2 min ago</p>
                            <button class="w-5 h-5 text-sm bg-red-500 rounded-full text-white">1</button>
                         </div>
                        </a>`;
                    $('#rooms_list,#all_rooms_list').prepend(html);
                },
                error: function (err){
                    console.log("eee", err)
                   alert(err.message)
                },
            })
        });
   });
   function openRoomChat(roomId){
       console.log('aaaa',roomId);
       $.ajax({
          url:"{{route('room.open')}}",
           type:'POST',
           data:{
              _token:'{{csrf_token()}}',
               roomId:roomId
           },
           success:function (response){
               let roomName = response.roomName;
               console.log(roomName.name)
               let room_name = document.getElementById('room_name');
               room_name.innerText = roomName.name;
               let member = response.member;
               const openMember = document.getElementById('member');
               openMember.classList.remove('hidden');
               let html = '';
               console.log(member);
               for (i = 0; i < member.length; i++) {
                   html += `<div class="w-full  bg-[#262948] mt-3  rounded-lg">
                                <div class="flex  px-3 py-1.5">
                                    <p class="text-gray-300 w-8 h-8  ">
                                        @include('components.avatar',['avatar_path'=>'images/avatar.jpg'])
                                    </p>
                                    <p class="text-gray-300 text-xs flex items-center pl-2"> ${member[i].name} </p>
                                </div>
                            </div>`
               }
               $('#list_member').html(html);
           },
           error: function (error){
               console.log(error);
           }
       });
   }

</script>
<script src="{{asset('js/file-manager.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" ></script>
</body>
</html>

