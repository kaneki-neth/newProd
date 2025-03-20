<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class RoomController extends Controller
{
    public function index(Request $request)
    {
        \Log::info($request->all());
        $room_number = '';
        $floor_number = '';
        $room_type = '';
        $status = '';

        $query = DB::table('rooms')
            ->join('room_types', 'rooms.rt_id', '=', 'room_types.rt_id')
            ->select('rooms.r_id', 'rooms.room_number', 'rooms.floor_number', 'rooms.status', 'room_types.name as room_type_name');

        if ($request->has('room_number')) {
            $query->where('rooms.room_number', 'like', '%' . $request->room_number . '%');
            $room_number = $request->room_number;
        }

        if ($request->has('floor_number')) {
            $query->where('rooms.floor_number', 'like', '%' . $request->floor_number . '%');
            $floor_number = $request->floor_number;
        }

        if ($request->has('room_type')) {
            $query->where('room_types.name', 'like', '%' . $request->room_type . '%');
            $room_type = $request->room_type;
        }

        $status = $request->input('status');
        if ($request->has('status')) {
            $query->where('rooms.status', 'like', '%' . $request->status . '%');
            $status = $request->status;
        }

        $rooms = $query
            ->orderBy('rooms.room_number', 'asc')
            ->paginate(10);

        $statuses = DB::table('rooms')->distinct()->pluck('status');

        return view('rooms.index', compact('room_number', 'floor_number', 'room_type', 'status', 'rooms', 'statuses'));
    }
}
