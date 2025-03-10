<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use DB;

class newsevent extends Controller
{
    //
    private function getRecords($table, $columns, $dateFormat, $filterCurrent = true, $includeTime = false)
    {
        $query = DB::table($table)->select($columns)
            ->where('enabled', 1);

        if ($filterCurrent) {
            $query->where('date', '<=', date('Y-m-d H:i:s'));
        }

        $items = $query->orderBy('date', 'desc')->get()->toArray();

        foreach ($items as $item) {
            $date = date_create($item->date);
            $item->date = date_format($date, $dateFormat);
            if ($includeTime) {
                $item->time = date_format($date, 'h:i A');
            }
            $item->excerpt = $this->generate_excerpt($item->description);
            unset($item->description);
        }

        return $items;
    }

    public function index()
    {
        $news = $this->getRecords(
            'news',
            ['n_id', 'image_file', 'title', 'date', 'description'],
            'j M Y'
        );

        $researches = $this->getRecords(
            'research',
            ['r_id', 'image_file', 'title', 'date', 'description'],
            'j M Y'
        );

        $blogs = $this->getRecords(
            'blogs',
            ['b_id', 'image_file', 'title', 'date', 'description'],
            'j M Y'
        );

        $events = $this->getRecords(
            'events',
            ['e_id', 'image_file', 'title', 'date', 'description', 'location'],
            'l F j Y',
            false,
            true
        );

        return view('web.news_and_events.events', compact('news', 'researches', 'blogs', 'events'));
    }

    public function generate_excerpt($description, $maxLength = 300)
    {
        $img_replacement = ' ';
        $img_pattern = '/<img[^>]+src="data:image\/[^;]+;base64,[^"]+"[^>]*>/';
        $cleanDescription = preg_replace($img_pattern, $img_replacement, $description);
        $cleanDescription = $description;
        $cleanDescription = strip_tags($cleanDescription);
        if (strlen($cleanDescription) > $maxLength) {
            return substr($cleanDescription, 0, $maxLength).'...';
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
