<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use DB;

class home extends Controller
{
    //
    public function index()
    {
        $latest_news = DB::table('news')->select('n_id', 'title', 'date', 'image_file')
            ->where('enabled', 1)
            ->orderBy('date', 'desc')
            ->limit(10)
            ->get();

        $latest_news->map(function ($news) {
            $news->date = date('j M Y', strtotime($news->date));

            return $news;
        });

        return view('web.index', compact('latest_news'));
    }
}
