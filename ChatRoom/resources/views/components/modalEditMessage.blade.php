<div class="div_edit">
    <button id="btn_selector" onclick="openModal('edit_message_{{$item->id}}')" class= "text-xl">
        <i class="fa-solid fa-ellipsis-vertical"></i>
    </button>
    <div class="">
        <div id="edit_message_{{$item->id}}" class=" hidden w-22 h-22 bg-gray-100 p-2 rounded-lg shadow">
            <ul class="font-bold text-xs">
                <li>
                    <button class="p-2 rounded-lg hover:bg-gray-200" >
                        <a href="#" class="flex gap-2 justify-center hover:text-red-500">
                            <i class="fa-solid fa-pen-to-square text-green-400"></i>
                            <p> Edit</p>
                        </a>
                    </button>
                </li>
                <li class="mt-2">
                    <button class="p-2 rounded-lg hover:bg-gray-200">
                        <a href="#" class="flex gap-2 -center hover:text-red-500">
                            <i class="fa-solid fa-trash text-red-500"></i>
                            <p>Delete</p>
                        </a>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</div>
