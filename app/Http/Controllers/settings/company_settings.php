<?php

namespace App\Http\Controllers\settings;

use App\Http\Controllers\Controller;
use App\Models\settings\BusinessUnit;
use App\Models\settings\CompanySettings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class company_settings extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('permission:company_settings', ['only' => [
            'index',
            'update',
            'create',
            'bu_details',
            'edit_bu',
            'disabled_bu',
            'enabled_bu',
            'store_update',
            'store_bu',
        ]]);
    }

    public function index()
    {

        $com_set = CompanySettings::first();
        $combusunit = BusinessUnit::get();

        return view('settings.company_settings', compact('com_set', 'combusunit'));
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'company_name' => 'required',
            'short_name' => 'required',
            'address_line1' => 'required',
            'city' => 'required',
            'province' => 'required',
            'postal_code' => 'required',
            'country' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),
            ], 400);
        }

        $currentDateTime = Carbon::now();
        $com_set = CompanySettings::first();
        $com_set->company_name = $request->company_name;
        $com_set->short_name = $request->short_name;
        $com_set->tel_num = $request->tel_num;
        $com_set->address_line1 = $request->address_line1;
        $com_set->address_line2 = $request->address_line2;
        $com_set->city = $request->city;
        $com_set->province = $request->province;
        $com_set->postal_code = $request->postal_code;
        $com_set->country = $request->country;
        $com_set->updated_by = auth()->user()->id;
        $com_set->updated_at = $currentDateTime->format('Y-m-d H:i:s');
        $com_set->save();

        session()->flash('success', 'Company details successfully updated!.');

        return response()->json(['success' => true], 200);
    }

    public function create(Request $request)
    {
        return view('settings.create_bu');
    }

    public function bu_details(Request $request)
    {

        $combusunit = BusinessUnit::where('bu_id', $request->bu)->first();

        return view('settings.bu_details', compact('combusunit'));
    }

    public function edit_bu(Request $request)
    {
        $combusunit = BusinessUnit::where('bu_id', $request->bu)->first();

        return view('settings.edit_bu', compact('combusunit'));
    }

    public function disabled_bu(Request $request)
    {

        $currentDateTime = Carbon::now();
        $combusunit = BusinessUnit::where('bu_id', $request->bu)->first();
        $combusunit->enabled = 0;
        $combusunit->updated_by = auth()->user()->id;
        $combusunit->updated_at = $currentDateTime->format('Y-m-d H:i:s');
        $combusunit->save();

        session()->flash('success', 'Business unit successfully disabled!.');

        return response()->json(['success' => true], 200);
    }

    public function enabled_bu(Request $request)
    {
        $currentDateTime = Carbon::now();
        $combusunit = BusinessUnit::where('bu_id', $request->bu)->first();
        $combusunit->enabled = 1;
        $combusunit->updated_by = auth()->user()->id;
        $combusunit->updated_at = $currentDateTime->format('Y-m-d H:i:s');
        $combusunit->save();

        session()->flash('success', 'Business unit successfully enabled!.');

        return response()->json(['success' => true], 200);
    }

    public function store_update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bu_code' => 'required',
            'bu_name' => 'required',
            'bu_address_line1' => 'required',
            'bu_city' => 'required',
            'bu_province' => 'required',
            'bu_postal_code' => 'required',
            'bu_country' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),
            ], 400);
        }

        $currentDateTime = Carbon::now();

        $com_set = BusinessUnit::where('bu_id', $request->_bu)->first();
        $com_set->bu_code = $request->bu_code;
        $com_set->bu_name = $request->bu_name;
        $com_set->tel_num = $request->bu_tel_num;
        $com_set->address_line1 = $request->bu_address_line1;
        $com_set->address_line2 = $request->bu_address_line2;
        $com_set->city = $request->bu_city;
        $com_set->enabled = $request->enabled;
        $com_set->province = $request->bu_province;
        $com_set->postal_code = $request->bu_postal_code;
        $com_set->country = $request->bu_country;
        $com_set->updated_by = auth()->user()->id;
        $com_set->updated_at = $currentDateTime->format('Y-m-d H:i:s');
        $com_set->save();

        session()->flash('success', 'Business unit successfully updated!');

        return response()->json(['success' => true], 200);
    }

    public function store_bu(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'bu_code' => 'required',
            'bu_name' => 'required',
            'bu_address_line1' => 'required',
            'bu_city' => 'required',
            'bu_province' => 'required',
            'bu_postal_code' => 'required',
            'bu_country' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),
            ], 400);
        }

        $currentDateTime = Carbon::now();
        $com_set = new BusinessUnit;
        $com_set->bu_code = $request->bu_code;
        $com_set->bu_name = $request->bu_name;
        $com_set->tel_num = $request->bu_tel_num;
        $com_set->address_line1 = $request->bu_address_line1;
        $com_set->address_line2 = $request->bu_address_line2;
        $com_set->city = $request->bu_city;
        $com_set->enabled = $request->enabled;
        $com_set->province = $request->bu_province;
        $com_set->postal_code = $request->bu_postal_code;
        $com_set->country = $request->bu_country;
        $com_set->created_by = auth()->user()->id;
        $com_set->created_at = $currentDateTime->format('Y-m-d H:i:s');
        $com_set->save();

        session()->flash('success', 'Business unit successfully added!');

        return response()->json(['success' => true], 200);

    }
}
