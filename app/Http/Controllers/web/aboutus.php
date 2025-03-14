<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class aboutus extends Controller
{
    //
    public function core_programs(){
        return view('web.about.core_programs');
    }

    public function vision_mission(){
        return view('web.about.vision_mission');
    }
}
