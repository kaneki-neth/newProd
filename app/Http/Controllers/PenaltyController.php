<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PenaltyController extends Controller
{
    public function index(Request $request)
    {
        $penalty = "";
        $status = "";

        $query = DB::table('penalties');

        if ($request->has('penalty')) {
            $query->where('name', 'like', '%' . $request->penalty . '%');
            $penalty = $request->penalty;
        }

        if ($request->has('status') && in_array($request->input('status'), ['0', '1'])) {
            $query->where('enabled', $request->input('status'));
            $status = $request->input('status');
        }

        $penalties = $query->get();
        return view('penalties.index', compact('penalties', 'penalty', 'status'));
    }

    public function create()
    {
        return view('penalties.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'enabled' => 'required',
        ], $messages = [
                'name.required' => 'Penalty name is required',
                'amount.required' => 'Penalty amount is required',
                'amount.numeric' => 'Penalty amount must be a number',
                'amount.min' => 'Penalty amount must be at least 0',
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
            $penalty = DB::table('penalties')->insert([
                'name' => $request->name,
                'amount' => $request->amount,
                'enabled' => $request->enabled,
                'created_at' => now(),
                'created_by' => auth()->user()->id,
            ]);

            DB::commit();

            session()->flash('success', 'Penalty created successfully');
            return response()->json([
                'success' => true,
                'message' => 'Penalty created successfully',
                'data' => $penalty
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Failed to create penalty');
            return response()->json([
                'success' => false,
                'message' => 'Failed to create penalty'
            ], 500);
        }
    }

    public function edit($id)
    {
        $penalty = DB::table('penalties')->where('p_id', $id)->first();
        return view('penalties.edit', compact('penalty'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'enabled' => 'required',
        ], $messages = [
                'name.required' => 'Penalty name is required',
                'amount.required' => 'Penalty amount is required',
                'amount.numeric' => 'Penalty amount must be a number',
                'amount.min' => 'Penalty amount must be at least 0',
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
            $penalty = DB::table('penalties')->where('p_id', $id)->update([
                'name' => $request->name,
                'amount' => $request->amount,
                'enabled' => $request->enabled,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Penalty updated successfully'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update penalty'
            ], 500);
        }
    }
}
