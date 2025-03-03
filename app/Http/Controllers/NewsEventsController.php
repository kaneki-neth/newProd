<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class NewsEventsController extends Controller
{
    public function index(Request $request)
    {
        $title = '';
        $category = '';
        $date_from = '';
        $date_to = '';

        $query = DB::table('news_events')
            ->select('ne_id', 'category', 'title', 'date')
            ->orderBy('date', 'desc');

        if ($request->has('title')) {
            $title = $request->title;
            $query->where('title', 'like', "%$title%");
        }

        if ($request->has('category') && in_array($request->category, ['news', 'event'])) {
            $category = $request->category;
            $query->where('category', $category);
        }

        if ($request->has('date_from')) {
            $dateFrom = $request->date_from;
            $query->where('date', '>=', $dateFrom);
        }

        if ($request->has('date_to')) {
            $dateTo = $request->date_to;
            $query->where('date', '<=', $dateTo);
        }

        $news_events = $query->get();

        return view('news_events.index', compact('news_events', 'title', 'category', 'date_from', 'date_to'));
    }

    public function create()
    {
        return view('news_events.create');
    }

    public function store(Request $request)
    {
        $this->handleRequest($request);
    }

    public function update(Request $request, $ne_id)
    {
        $this->handleRequest($request, $ne_id);
    }

    // Helper methods
    protected function handleRequest(Request $request, $ne_id = null)
    {
        //
    }
}
