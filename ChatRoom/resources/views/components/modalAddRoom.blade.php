<div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Create Room
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4 ">
                <form action="#" id="submitForm">
                    @csrf
                    <div class="grid ">
                        <label for="room-name" class="text-lg"> Room Name</label>
                        <input type="text" id="room-name" class="rounded-lg" name="room_name">
                    </div>
                    <div class="grid mt-2">
                        <label for="description" class="text-lg" > Description</label>
                        <input type="text" id="description" class="rounded-lg" name="description">
                    </div>
                    <label for="image_label"> Icon</label>
                    <div class="input-group text-lg  mt-2 flex ">
                        <input type="text" id="image_label" class="form-control rounded-l" name="image"
                               aria-label="Image" aria-describedby="button-image">
                        <div class="input-group-append">
                            <button class="bg-gray-200 w-20 h-10 rounded-r" type="button" id="button-image">Select</button>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="flex mt-5 items-center p-4 mt:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button data-modal-hide="default-modal" type="submit" id="owner({{auth()->user()->id}})"  class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 flex relative ">
                            Create
                            <img class="spin-image hidden ml-2" src="{{asset('images/circle-loading.gif')}}"  alt="" width="20px" height="20px">
                        </button>
                        <button data-modal-hide="default-modal" type="button" class="ms-3 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
