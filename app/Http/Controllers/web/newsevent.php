<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
// use DB;
use Illuminate\Support\Facades\DB;

class newsevent extends Controller
{
    private function getRecords($table, $columns, $dateFormat, $includeTime = false)
    {
        $query = DB::table($table)->select($columns)
            ->where('enabled', 1);

        $items = $query->orderBy('date', 'desc')->get()->toArray();

        foreach ($items as $item) {
            $date = date_create($item->date);
            $item->date = date_format($date, $dateFormat);
            if ($includeTime) {
                $item->time = date_format(
                    date_create($item->time),
                    'g:i A'
                );
            }
            $item->excerpt = $this->generate_excerpt($item->description);
            unset($item->description);
        }

        return $items;
    }

    public function index()
    {
        $videos = DB::table('videos')
            ->select('videos.*')
            ->orderBy('date', 'desc')
            ->get();

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
            ['e_id', 'image_file', 'title', 'date', 'time', 'description', 'location', 'registration_link'],
            'l F j Y',
            true
        );

        return view('web.news_and_events.events', compact('news', 'researches', 'blogs', 'events', 'videos'));
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

    public function events_news_content($n_id)
    {
        $news = DB::table('news')->select(['n_id', 'image_file', 'title', 'date', 'description', 'enabled', 'created_by'])
            ->where('n_id', $n_id)
            ->first();

        if (! $news->enabled) {
            return redirect()->action([newsevent::class, 'index']);
        }

        $date = date_create($news->date);
        $news->date = date_format($date, 'j M Y');

        $user = DB::table('users')->select(['first_name', 'last_name'])
            ->where('id', $news->created_by)
            ->first();
        $news->created_by = $user->first_name.' '.$user->last_name;

        return view('web.news_and_events.articles.events_news_content', compact('news'));
    }

    public function events_research_content($r_id)
    {
        $research = DB::table('research')->select(['r_id', 'image_file', 'title', 'date', 'description', 'enabled', 'created_by'])
            ->where('r_id', $r_id)
            ->first();

        if (! $research->enabled) {
            return redirect()->action([newsevent::class, 'index']);
        }

        $date = date_create($research->date);
        $research->date = date_format($date, 'j M Y');

        $user = DB::table('users')->select(['first_name', 'last_name'])
            ->where('id', $research->created_by)
            ->first();
        $research->created_by = $user->first_name.' '.$user->last_name;

        return view('web.news_and_events.articles.events_research_content', compact('research'));
    }

    public function events_blog_content($b_id)
    {
        $blog = DB::table('blogs')->select(['b_id', 'image_file', 'title', 'date', 'description', 'enabled', 'created_by'])
            ->where('b_id', $b_id)
            ->first();

        if (! $blog->enabled) {
            return redirect()->action([newsevent::class, 'index']);
        }

        $date = date_create($blog->date);
        $blog->date = date_format($date, 'j M Y');

        $user = DB::table('users')->select(['first_name', 'last_name'])
            ->where('id', $blog->created_by)
            ->first();
        $blog->created_by = $user->first_name.' '.$user->last_name;

        return view('web.news_and_events.articles.events_blog_content', compact('blog'));
    }

    public function events_events_content($e_id)
    {
        $event = DB::table('events')->select([
            'e_id', 'image_file', 'title', 'date', 'time',
            'description', 'location', 'registration_link', 'enabled',
        ])
            ->where('e_id', $e_id)
            ->first();

        if (! $event->enabled) {
            return redirect()->action([newsevent::class, 'index']);
        }

        $date = date_create($event->date);
        $event->date = date_format($date, 'l, F j, Y');

        $event->time = date_format(
            date_create($event->time),
            'g:i A'
        );

        return view('web.news_and_events.articles.events_events_content', compact('event'));
    }
}
