<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use DB;
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

        $news = DB::table('news_events')
            ->select('ne_id', 'image_file', 'title', 'date', 'description')
            ->where('category', 'news')
            ->where('enabled', 1)
            ->where('date', '<=', date('Y-m-d H:i:s'))
            ->orderBy('date', 'desc')
            ->get()
            ->toArray();

        foreach ($news as $item) {
            $date = date_create($item->date);
            $item->date = date_format($date, 'j M Y');
            $item->excerpt = $this->generate_excerpt($item->description);
            unset($item->description);
        }

        $events = DB::table('news_events')
            ->select('ne_id', 'image_file', 'title', 'date', 'description')
            ->where('category', 'event')
            ->where('enabled', 1)
            // ->where('date', '<=', date('Y-m-d H:i:s'))
            ->orderBy('date', 'desc')
            ->get()
            ->toArray();

        foreach ($events as $item) {
            $date = date_create($item->date);
            $item->date = date_format($date, 'l F j Y');
            $item->time = date_format($date, 'h:i A');
            $item->excerpt = $this->generate_excerpt($item->description);
            unset($item->description);
        }

        return view('web.news_and_events.events', compact('videos'), compact('news', 'events'));
    }

    public function generate_excerpt($description, $maxLength = 300)
    {
        $img_replacement = ' ';
        $img_pattern = '/<img[^>]+src="data:image\/[^;]+;base64,[^"]+"[^>]*>/';
        $cleanDescription = preg_replace($img_pattern, $img_replacement, $description);
        $cleanDescription = $description;
        $cleanDescription = strip_tags($cleanDescription);
        if (strlen($cleanDescription) > $maxLength) {
            return substr($cleanDescription, 0, $maxLength) . '...';
        }

        return $cleanDescription;
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
