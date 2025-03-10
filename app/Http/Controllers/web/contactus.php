<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class contactus extends Controller
{
    //
    public function index(){
        return view('web.contactus');
    }

    public function contact_submit(Request $request) {

        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'purpose' => 'required|in:General Inquiry,Book a Visit,Collaboration,Event Registration,Others',
            'message' => 'required|string',
        ]);

        
    }
}
