<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $name = "";
        $description = "";
        $daily_rate = "";
        $hourly_rate = "";
        $max_occupancy = "";

        $query = DB::table('categories');

        if ($request->has('name')) {
            $name = $request->name;
            $query->where('name', 'like', '%' . $name . '%');
        }

        if ($request->has('daily_rate')) {
            $daily_rate = $request->daily_rate;
            $query->where('daily_rate', 'like', '%' . $daily_rate . '%');
        }

        if ($request->has('hourly_rate')) {
            $hourly_rate = $request->hourly_rate;
            $query->where('hourly_rate', 'like', '%' . $hourly_rate . '%');
        }

        if ($request->has('description')) {
            $description = $request->description;
            $query->where('description', 'like', '%' . $description . '%');
        }

        if ($request->has('max_occupancy')) {
            $max_occupancy = $request->max_occupancy;
            $query->where('max_occupancy', 'like', '%' . $max_occupancy . '%');
        }

        $categories = $query->get();
        return view('rooms.category.index', compact('categories', 'name', 'daily_rate', 'hourly_rate', 'description', 'max_occupancy'));
    }

    public function create()
    {
        return view('rooms.category.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50|unique:categories,name',
            'description' => 'required|string|max:255',
            'daily_rate' => 'required|numeric',
            'hourly_rate' => 'required|numeric',
            'max_occupancy' => 'required|integer|min:1',
            'enabled' => 'required|in:0,1',
        ], $messages = [
                'name.required' => 'Name is required',
                'description.required' => 'Description is required',
                'daily_rate.required' => 'Daily rate is required',
                'hourly_rate.required' => 'Hourly rate is required',
                'max_occupancy.required' => 'Max occupancy is required',
                'enabled.required' => 'Enabled is required',
            ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),
            ], 400);
        }

        try {
            DB::transaction(function () use ($request) {
                DB::table('categories')->insert([
                    'name' => $request->input('name'),
                    'description' => $request->input('description'),
                    'daily_rate' => $request->input('daily_rate'),
                    'hourly_rate' => $request->input('hourly_rate'),
                    'max_occupancy' => $request->input('max_occupancy'),
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
        $category = DB::table('categories')->where('c_id', $id)->first();
        return view('rooms.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50|unique:categories,name,' . $id . ',c_id',
            'description' => 'required|string|max:255',
            'daily_rate' => 'required|numeric',
            'hourly_rate' => 'required|numeric',
            'max_occupancy' => 'required|integer|min:1',
            'enabled' => 'required|in:0,1',
        ], $messages = [
                'name.required' => 'Name is required',
                'description.required' => 'Description is required',
                'daily_rate.required' => 'Daily rate is required',
                'hourly_rate.required' => 'Hourly rate is required',
                'max_occupancy.required' => 'Max occupancy is required',
                'enabled.required' => 'Enabled is required',
            ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),
            ], 400);
        }

        try {
            DB::transaction(function () use ($request, $id) {
                DB::table('categories')->where('c_id', $id)->update([
                    'name' => $request->input('name'),
                    'description' => $request->input('description'),
                    'daily_rate' => $request->input('daily_rate'),
                    'hourly_rate' => $request->input('hourly_rate'),
                    'max_occupancy' => $request->input('max_occupancy'),
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
