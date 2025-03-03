<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use App\Models\app\appLookup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class app_lookup extends Controller
{
    public function __construct()
    {

        $this->middleware('permission:look_up_view|look_up_full', ['only' => ['index', 'view']]);
        $this->middleware('permission:look_up_full', ['only' => ['create', 'store', 'update', 'store_update']]);

    }

    public function index(Request $request)
    {

        $lookups = [];
        $lookup_type = '';
        $meaning = '';
        if ($request->filter) {
            $lookups = appLookup::orderBy('lookup_type', 'ASC')->orderBy('meaning', 'ASC');
            if ($request->_lookup_type) {
                $lookups = $lookups->orWhere('lookup_type', 'like', '%' . $request->_lookup_type . '%');
                $lookup_type = $request->_lookup_type;
            }

            if ($request->_meaning) {
                $lookups = $lookups->orWhere('meaning', 'like', '%' . $request->_meaning . '%');
                $meaning = $request->_meaning;
            }
            $lookups = $lookups->get();
        }

        return view('app_lookup.index', compact('lookups', 'lookup_type', 'meaning'));
    }

    public function create()
    {
        return view('app_lookup.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'code' => 'required|unique:app_lookup,lookup_code',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),
            ], 400);
        }

        $lookups = new appLookup;

        $lookups->lookup_type = $request->input('type');
        $lookups->lookup_code = $request->input('code');
        $lookups->meaning = $request->input('meaning');
        $enabledValue = $request->input('enable') === 'on' ? 1 : 0;
        $lookups->enabled = $enabledValue;
        $lookups->tag = $request->input('tag');
        $lookups->created_by = auth()->user()->id;

        $lookups->save();

        session()->flash('success', 'SUCCESS');

        return redirect('app/app_lookup');
    }

    public function update(Request $request)
    {
        $lookups = appLookup::where('lookup_code', $request->_lookup_code)->first();

        return view('app_lookup.update', compact('lookups'));
    }

    public function view(Request $request)
    {
        $lookups = appLookup::where('lookup_code', $request->_lookup_code)->first();

        return view('app_lookup.view', compact('lookups'));
    }

    public function store_update(Request $request)
    {

        $lookups = appLookup::where('lookup_code', $request->_lookup_code)->first();
        $lookups->meaning = $request->meaning;
        $lookups->tag = $request->tag;
        $lookups->enabled = $request->_enabled;
        $lookups->updated_by = auth()->user()->id;
        $lookups->save();

        session()->flash('success', 'SUCCESS');

        return redirect('app/app_lookup');
    }
}
