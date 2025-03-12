<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class newsevent extends Controller
{
    public function index(Request $request)
    {
        if (! $request->ajax()) {
            return view('web.news_and_events.events');
        }

        $perPage = 1;
        $category = $request->category;

        if ($category != 'videos') {
            $items = DB::table($category)
                ->where('enabled', 1)
                ->orderBy('date', 'desc')
                ->selectRaw("{$category[0]}_id as id, image_file, title, date, description".($category == 'events' ? ', time, location, registration_link' : ''))
                ->paginate($perPage, ['*']);

            foreach ($items as $item) {
                $date = date_create($item->date);
                $item->date = date_format($date, $category == 'events' ? 'l, F j, Y' : 'j M Y');
                if ($category == 'events') {
                    $item->time = date_format(
                        date_create($item->time),
                        'g:i A'
                    );
                }
                $item->excerpt = $this->generate_excerpt($item->description);
                unset($item->description);
            }

            $routes = [
                'news' => 'news_content',
                'research' => 'research_content',
                'blogs' => 'blog_content',
                'events' => 'event_content',
            ];

            $routeName = $routes[$category];

            return view('web.news_and_events.category_content', compact('items', 'routeName', 'category'))->render();
        }

        $items = DB::table('videos')
            ->orderBy('date', 'desc')
            ->paginate($perPage, ['*']);

        return view('web.news_and_events.category_content', compact('items', 'category'))->render();
    }

    public function generate_excerpt($description, $maxLength = 100)
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
