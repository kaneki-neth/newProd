<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $company = "";
        $status = "";

        $query = DB::table('companies');

        if ($request->has('company')) {
            $query->where('name', 'like', '%' . $request->company . '%');
            $company = $request->company;
        }

        if ($request->has('status') && in_array($request->input('status'), ['0', '1'])) {
            $query->where('enabled', $request->input('status'));
            $status = $request->input('status');
        }

        $companies = $query->get();

        return view('companies.index', compact('companies', 'company', 'status'));
    }

    public function create()
    {
        return view('companies.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
            'contact_number' => 'required|string',
            'email' => 'required|email|unique:companies,email',
            'enabled' => 'required',
        ], $messages = [
                'name.required' => 'The name field is required.',
                'description.required' => 'The description field is required.',
                'address.required' => 'The address field is required.',
                'contact_number.required' => 'The contact number field is required.',
                'email.required' => 'The email field is required.',
                'email.unique' => 'The email has already been taken.',
                'enabled.required' => 'The enabled field is required.',
            ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ], 400);
        }

        try {
            DB::beginTransaction();
            $company = DB::table('companies')->insert([
                'name' => $request->name,
                'description' => $request->description,
                'address' => $request->address,
                'contact_number' => $request->contact_number,
                'email' => $request->email,
                'enabled' => $request->enabled,
                'created_at' => now(),
                'created_by' => Auth::user()->id,
            ]);

            DB::commit();

            session()->flash('success', 'Company created successfully');

            return response()->json([
                'success' => true,
                'message' => 'Company created successfully',
                'data' => $company
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('error', $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to create company'
            ], 500);
        }
    }

    public function edit($id)
    {
        $company = DB::table('companies')->where('c_id', $id)->first();
        return view('companies.edit', compact('company'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
            'contact_number' => 'required|string',
            'email' => 'required|email|unique:companies,email,' . $request->id . ',c_id',
            'enabled' => 'required',
        ], $messages = [
                'name.required' => 'The name field is required.',
                'description.required' => 'The description field is required.',
                'address.required' => 'The address field is required.',
                'contact_number.required' => 'The contact number field is required.',
                'email.required' => 'The email field is required.',
                'enabled.required' => 'The enabled field is required.',
                'email.unique' => 'The email has already been taken.',
            ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ], 400);
        }

        try {
            DB::beginTransaction();
            $company = DB::table('companies')->where('c_id', $id)->update([
                'name' => $request->name,
                'description' => $request->description,
                'address' => $request->address,
                'contact_number' => $request->contact_number,
                'email' => $request->email,
                'enabled' => $request->enabled,
                'updated_at' => now(),
                'updated_by' => Auth::user()->id,
            ]);

            DB::commit();

            session()->flash('success', 'Company updated successfully');

            return response()->json([
                'success' => true,
                'message' => 'Company updated successfully',
                'data' => $company
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('error', $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to update company'
            ], 500);
        }
    }
}
