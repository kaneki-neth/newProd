<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AmenityController extends Controller
{
    public function index(Request $request)
    {
        $name = "";
        $price = "";
        $enabled = "";

        $query = DB::table('amenities');

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
            $name = $request->name;
        }

        if ($request->has('price')) {
            $query->where('price', 'like', '%' . $request->price . '%');
            $price = $request->price;
        }

        if ($request->has('enabled') && in_array($request->input('enabled'), ['0', '1'])) {
            $query->where('enabled', $request->input('enabled'));
            $enabled = $request->input('enabled');
        }

        $amenities = $query->get();

        return view('amenities.index', compact('amenities', 'name', 'price', 'enabled'));
    }

    public function create()
    {
        return view('amenities.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'enabled' => 'required',
        ], $messages = [
                'name.required' => 'Name is required',
                'price.required' => 'Price is required',
                'enabled.required' => 'Status is required',
            ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ], 400);
        }

        try {
            DB::beginTransaction();
            $amenity = DB::table('amenities')->insert([
                'name' => $request->name,
                'price' => $request->price,
                'enabled' => $request->enabled,
                'created_by' => auth()->user()->id,
                'created_at' => now(),
            ]);

            DB::commit();
            session()->flash('success', 'Amenity created successfully');
            return response()->json([
                'success' => true,
                'message' => 'Amenity created successfully',
                'data' => $amenity
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        $amenity = DB::table('amenities')->where('a_id', $id)->first();


        return view('amenities.edit', compact('amenity'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'enabled' => 'required',
        ], $messages = [
                'name.required' => 'Name is required',
                'price.required' => 'Price is required',
                'enabled.required' => 'Status is required',
            ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ], 400);
        }

        try {
            DB::beginTransaction();
            $amenity = DB::table('amenities')->where('a_id', $id)->update([
                'name' => $request->name,
                'price' => $request->price,
                'enabled' => $request->enabled,
                'updated_by' => auth()->user()->id,
                'updated_at' => now(),
            ]);

            DB::commit();
            session()->flash('success', 'Amenity updated successfully');
            return response()->json([
                'success' => true,
                'message' => 'Amenity updated successfully',
                'data' => $amenity
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
