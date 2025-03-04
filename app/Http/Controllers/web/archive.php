<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class archive extends Controller
{
    //
    public function index(){
        return view('web.archive');
    }

    public function archive_details(){
        return view('web.archivedetails');
    }
}
