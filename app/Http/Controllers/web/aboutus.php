<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class aboutus extends Controller
{
    //
    public function index(){
        return view('web.about');
    }
}
