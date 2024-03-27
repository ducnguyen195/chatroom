<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Room_User;
use App\Models\RoomChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function message(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $user = Auth::user();
        if (!empty($user->myrooms)) {
            $myrooms =$user->myrooms;
        }
        if (!empty($user->rooms)) {
            $room = $user->rooms;
        }
        if (!empty($room)) {
            if (!empty($myrooms)) {
                $room =$room->merge($myrooms);
            }
        }
        if (!empty($room)) {
            return view('content.message',['rooms'=> $room]);
        }
    }

    public function detail(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user()->id;
        $input = $request->all();
        $room = RoomChat::find($input['roomId']);
        $message = $room->messages;
        return response()->json(['message'=> $message ,'room' => $room, 'user' => $user],200);
    }
}
