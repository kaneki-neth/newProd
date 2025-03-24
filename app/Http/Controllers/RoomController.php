<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class RoomController extends Controller
{
    public function index(Request $request)
    {
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
            ->paginate(15)
            ->appends($request->except('page'));

        $statuses = DB::table('rooms')->distinct()->pluck('status');

        return view('rooms.index', compact('room_number', 'floor_number', 'room_type', 'status', 'rooms', 'statuses'));
    }

    public function create()
    {
        $room_types = DB::table('room_types')
            ->select('room_types.rt_id', 'room_types.name')
            ->where('room_types.enabled', 1)
            ->get();

        return view('rooms.create', compact('room_types'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_number' => 'required|unique:rooms',
            'floor_number' => 'required|numeric',
            'status' => 'required',
            'room_type' => 'required'
        ], messages: [
            'room_number.required' => 'Room number is required.',
            'room_number.unique' => 'Room number already exists.',
            'floor_number.required' => 'Floor number is required.',
            'status.required' => 'Status is required.',
            'room_type.required' => 'Room type is required.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),
            ], 400);
        }

        $room_data = [
            'room_number' => $request->input('room_number'),
            'floor_number' => $request->input('floor_number'),
            'status' => $request->input('status'),
            'rt_id' => $request->input('room_type'),
            'enabled' => $request->input('enabled')
        ];

        try {
            DB::table('rooms')->insert($room_data);
            $message = 'Room created successfully.';
            session()->flash('success', $message);

            return response()->json([
                'success' => true,
                'message' => $message,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to create room.'
            ], 500);
        }
    }

    public function edit($id)
    {
        $room = DB::table('rooms')->where('r_id', $id)->first();
        $room_types = DB::table('room_types')
            ->select('room_types.rt_id', 'room_types.name')
            ->where('room_types.enabled', 1)
            ->get();

        return view('rooms.edit', compact('room', 'room_types'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'room_number' => 'required|unique:rooms,room_number,' . $id . ',r_id',
            'floor_number' => 'required|numeric',
            'status' => 'required',
            'room_type' => 'required'
        ], messages: [
            'room_number.required' => 'Room number is required.',
            'room_number.unique' => 'Room number already exists.',
            'floor_number.required' => 'Floor number is required.',
            'status.required' => 'Status is required.',
            'room_type.required' => 'Room type is required.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),
            ], 400);
        }

        $room_data = [
            'room_number' => $request->input('room_number'),
            'floor_number' => $request->input('floor_number'),
            'status' => $request->input('status'),
            'rt_id' => $request->input('room_type'),
            'enabled' => $request->input('enabled')
        ];

        try {
            DB::table('rooms')->where('r_id', $id)->update($room_data);
            $message = 'Room updated successfully.';
            session()->flash('success', $message);

            return response()->json([
                'success' => true,
                'message' => $message,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to update room.'
            ], 500);
        }
    }
}
