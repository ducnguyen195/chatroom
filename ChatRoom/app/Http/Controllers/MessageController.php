<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\Room_User;
use App\Models\RoomChat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function message()
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

        // TODO: Room Detail;
    public function detail(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user()->id;
        $input = $request->all();
        $room = RoomChat::find($input['roomId']);
        $message = $room->messages;
        $list_member = $room->user;
        return response()->json([
            'message'=> $message ,
            'room' => $room,
            'user' => $user,
            'list_member'=>$list_member],200);
    }

        //TODO: Send message ;
    public function send(Request $request): \Illuminate\Http\JsonResponse
    {
        $input = $request->all();
        $room_id = $input['roomId'];
        $message = Message::create([
            'chatroom_id'=>$input['roomId'],
            'parent_id'=> $input['userId'],
            'user_id'=> $input['userId'],
            'content'=>$input['content'],
            'type'=> $input['type'],
        ]);
        event(new MessageSent($input,$room_id));
        return response()->json(['message'=>$message],200);

    }
        //TODO : Tag Name
    public function tagName(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();
        $id = $request->get('roomId');
        $room = RoomChat::find($id);
        $input = $request->input('input_text');
        $owner = $room->owner;
        if ($input != ""){
            $check = '';
            for ($i=0; $i < strlen($input); $i++){
                $check = $check.'%'.$input[$i];
            }
            $search_member = User::whereNotIn('id',$owner)->where('name','like'.$check.'%')->get();
        }else {
            $search_member = User::whereNotIn('id',$owner)->get();
        }
        return response()->json($search_member,200);
    }
    function image(Request $request): \Illuminate\Http\JsonResponse
    {
        if($request ->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('images', 'public');

        }
        $input = $request->all();
        $message = Message::create([
            'chatroom_id'=>$input['roomId'],
            'parent_id'=> $input['userId'],
            'user_id'=> $input['userId'],
            'content'=>$input['content'],
            'type'=> $input['type'],
        ]);

        return response()->json($message);
    }
}
