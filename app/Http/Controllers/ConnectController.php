<?php

namespace App\Http\Controllers;

use App\Models\connect_model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConnectController extends Controller
{
    public function index(Request $request)
    {
        $purposes = connect_model::select('purpose')
            ->distinct()
            ->pluck('purpose');

        $query = connect_model::where('purpose', '!=', 'MATIX Subscription');

        $subscribed = connect_model::where('purpose', 'MATIX Subscription');

        if ($request->has('filter') && $request->filter == 'true') {

            if ($request->filled('name')) {
                $query->where('name', 'like', '%' . $request->name . '%');
                $subscribed->where('name', 'like', '%' . $request->name . '%');
            }

            if ($request->filled('purpose') && $request->purpose != 'MATIX Subscription') {
                $query->where('purpose', $request->purpose);
            }
        }

        $connects = $query->get();
        $subscription = $subscribed->get();

        return view('connect.index', compact('connects', 'purposes', 'subscription'));
    }

    public function read_email(Request $request)
    {
        $read = connect_model::where('connect_id', $request->_connect_id)->first();

        $read->is_read = "1";
        $read->save();

        return view('connect.read_email', compact('read'));
    }
}
