<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ChargesItemsController extends Controller
{
    public function index(Request $request)
    {
        $name = "";
        $amount = "";
        $status = "";

        $query = DB::table('charges_items');

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
            $name = $request->name;
        }

        if ($request->has('amount')) {
            $query->where('amount', 'like', '%' . $request->amount . '%');
            $amount = $request->amount;
        }

        if ($request->has('status') && in_array($request->input('status'), ['0', '1'])) {
            $query->where('enabled', $request->input('status'));
            $status = $request->input('status');
        }

        $charges_items = $query->get();
        return view('charges_items.index', compact('charges_items', 'name', 'amount', 'status'));
    }

    public function create()
    {
        return view('charges_items.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'enabled' => 'required',
        ], $messages = [
                'name.required' => 'Charge item name is required',
                'description.required' => 'Charge item description is required',
                'amount.required' => 'Charge item amount is required',
                'amount.numeric' => 'Charge item amount must be a number',
                'amount.min' => 'Charge item amount must be at least 0',
                'enabled.required' => 'Enabled is required',
            ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ], 400);
        }

        try {
            DB::beginTransaction();
            $charges_item = DB::table('charges_items')->insert([
                'name' => $request->name,
                'description' => $request->description,
                'amount' => $request->amount,
                'enabled' => $request->enabled,
                'created_at' => now(),
                'created_by' => auth()->user()->id,
            ]);

            DB::commit();

            session()->flash('success', 'Charges item created successfully');
            return response()->json([
                'success' => true,
                'message' => 'Charges item created successfully',
                'data' => $charges_item
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Failed to create charges item');
            return response()->json([
                'success' => false,
                'message' => 'Failed to create charges item'
            ], 500);
        }
    }

    public function edit($id)
    {
        $charges_item = DB::table('charges_items')->where('ci_id', $id)->first();
        return view('charges_items.edit', compact('charges_item'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'enabled' => 'required',
        ], $messages = [
                'name.required' => 'Charge item name is required',
                'description.required' => 'Charge item description is required',
                'amount.required' => 'Charge item amount is required',
                'amount.numeric' => 'Charge item amount must be a number',
                'amount.min' => 'Charge item amount must be at least 0',
                'enabled.required' => 'Enabled is required',
            ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ], 400);
        }

        try {
            DB::beginTransaction();
            $charges_item = DB::table('charges_items')->where('ci_id', $id)->update([
                'name' => $request->name,
                'description' => $request->description,
                'amount' => $request->amount,
                'enabled' => $request->enabled,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Charges item updated successfully'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update charges item'
            ], 500);
        }
    }
}
