<?php

namespace App\Http\Controllers;


use App\Models\Room_User;
use App\Models\RoomChat;
use App\Models\User;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Psy\Util\Json;

class RoomChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $rooms = RoomChat::where('owner_id','=',Auth::user()->id)->get();
        $join_rooms_list = Auth::user()->rooms ;
        return view('content.roomChat',['rooms' => $rooms, 'join_rooms_list' => $join_rooms_list]);
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {

        $new_room = new  RoomChat();
        $input = $request->all();
        $new_room ['name'] = $input ['room_name'];
        $new_room ['description'] = $input ['description'];
        $new_room ['icon'] = $input ['image'];
        $new_room ['owner_id'] = auth()->user()->id;
        $new_room->save();
        return response()->json($new_room,200) ;

    }
    public function search(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();
        $search_room = $request->input('search_room');
        $user ? $owner_room_id = $user->myrooms->pluck('id') : $owner_room_id = [];
        $join_room_id = $user->rooms->pluck('id');
        $join_room_id = $join_room_id->merge($owner_room_id);
        if ($search_room != ""){
            $filter = "";
            for($i=0; $i<strlen($search_room);$i++){
                $filter = $filter."%".$search_room[$i];
            }
            $rooms = RoomChat::whereNotIn('id',$join_room_id)->where('name','like',$filter.'%')->get();
        } else {
            $rooms = RoomChat::whereNotIn('id',$join_room_id)->get();
        }
        return response()->json($rooms,200);

    }

    public function join(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();
        $input = $request->all();
        $room = RoomChat::find($input['room_id']);
        if($user && $room){
            $room->users()->attach($user->id);
        }
        $message = 'You have joined the room';
        return response()->json(['message'=>$message,'room'=>$room],200 );
    }

    public function open(Request $request): \Illuminate\Http\JsonResponse
    {
        $input = $request->all();
        $room = RoomChat::find($input['roomId']);
        $member = $room->users->all();
        $owner = $room->owner;


        return response()->json(['member'=>$member , 'room_name'=> $owner]);
    }

}
