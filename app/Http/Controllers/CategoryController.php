<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Validator;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:category-read', ['only' => ['index']]);
        $this->middleware('permission:category-write', ['only' => ['create', 'store', 'edit', 'update']]);
    }

    public function index(Request $request)
    {
        $name = '';
        $enabled = '';

        $query = DB::table('categories');

        if ($request->has('name')) {
            $name = $request->input('name');
            $query->where('name', 'like', "%$name%");
        }

        if ($request->has('enabled') && in_array($request->input('enabled'), ['0', '1'])) {
            $enabled = $request->input('enabled');
            $query->where('enabled', $enabled);
        }

        $query = $query->orderBy('name', 'asc');

        $categories = $query->get();

        return view('categories.index', compact('categories', 'name', 'enabled'));
    }

    // public function show($id)
    // {
    //     $category = DB::table('categories')->find($id);
    //     return view('categories.show', compact('category'));
    // }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50|unique:categories,name',
            'description' => 'string|nullable',
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
                DB::table('categories')->insert([
                    'name' => $request->input('name'),
                    'description' => $request->input('description'),
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

        session()->flash('success', 'Category created successfully.');

        return response()->json(['success' => true], 200);
    }

    public function edit($id)
    {
        $category = DB::table('categories')->where('c_id', $id)->first();

        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50|unique:categories,name,'.$id.',c_id',
            'description' => 'string|nullable',
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
                DB::table(table: 'categories')->where('c_id', $id)->update([
                    'name' => $request->input('name'),
                    'description' => $request->input('description'),
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

        session()->flash('success', 'Category updated successfully.');

        return response()->json(['success' => true], 200);
    }

    // public function destroy($id)
    // {
    //     $validator = Validator::make(['c_id' => $id], [
    //         'c_id' => 'exists:categories',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'success' => false,
    //             'errors' => $validator->getMessageBag()->toArray(),
    //         ], 400);
    //     }

    //     DB::table('categories')->where('c_id', $id)->delete();

    //     session()->flash('success', 'Category deleted successfully.');

    //     return redirect()->route('categories.index');
    // }
}
