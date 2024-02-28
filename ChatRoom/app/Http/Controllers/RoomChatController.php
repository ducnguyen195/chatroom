<?php

namespace App\Http\Controllers;


use App\Models\RoomChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $all_rooms =RoomChat::all();
        return view('content.roomChat',['rooms' => $rooms,'all_rooms'=>$all_rooms]);
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
        $search_room = $request->input('search_room');
        if ($search_room != ""){
            $filter = "";
            for($i=0; $i<strlen($filter);$i++){
                $filter = $filter."%".$search_room[$i];
            }
            $rooms = RoomChat::where('name','like',$filter.'%')->get();
        } else {
            $rooms = RoomChat::where('owner_id', '=' , Auth::user()->id)->get();
        }
        return response()->json($rooms,200);

    }
}
