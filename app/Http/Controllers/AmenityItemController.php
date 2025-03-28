<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AmenityItemController extends Controller
{
    public function index(Request $request)
    {
        $name = "";
        $price = "";
        $enabled = "";

        $query = DB::table('amenity_items');

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

        $amenity_items = $query->get();

        return view('amenity_items.index', compact('amenity_items', 'name', 'price', 'enabled'));
    }

    public function create()
    {
        return view('amenity_items.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'enabled' => 'required',
        ], $messages = [
                'name.required' => 'Name is required',
                'description.required' => 'Description is required',
                'price.required' => 'Price is required',
                'quantity.required' => 'Quantity is required',
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
            $amenity_item = DB::table('amenity_items')->insert([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'enabled' => $request->enabled,
                'created_by' => auth()->user()->id,
                'created_at' => now(),
            ]);

            DB::commit();
            session()->flash('success', 'Amenity item created successfully');
            return response()->json([
                'success' => true,
                'message' => 'Amenity item created successfully',
                'data' => $amenity_item
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
        $amenity_item = DB::table('amenity_items')->where('ai_id', $id)->first();


        return view('amenity_items.edit', compact('amenity_item'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'enabled' => 'required',
        ], $messages = [
                'name.required' => 'Name is required',
                'description.required' => 'Description is required',
                'price.required' => 'Price is required',
                'quantity.required' => 'Quantity is required',
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
            $amenity_item = DB::table('amenity_items')->where('ai_id', $id)->update([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'enabled' => $request->enabled,
                'updated_by' => auth()->user()->id,
                'updated_at' => now(),
            ]);

            DB::commit();
            session()->flash('success', 'Amenity item updated successfully');
            return response()->json([
                'success' => true,
                'message' => 'Amenity item updated successfully',
                'data' => $amenity_item
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
