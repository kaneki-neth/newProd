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

        $recommended_materials = DB::table('materials')
            ->join('item_categories', 'materials.m_id', '=', 'item_categories.m_id')
            ->join('categories', 'item_categories.c_id', '=', 'categories.c_id')
            ->select('materials.name as material_name', 'materials.m_id', 'materials.image_file', DB::raw('MIN(categories.name) as category_name'))
            ->where('materials.enabled', 1)
            ->groupBy('materials.m_id', 'material_name')
            ->get();

        return view('web.index', compact('latest_news', 'recommended_materials'));
    }
}
