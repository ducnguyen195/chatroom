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
    <script src="https://cdn.tiny.cloud/1/mk69788v7tsx0cmwwr9lyp9a26e4onnb5s9m9uk9bc4m40az/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        tinymce.init({
            selector: '#add_image',
            width:120,
            height:10,
            statusbar: false,
            plugins: [' image', 'emoticons'],
            menubar: false,
            toolbar: [' image|emoticons'],
            content_css: false,
            file_picker_callback (callback, value, meta) {
                let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth
                let y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight

                tinymce.activeEditor.windowManager.openUrl({
                    url : '/file-manager/tinymce5',
                    title : 'Laravel File manager',
                    width : x * 0.8,
                    height : y * 0.8,
                    onMessage: (api, message) => {
                        console.log(message)
                        let url = message.content;  // Lấy ra url của file ảnh
                        url = url.replace(/^.*\/\/[^\/]+/, ''); // Xóa domain ảnh
                        message.content = url // Gán lại url cho ảnh
                        callback(message.content, { text: message.text })
                    },

                })}
        });
    </script>
</head>
<body>
<div class="app h-screen w-full grid  grid-cols-6 text-base">
    {{--  Sidebar--}}
    <div class="col-span-1 w-full h-full bg-[#262948] relative">
        <div class="w-full py-8 px-4">
            <div class="flex justify-start items-center gap-4">
                <div class="w-12 h-12 rounded-full">
                    @include('components.avatar',['avatar_path'=>'images/avatar.jpg'])
                </div>
                <div class="font-bold text-lg text-white">
                    <p> {{Auth::user()->name}}</p>
                </div>
            </div>
        </div>
        <div class="w-full py-4 px-6 text-white font-semibold">
            <div class="flex justify-between items-center py-2">
                <a class="flex justify-start items-center gap-4 hover:text-blue-400" href="#">
                    <i class="fa-solid fa-house"></i>
                    <p>Dashboard</p>
                </a>
            </div>
            <div class="flex justify-between items-center py-2">
                <a class="flex justify-start items-center gap-4 hover:text-blue-400" href="#" >
                    <i class="fa-solid fa-users"></i>
                    <p>Chat Room</p>
                </a>
                @include('components.countMessenger',['number'=> 2])
            </div>
            <div class="flex justify-between items-center py-2">
                <a class="flex justify-start items-center gap-4 hover:text-blue-400" href="#">
                    <i class="fa-solid fa-calendar-days"></i>
                    <p>Calendar</p>
                </a>
                @include('components.countMessenger',['number'=> 1])
            </div>
        </div>
        <div class="w-full absolute bottom-0 py-8 px-6 text-white font-semibold">
            <a class="flex justify-start items-center gap-4 py-2 hover:text-red-500" href="#">
                <i class="fa-solid fa-gear"></i>
                <p>Setting</p>
            </a>
            <a href="{{ route('logout') }}" class="flex justify-start items-center gap-4 py-2 hover:text-red-500"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa-solid fa-right-from-bracket"> </i>
                    <p> Logout</p>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
    {{--   End Sidebar--}}
    {{--   Rooms--}}
    <div class="col-span-5 w-full h-full bg-[#3c425e]">
        <div class="grid grid-cols-2 gap-1 h-full">
        {{--    Col 1--}}
            <div class="col-span-1 w-full h-full bg-lime-200 pl-12 pr-12 py-8 text-base">
               <div class="  text-gray-800 text-3xl flex justify-between mt-5">
                   <div class="flex justify-start gap-4">
                       <i class="fa-solid fa-users"></i>
                       <p class="font-bold">Chat Room</p>
                   </div>
                   <div class="flex gap-4">
                       <button type="button" onclick="openModal('modal_search')"> <i class="fa-solid fa-magnifying-glass"></i> </button>
                       <!-- Modal toggle -->
                       <button data-modal-target="default-modal" data-modal-toggle="default-modal" class="block dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                           <i class="fa-solid fa-plus"></i>
                       </button>
                   </div>
                   <!-- Main modal -->
                   @include('components.modalAddRoom')
               </div>
                <div class="w-full pl-4 font-bold mt-9 " id="rooms_list">
                    <p> My Room</p>
                    @foreach($rooms as $item)
                    <a href="#" class=" hover:bg-amber-300 w-full bg-[#262948] py-2 px-4 my-3 rounded-lg grid grid-cols-3 text-blue-500  gap-2  relative">
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
                            <p > {{$item -> description}}</p>
                        </div>
                        <div class="absolute  font-bold text-xs top-0 right-0  mr-2 mt-1 flex justify-end items-center gap-4">
                            <p class="text-gray-400"> 2 min ago</p>
                            @include('components.countMessenger',['number'=> 1])
                        </div>
                    </a>
                        @endforeach
                </div>
                <div class="w-full pl-4 font-bold mt-9 " id="all_rooms_list">
                    <p> All Room</p>
                    @foreach($all_rooms as $item)
                        <a href="#" class=" hover:bg-amber-300 w-full bg-[#262948] py-2 px-4 my-3 rounded-lg grid grid-cols-3 text-blue-500  gap-2  relative">
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
            <div class="col-span-1 w-full h-full bg-lime-200 text-white pl-6 pr-10">
                <div class=" flex h-1/6 items-center bg-lime-300 pt-6 pb-12 pl-12 gap-4">
                    <div class="w-10 h-9 rounded-full">
                        @include('components.avatar',['avatar_path'=>'images/avatar.jpg'])
                    </div>
                    <div class=" relative w-full">
                        <p class="font-bold text-blue-500  ">
                            {{$item->name}}
                        </p>
                        <p class=" absolute bottom-0 left-0  top-8 font-bold text-xs text-gray-400"> Active 2 minutes ago</p>
                    </div>
                </div>
                <div class=" relative ml-12 w-auto  h-4/5  bg-lime-200">
                    <div class=" flex-wrap overflow-y-scroll ">
                        <div class="w-2/3 h-20  bg-[#262948] mt-5  rounded-lg">
                          <div>
                              <p class="text-gray-300 py-3 pl-10 ">aaaaaaaaaaa</p>
                              <p class="text-gray-300 text-xs flex flex-row-reverse pr-4"> 2 minutes ago </p>
                          </div>
                        </div>
                        <div class="w-full  mt-5  rounded-lg flex flex-row-reverse ">
                           <div class="w-2/3 h-20 bg-amber-100 rounded-lg">
                               <p class="text-gray-500 py-3 pl-10 ">aaaaaaaaaaa</p>
                               <p class="text-gray-500 text-xs flex flex-row-reverse pr-4"> 2 minutes ago </p>
                           </div>
                        </div>
                    </div>
                    <div class=" absolute bottom-10 w-full h-20 ">
                        <div class="bg-white rounded-full w-full">
                            <form class="flex items-center w-full" action="">
                                @csrf
                                <div>
                                    <label for="add_image"></label>
                                    <textarea name="" id="add_image" >
                                </textarea>
                                </div>
                                <div class="rounded-full border border-blue-400 w-full flex ">
                                    <label for="input-messenger"></label>
                                    <input id="input-messenger" class="text-gray-400  rounded-full border-none outline-none w-full " placeholder="Messenger" name="messenger" type="text">
                                    <button type="submit" class="text-gray-400 mr-5"  > <i class="fa-solid fa-play "></i> </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--  End Rooms--}}
</div>
@include('components.modalSearch')
<script>
    // Modal : Open and Close
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
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" ></script>
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
</script>
<script src="{{asset('js/file-manager.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" ></script>
</body>
</html>

