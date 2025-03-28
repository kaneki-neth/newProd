<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GuestController extends Controller
{
    public function index(Request $request)
    {
        $name = "";
        $status = "";

        $query = DB::table('guests')
            ->leftJoin('companies', 'guests.company_id', '=', 'companies.c_id')
            ->select('guests.*', 'companies.name as company_name');

        if ($request->has('name')) {
            $query->where('first_name', 'like', '%' . $request->name . '%');
            $name = $request->name;
        }

        if ($request->has('status')) {
            $query->where('enabled', $request->status);
            $status = $request->status;
        }

        $guests = $query->get();

        return view('guests.index', compact('guests', 'name', 'status'));
    }

    public function create()
    {
        $companies = DB::table('companies')->get();
        return view('guests.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'contact_number' => 'required',
            'email' => 'required',
            'address_1' => 'required',
            'address_2' => 'required',
            'enabled' => 'required',
            'company_id' => 'nullable',
        ], $messages = [
                'first_name.required' => 'First name is required',
                'middle_name.required' => 'Middle name is required',
                'last_name.required' => 'Last name is required',
                'gender.required' => 'Gender is required',
                'contact_number.required' => 'Contact number is required',
                'email.required' => 'Email is required',
                'address_1.required' => 'Address 1 is required',
                'address_2.required' => 'Address 2 is required',
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

            DB::table('guests')->insert([
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'gender' => $request->gender,
                'contact_number' => $request->contact_number,
                'email' => $request->email,
                'address_1' => $request->address_1,
                'address_2' => $request->address_2,
                'company_id' => $request->company_id,
                'enabled' => $request->enabled,
                'created_at' => now(),
                'created_by' => Auth::user()->id,
            ]);

            DB::commit();

            session()->flash('success', 'Guest created successfully');

            return response()->json([
                'success' => true,
                'message' => 'Guest created successfully'
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('error', $e->getMessage());
            return response()->json([
                'success' => false,
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function view($id)
    {
        $guest = DB::table('guests')
            ->leftJoin('companies', 'guests.company_id', '=', 'companies.c_id')
            ->select('guests.*', 'companies.name as company_name')
            ->where('guests.g_id', '=', $id)
            ->first();

        // dd($guest);
        return view('guests.view', compact('guest'));
    }

    public function edit($id)
    {
        $guest = DB::table('guests')
            ->leftJoin('companies', 'guests.company_id', '=', 'companies.c_id')
            ->select('guests.*', 'companies.c_id as company_id', 'companies.name as company_name')
            ->where('guests.g_id', '=', $id)
            ->first();

        $companies = DB::table('companies')
            ->where('enabled', '=', 1)
            ->get();

        // dd($guest);
        return view('guests.edit', compact('guest', 'companies'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'contact_number' => 'required',
            'email' => 'required',
            'address_1' => 'required',
            'address_2' => 'required',
            'company' => 'nullable',
            'enabled' => 'required',
        ], $messages = [
                'first_name.required' => 'First name is required',
                'middle_name.required' => 'Middle name is required',
                'last_name.required' => 'Last name is required',
                'gender.required' => 'Gender is required',
                'contact_number.required' => 'Contact number is required',
                'email.required' => 'Email is required',
                'address_1.required' => 'Address 1 is required',
                'address_2.required' => 'Address 2 is required',
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

            DB::table('guests')->where('g_id', '=', $id)->update([
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'gender' => $request->gender,
                'contact_number' => $request->contact_number,
                'email' => $request->email,
                'address_1' => $request->address_1,
                'address_2' => $request->address_2,
                'company_id' => $request->company,
                'enabled' => $request->enabled,
                'updated_at' => now(),
                'updated_by' => Auth::user()->id,
            ]);

            DB::commit();

            session()->flash('success', 'Guest updated successfully');

            return response()->json([
                'success' => true,
                'message' => 'Guest updated successfully'
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('error', $e->getMessage());
            return response()->json([
                'success' => false,
                'errors' => $e->getMessage()
            ], 500);
        }
    }
}
