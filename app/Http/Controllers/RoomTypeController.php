<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RoomTypeController extends Controller
{
    public function index(Request $request)
    {
        $name = "";
        $price = "";

        $query = DB::table('room_types');

        if ($request->has('name')) {
            $name = $request->name;
            $query->where('name', 'like', '%' . $name . '%');
        }

        if ($request->has('price')) {
            $price = $request->price;
            $query->where('price', 'like', '%' . $price . '%');
        }

        $room_types = $query->get();
        return view('rooms.room_type.index', compact('room_types', 'name', 'price'));
    }

    public function create()
    {
        return view('rooms.room_type.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50|unique:room_types,name',
            'price' => 'required|numeric',
            'enabled' => 'required|in:0,1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),
            ], 400);
        }

        try {
            DB::transaction(function () use ($request) {
                DB::table('room_types')->insert([
                    'name' => $request->input('name'),
                    'price' => $request->input('price'),
                    'enabled' => $request->input('enabled'),
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'errors' => ['name' => 'Something went wrong. Please try again.'],
            ], 500);
        }

        session()->flash('success', 'Room type created successfully.');

        return response()->json(['success' => true], 200);
    }

    public function edit($id)
    {
        $room_type = DB::table('room_types')->where('rt_id', $id)->first();
        return view('rooms.room_type.edit', compact('room_type'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50|unique:room_types,name,' . $id . ',rt_id',
            'price' => 'required|numeric',
            'enabled' => 'required|in:0,1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),
            ], 400);
        }

        try {
            DB::transaction(function () use ($request, $id) {
                DB::table(table: 'room_types')->where('rt_id', $id)->update([
                    'name' => $request->input('name'),
                    'price' => $request->input('price'),
                    'enabled' => $request->input('enabled'),
                    'updated_by' => auth()->id(),
                    'updated_at' => now(),
                ]);
            });
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'errors' => ['name' => 'Something went wrong. Please try again.'],
            ], 500);
        }

        session()->flash('success', 'Room type updated successfully.');

        return response()->json(['success' => true], 200);
    }
}
