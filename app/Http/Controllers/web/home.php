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

        $recommended_materials = DB::table('materials as m')
            ->joinSub(
                DB::table('item_categories as ic')
                    ->join('categories as c', 'ic.c_id', '=', 'c.c_id')
                    ->select(
                        'ic.m_id',
                        'c.name as category_name',
                        'c.c_id',
                        DB::raw('ROW_NUMBER() OVER (PARTITION BY ic.m_id ORDER BY c.name) as rn')
                    ),
                'fc',
                function ($join) {
                    $join->on('m.m_id', '=', 'fc.m_id')
                        ->where('fc.rn', '=', 1);
                }
            )
            ->select(
                'm.name as material_name',
                'm.m_id',
                'm.image_file',
                'fc.category_name',
                'fc.c_id as category_id'
            )
            ->where('m.enabled', 1)
            ->get();

        return view('web.index', compact('latest_news', 'recommended_materials'));
    }

    public function search_content(string $searchTerm)
    {
        $query = DB::table('materials')
            ->select(
                'materials.m_id',
                'materials.name',
                'materials.image_file',
                'materials.created_at',
                'materials.year',
                DB::raw('GROUP_CONCAT(DISTINCT categories.name ORDER BY categories.name SEPARATOR ", ") as category_name')
            )
            ->join('item_categories', 'materials.m_id', '=', 'item_categories.m_id')
            ->join('categories', 'item_categories.c_id', '=', 'categories.c_id')
            ->where('materials.enabled', 1);

        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('materials.name', 'like', "%$searchTerm%")
                    ->orWhere('materials.material_code', 'like', "%$searchTerm%")
                    ->orWhere('materials.description', 'like', "%$searchTerm%");
            });
        }

        $query->groupBy(
            'materials.m_id',
            'materials.name',
            'materials.image_file',
            'materials.created_at',
            'materials.year'
        );

        // dd($query->get());
        $materials = $query->paginate(5);


        return view('web.search_content_grid', compact('materials', 'searchTerm'));
    }
}
