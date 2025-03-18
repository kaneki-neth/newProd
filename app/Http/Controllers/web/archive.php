<?php

namespace App\Http\Controllers\web;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class archive extends Controller
{
    //
    public function index(Request $request)
    {
        // dd($request->all());
        $selectedYear = null;
        $sortOptions = [];
        $selectedCategories = [];
        $searchQuery = null;

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


        if ($request->has('selectedYear')) {
            $selectedYear = $request->input('selectedYear');
            $query->where('materials.year', $selectedYear);
        }

        if ($request->has('selectedCategories')) {
            $selectedCategories = $request->input('selectedCategories');
            $query->whereIn('categories.c_id', $selectedCategories);
        }

        if ($request->has('searchQuery')) {
            $searchQuery = $request->input('searchQuery');
            $query->where(function ($q) use ($searchQuery) {
                $q->where('materials.name', 'like', "%$searchQuery%")
                    ->orWhere('materials.material_code', 'like', "%$searchQuery%")
                    ->orWhere('materials.description', 'like', "%$searchQuery%");
            });
        }

        if ($request->has('sortOptions')) {
            $sortOptions = $request->input('sortOptions');

            if (in_array("alphabetical", $sortOptions)) {
                $query->orderBy('materials.name', 'asc');
                // dd("test");
            }
            if (in_array("recently-added", $sortOptions)) {
                $query->orderBy('materials.created_at', 'desc');
            }
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

        $categories = DB::table('categories')
            ->select('c_id', 'name')
            ->where('enabled', '!=', 0)
            ->orderBy('name', 'asc')
            ->get();

        // dd(compact('categories', 'materials', 'selectedYear', 'sortOptions', 'selectedCategories', 'searchQuery'));
        if ($request->ajax()) {
            return response()->json([
                'html' => view('web.archive.digital_archive_grid', compact('categories', 'materials', 'selectedYear', 'sortOptions', 'selectedCategories', 'searchQuery'))->render()
            ], 200)
                ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
                ->header('Cache-Control', 'post-check=0, pre-check=0', false)
                ->header('Pragma', 'no-cache');
        }

        return view('web.archive.digital_archive', compact('categories', 'materials', 'selectedYear', 'sortOptions', 'selectedCategories', 'searchQuery'));
    }

    public function archive_details(int $m_id)
    {
        $material = DB::table('materials')
            ->select('materials.material_code', 'materials.name', 'materials.description', 'materials.year', 'm_id', 'enabled', 'image_file', 'material_source')
            ->where('m_id', $m_id)
            ->first();

        $categories = DB::table('item_categories')
            ->leftJoin('categories', 'item_categories.c_id', '=', 'categories.c_id')
            ->select('categories.name', 'categories.description as category_description', 'categories.c_id')
            ->where('m_id', $m_id)
            ->orderBy('categories.name', 'asc')
            ->get();

        $selectedCategories = DB::table('item_categories')
            ->where('m_id', $m_id)
            ->pluck('c_id')
            ->toArray();

        $images = DB::table('material_images')
            ->select('mi_id', 'image_file')
            ->where('m_id', $m_id)
            ->get()
            ->toArray();

        $recommended_materials = DB::table('materials')
            ->join('item_categories', 'materials.m_id', '=', 'item_categories.m_id')
            ->join('categories', 'item_categories.c_id', '=', 'categories.c_id')
            ->where('materials.m_id', $m_id)
            ->select('materials.name', 'materials.m_id', 'materials.image_file')->get();

        $properties = DB::table('properties')
            ->select('name')
            ->where('m_id', $m_id)
            ->where('type', '=', "soft")
            ->get();


        $techProperties = DB::table('properties')
            ->select('name', 'value')
            ->where('m_id', $m_id)
            ->where('type', '=', "technical")
            ->get();

        $susProperties = DB::table('properties')
            ->select('name', 'value')
            ->where('m_id', $m_id)
            ->where('type', '=', "application")
            ->get();

        // dd(compact('material', 'categories', 'images', 'properties', 'techProperties', 'susProperties', 'selectedCategories'));
        return view('web.archive.archive_content', compact('material', 'categories', 'images', 'properties', 'techProperties', 'susProperties', 'selectedCategories', 'recommended_materials'));
    }

    public function archive_new(Request $request)
    {
        // dd("this the request", $request->all());
        $searchQuery = null;

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
            ->where('materials.enabled', 1)
            ->where('materials.year', date('Y'));


        if ($request->has('searchQuery')) {
            $searchQuery = $request->input('searchQuery');
            $query->where(function ($q) use ($searchQuery) {
                $q->where('materials.name', 'like', "%$searchQuery%")
                    ->orWhere('materials.material_code', 'like', "%$searchQuery%")
                    ->orWhere('materials.description', 'like', "%$searchQuery%");
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
        $materials = $query->paginate(3);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('web.archive.archive_new_grid', compact('materials', 'searchQuery'))->render()
            ], 200)
                ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
                ->header('Cache-Control', 'post-check=0, pre-check=0', false)
                ->header('Pragma', 'no-cache');
        }

        return view('web.archive.archive_new', compact('materials', 'searchQuery'));

    }
}
