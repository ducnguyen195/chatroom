<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{asset('images/favicon.png')}}">
    <title>COMBAT </title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css"  rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
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
                   <div class="flex self-center">
                       <div class="w-12 h-12 rounded-full ">
                           @include('components.avatar',['avatar_path'=>'images/avatar.jpg'])
                       </div>
                       <div class="font-bold text-lg text-white flex self-center">
                           <p class="lg:block md:hidden" > {{Auth::user()->name}}</p>
                       </div>
                   </div>

                </div>
                <div class="w-full pl-4 pr-2 mt-3 relative">
                    <input class="w-full focus:ring-0 border-0  rounded-lg p-1.5 pr-9" type="text">
                    <button class="absolute top-0 right-2 p-1 pr-3 text-xl " type="button"> <i class="fa-solid fa-magnifying-glass"></i> </button>
                </div>
                <div class="w-full " >
                    <div class="w-full pl-4 font-bold mt-9 pr-2 overflow-y-auto" >
                        @foreach($rooms as $item)
                        <a href="#" onclick="joinRoomChat({{$item->id}})"  class="hover:bg-[#4289f3] w-full bg-[#262948] py-2 px-4 my-3 rounded-lg grid
                         grid-cols-3 text-white  gap-2  relative ">
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
                            <div class="col-span-2 flex items-center  ">
                                <p class=" w-2/3 overflow-hidden whitespace-nowrap overflow-ellipsis" >
                                   {{$item -> description}}
                                </p>
                            </div>
                            <div class="absolute font-bold text-xs top-0 right-0  mr-2 mt-1 flex justify-end
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
    <div id="room_message_body" class="hidden  col-span-2 bg-lime-100 w-full h-full overflow-y-auto">
       <div class=" w-full sticky top-0 z-30 ">
           <div class="   flex border-b-2 w-full p-3 bg-lime-300 ">
               <div class=" w-12 h-11 rounded-full">
                   @include('components.avatar',['avatar_path'=>'images/avatar.jpg'])
               </div>
               <div class=" flex ml-3 relative w-full">
                   <div>
                       <p id="room_name" class="font-semibold text-xl  text-blue-600 ">

                       </p>
                       <p class=" absolute bottom-0 left-0  top-7 font-bold text-xs text-gray-400">
                           <i class="fa-solid fa-users"></i>
                           <span> 20</span>
                       </p>
                   </div>
                   <p id="room_description" class="font-bold ml-4 text-gray-600">  </p>
               </div>
           </div>
       </div>
{{--        Content Message--}}
        <div class="w-full h-full grid grid-rows-4 px-4 mt-3 ">
            <div id="message_text" class="message_image row-span-3 w-full overflow-y-auto end-0 flex-end  ">
                {{-- Message Content--}}
            </div>
            <div id="formMessage" class="  row-span-1 w-[64%] fixed bottom-0 box-border pl-12 p-3 bg-amber-50 flex flex-end  ">
                <div  class="flex w-full  " id="messageSubmit">
                    <div >
                        <label for="input_image"></label>
                        <a class="text-2xl flex self-center hover:cursor-pointer" onclick="document.getElementById('input_image').click()"> <i class="fa-solid fa-image"></i> </a>
                        <input id="input_image" onchange="readUrl(this)" class="hidden" accept="image/*" name="content" type="file">
                    </div>
                    <div class="w-full ml-8 ">
                        <label for="input_message " ></label>
                        <input placeholder="" class=" w-5/6 rounded-full border-1 focus:ring-0"
                               id="input_text" name="content" type="text" >

                    </div>

                    <button type="submit" class="text-black"  onclick="sendMessage()"  > Send </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    function openModal(modal_id){
        var openModal = document.getElementById(modal_id);
        let btnSelec = document.getElementById('btn_selector')
        openModal.classList.remove('hidden');
        openModal.classList.add('visible');
        btnSelec.classList.remove('visible');
        btnSelec.classList.add('hidden');
    }

    function readUrl(input){
        if(input.file && input.file[0]){
            const newImage = new fileImage()
            newImage.onload =function (e){
                $('#imageUrl').attr('src',e.target.result)
            };
            newImage.readAsDataURL(input.file[0]);
        }
    }
        // Join room chat
    function joinRoomChat(roomId){
        console.log(roomId)
        $.ajax({
            url:'{{route('room.detail')}}',
            type:'GET',
            data:{
                _token: '{{csrf_token()}}',
                roomId: roomId
            },
            success:function (response){
                let openRoom = document.getElementById('room_message_body');
                openRoom.classList.remove('hidden');
                openRoom.classList.add('visible');
                const user = response.user;
                const rooms = response.room;
                const messages = response.message;
                let messText = '';
                let formMess  =`
                    <div class="flex w-full  " id="messageSubmit">
                        <div id="formMessage" >
                            <label for="input_image"></label>
                            <a class="text-2xl flex self-center hover:cursor-pointer"
                            onclick="document.getElementById('input_image').click()"> <i class="fa-solid fa-image"></i> </a>
                            <input id="input_image" oninput="image(event,${rooms.id})" class="hidden" accept="image/*" name="image" type="file">
                        </div>
                        <div class="w-full ml-8 relative ">
                            <label for="input_message " ></label>
                            <input  placeholder="Aassss" class=" w-5/6 rounded-full border-1 focus:ring-0"
                                   id="input_text" oninput="tagNameFun(${rooms.id})" name="content" type="text" >
                            <div id="list_name" class=" hidden absolute bottom-10 left-10 bg-white w-72 rounded border-2 p-3 ">
                                <div class="hover:bg-gray-200"> <a href="" class="p-2">  </a></div>
                            </div>
                        </div>
                        <button type="submit" class="text-black" onclick="sendMessage(${rooms.id})"  > Send </button>
                    </div>
                    `
                for(i = 0 ; i < messages.length; i++){
                    if(user === messages[i].parent_id){
                        if(messages[i].type === 'text'){
                             messText +=`
                                <div  class=" edit_hover   w-full mt-2 flex self-center gap-4 flex-row-reverse  ">
                                    <div class=" items-end  ">
                                        <p  class="text-sm font-semibold  bg-blue-500 rounded-lg p-2">
                                            ${messages[i].content}
                                        </p>
                                    </div>
                                    @include('components.modalEditMessage')
                                </div>`
                        }else{
                             messText += `
                                <div  class=" edit_hover w-full mt-2 flex self-center gap-4 flex-row-reverse   ">
                                    <div class=" items-end  ">
                                        <p  class="text-sm font-semibold  rounded-lg p-2">
                                            <?php ?>
                                            <img src="http://chat.th${messages[i].content}" width="100" height="100">
                                        </p>
                                    </div>
                                    @include('components.modalEditMessage')
                                </div>`
                        }
                    }else
                        if(messages[i].type === 'text'){
                        messText += `
                            <div class="edit_hover mt-2 flex self-center gap-4 ">
                                <div class="flex gap-2 ">
                                    <div class="w-9 h-9 rounded-full">
                                        @include('components.avatar',['avatar_path'=>'images/avatar.jpg'])
                                    </div>
                                    <p  class="text-sm font-semibold bg-gray-200 rounded-lg p-2">
                                         ${messages[i].content}
                                    </p>
                                </div>
                                @include('components.modalEditMessage')
                            </div>`
                        } else {
                            messText +=`
                                <div class="edit_hover mt-2 flex self-center gap-4 ">
                                    <div class="flex gap-2 ">
                                        <div class="w-9 h-9 rounded-full">
                                            @include('components.avatar',['avatar_path'=>'images/avatar.jpg'])
                                        </div>
                                        <p class="text-sm font-semibold bg-gray-200 rounded-lg">
                                            <img src="http://chat.th${messages[i].content}" width="150" height="150" alt="">
                                         </p>
                                    </div>
                                        @include('components.modalEditMessage')
                               </div>`
                          }
                    }
                $('#room_name').text(rooms.name);
                $('#room_description').text(rooms.description);
               $('#message_text').html(messText);
               $('#formMessage').html(formMess);
            }
        })
        //TODO: CHANEL PUSHER
        Pusher.logToConsole = false;
        var pusher = new Pusher('817d365934170d0dc95f', {
            cluster: 'ap1'
        });
        var channel = pusher.subscribe('my-channel_'+ roomId);
        channel.bind('my-event', function(data) {
            let html = '';
            let user_id = {{Auth::user()->id}};
            user_id = user_id.toString();
            if( user_id === data.message.userId){
                console.log("Data message: ", data.message.content)
                if(data.message.type === 'text'){
                    html = `
                    <div class=" edit_hover  w-full mt-2 flex self-center gap-4 flex-row-reverse  ">
                        <div class=" items-end  ">
                            <p  class="text-sm font-semibold bg-blue-500 rounded-lg p-2">
                                ${data.message.content}
                            </p>
                        </div>
                        @include('components.modalEditMessage')
                    </div>
                    `
                } else {
                    html = `
                     <div class=" edit_hover w-full mt-2 flex self-center gap-4 flex-row-reverse   ">
                        <div class=" items-end  ">
                            <p  class="text-sm font-semibold rounded-lg p-2">
                            <img src="http://chat.th${data.message.content}" width="100" height="100">
                            </p>
                        </div>
                        @include('components.modalEditMessage')
                    </div>
                    `
                }
            } else {
                if(data.message.type === 'text'){
                    html = `
                        <div class="edit_hover mt-2 flex self-center gap-4 ">
                            <div class="flex gap-2 ">
                                <div class="w-9 h-9 rounded-full">
                                    @include('components.avatar',['avatar_path'=>'images/avatar.jpg'])
                    </div>
                    <p class="text-sm font-semibold bg-gray-200 rounded-lg p-2">
                            ${data.message.content}
                            </p>
                            </div>
                            @include('components.modalEditMessage')
                    </div>`
                } else {
                    html =`
                        <div class="edit_hover mt-2 flex self-center gap-4 ">
                            <div class="flex gap-2 ">
                                <div class="w-9 h-9 rounded-full">
                                    @include('components.avatar',['avatar_path'=>'images/avatar.jpg'])
                    </div>
                    <p class="text-sm font-semibold bg-gray-200 rounded-lg">
                    <img src="http://chat.th${data.message.content}" width="150" height="150" alt="">
                                 </p>
                            </div>
                                @include('components.modalEditMessage')
                    </div>`
                }
            }
            let newMessage = document.getElementById('message_text');
            newMessage.innerHTML += html;
        })
    }
        //TODO: SEND MESSAGE
    function sendMessage(roomId){
        console.log(roomId);
        let content = $('#input_text').val();

        $.ajax({
            url:'{{route('message.send')}}',
            type:'POST',
            data:{
                _token:'{{csrf_token()}}',
                roomId:roomId,
                content:content,
                type:'text',
                userId:{{Auth::user()->id}}
                },
            success:function (response){
                $('#input_text').val(null)
            },
            error: function (error) {
                console.log("err: ", error);
            },
        });
    }

        //TODO: HANDLE WHEN THE USER TYPES @
     function tagNameFun(room_id){
         let text =  document.getElementById('input_text').value;
         if(text.includes('@')){
             let name = document.getElementById('input_text').value;
             $.ajax({
                url:"{{route('message.tag_name')}}",
                 type:'POST',
                 data:{
                    _token:'{{csrf_token()}}',
                     roomId:room_id,
                     name:name,
                 },
                 success: function (response) {
                    const class_list = document.getElementById('list_name');
                          class_list.classList.remove('hidden');
                          class_list.classList.add('visible');
                    const res_name = response;
                    let html = '';
                     for(i=0; i< res_name.length; i++){
                         html +=`
                             <div class="hover:bg-gray-200" > <p  class="p-2 text-blue-500 font-bold" onclick="tagTag('${res_name[i].name}')"> ${res_name[i].name}</p></div>
                         `
                     }
                     if(res_name.length === 0){
                         html = '<div class="hover:bg-gray-200"> <a href="" class="p-2"> NO NAME BRO</a></div>'
                     }
                     $('#list_name').html(html);
                 },
                 error:function (error) {
                     console.log(error);
                 }
             });
         } else {
         }
     }

        //TODO : TAKE VALUE AND ADD INPUT
     function tagTag(name){
         console.log(name);
         let tag_name = document.getElementById('input_text');
         tag_name.value = tag_name.value.slice(0,-1) + name;
         const class_list = document.getElementById('list_name');
         class_list.classList.remove('visible');
         class_list.classList.add('hidden');
     }

        //TODO: CALL API SAVE IMAGE
     function image(e,roomId){
         let url = e.target.value;
            url = url.substring(2);
         console.log(url);
         console.log(roomId);
         if(url !== "") {
             $.ajax({
                 url:'{{route('message.image')}}',
                 type: 'POST',
                 data:{
                     _token:'{{csrf_token()}}',
                     content: url,
                     type: 'image',
                     userId: {{Auth::user()->id}},
                     roomId:roomId,
                 },
                 success: function (response) {
                     console.log(response)
                 },
                 error: function (error) {
                     console.log(error)
                 }
             })
         }
     }


</script>
</body>
</html>
