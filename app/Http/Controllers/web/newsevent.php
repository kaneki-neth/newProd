<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class newsevent extends Controller
{
    //
    public function index(){
        return view('web.news_and_events.events');
    }

    public function events_news_content(){
        return view('web.news_and_events.articles.events_news_content');
    }

    public function events_research_content(){
        return view('web.news_and_events.articles.events_research_content');
    }

    public function events_blog_content(){
        return view('web.news_and_events.articles.events_blog_content');
    }

    public function events_events_content(){
        return view('web.news_and_events.articles.events_events_content');
    }
}
