<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class newsevent extends Controller
{
    //
    public function index()
    {
        $query = DB::table('videos')
            ->select('videos.*')
            ->orderBy('date', 'desc');

        $videos = $query->get();

        return view('web.news_and_events.events', compact('videos'));
    }

    public function events_news_content()
    {
        return view('web.news_and_events.articles.events_news_content');
    }

    public function events_research_content()
    {
        return view('web.news_and_events.articles.events_research_content');
    }

    public function events_blog_content()
    {
        return view('web.news_and_events.articles.events_blog_content');
    }

    public function events_events_content()
    {
        return view('web.news_and_events.articles.events_events_content');
    }
}
