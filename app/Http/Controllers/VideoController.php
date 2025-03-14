<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VideoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:video-write', [
            'only' => [
                'create',
                'store',
                'edit',
                'update',
            ],
        ]);
        $this->middleware('permission:video-read|video-write', [
            'only' => [
                'index',
                'show',
            ],
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = '';
        $date_from = '';
        $date_to = '';
        $status = '';

        $query = DB::table('videos')
            ->select('videos.*')
            ->orderBy('date', 'desc');

        if ($request->has('title')) {
            $title = $request->title;
            $query->where('title', 'like', "%$title%");
        }

        $status = $request->input('status');

        if ($status !== null && $status !== '') {
            $query->where('status', $status);
        }

        if ($request->has('date_from') && $request->input('date_from')) {
            $dateFrom = date('Y-m-d 00:00:00', strtotime($request->date_from));
            $date_from = $request->date_from;
            $query->where('date', '>=', $dateFrom);
        }

        if ($request->has('date_to') && $request->input('date_to')) {
            $dateTo = date('Y-m-d 23:59:59', strtotime($request->date_to));
            $date_to = $request->date_to;
            $query->where('date', '<=', $dateTo);
        }

        // dd($status);
        $videos = $query->orderBy('date', 'desc')
            ->paginate(20)
            ->appends($request->except('page'));

        // $videos = $videos->map(function ($video) {
        //     $video->date = Carbon::parse($video->date)->format('F j, Y');
        //     return $video;
        // });

        // $date_from = Carbon::parse($request->date_from)->format('F j, Y');
        // $date_to = Carbon::parse($request->date_to)->format('F j, Y');

        return view('videos.index', compact('videos', 'title', 'date_from', 'date_to', 'status'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create()
    {
        return view('videos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if (! preg_match('/>(\s*[^<\s].*?)</', $request->description)) {
            $request->merge(['description' => strip_tags($request->description)]);
        }
        if ($request->description == strip_tags($request->description)) {
            $request->merge(['description' => trim(str_replace('&nbsp;', '', $request->description))]);
        }
        // <p>&nbsp;</p><p><br></p> not handled yet

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'date' => 'required',
            'video_url' => 'required',
            'status' => 'required',
            'description' => 'required',
        ], messages: [
            'title.required' => 'The title is required.',
            'video_url.required' => 'The video URL is required.',
            'date.required' => 'The date is required.',
            'description.required' => 'The description is required.',
            'status.required' => 'The status is required.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),
            ], 400);
        }

        $videoData = [
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'date' => $request->input('date'),
            'video_url' => $request->input('video_url'),
            'status' => $request->input('status'),
            'created_by' => auth()->id(),
            'created_at' => now(),
            'updated_by' => auth()->id(),
            'updated_at' => now(),
        ];

        try {
            DB::table('videos')->insert($videoData);

            $message = 'Video created successfully.';
            session()->flash('success', $message);

            return response()->json([
                'success' => true,
                'message' => $message,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create video',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function edit(string $id)
    {
        $video = DB::table('videos')->where('v_id', $id)->first();
        // $video->date = Carbon::parse($video->date)->format('F j, Y');

        return view('videos.edit', compact('video'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $video = DB::table('videos')->where('v_id', $id)->first();
        // $video->date = Carbon::parse($video->date)->format('F j, Y');

        return view('videos.show', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $videoId)
    {
        if (! preg_match('/>(\s*[^<\s].*?)</', $request->description)) {
            $request->merge(['description' => strip_tags($request->description)]);
        }
        if ($request->description == strip_tags($request->description)) {
            $request->merge(['description' => trim(str_replace('&nbsp;', '', $request->description))]);
        }
        // <p>&nbsp;</p><p><br></p> not handled yet

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'video_url' => 'required',
            'date' => 'required',
            'description' => 'required',
        ], messages: [
            'title.required' => 'The title is required.',
            'video_url.required' => 'The video URL is required.',
            'date.required' => 'The date is required.',
            'description.required' => 'The description is required.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),
            ], 400);
        }

        try {
            DB::beginTransaction();

            $videoData = [
                'title' => $request->input('title'),
                'date' => $request->input('date'),
                'video_url' => $request->input('video_url'),
                'description' => $request->input('description'),
                'status' => $request->input('status'),
                'updated_by' => auth()->id(),
                'updated_at' => now(),
            ];

            DB::table('videos')
                ->where('v_id', $videoId)
                ->update($videoData);

            DB::commit();

            $video = DB::table('videos')->where('v_id', $videoId)->first();

            session()->flash('success', 'Video updated successfully!');

            return response()->json(['success' => true], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the video.',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getThumbnail(Request $request): JsonResponse
    {
        // dd($request);
        $url = $request->query('url');

        if (empty($url)) {
            return response()->json(['error' => 'URL is required'], 400);
        }

        try {
            // Extract video ID from different types of YouTube URLs
            $videoId = $this->extractYoutubeId($url);

            if (! $videoId) {
                return response()->json(['error' => 'Invalid YouTube URL'], 400);
            }

            // Try to get the highest quality thumbnail first
            $thumbnailUrl = "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg";

            // Check if maxresdefault exists, if not fall back to hqdefault
            $headers = get_headers($thumbnailUrl);
            if (strpos($headers[0], '404')) {
                $thumbnailUrl = "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg";
            }

            return response()->json([
                'thumbnail' => $thumbnailUrl,
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch thumbnail'], 500);
        }
    }

    private function extractYoutubeId(string $url): ?string
    {
        $patterns = [
            '/youtube\.com\/watch\?v=([^\&\?\/]+)/', // Regular youtube URL
            '/youtube\.com\/embed\/([^\&\?\/]+)/',    // Embed URL
            '/youtu\.be\/([^\&\?\/]+)/',             // Shortened URL
            '/youtube\.com\/v\/([^\&\?\/]+)/',        // Alternative embed URL
            '/youtube\.com\/shorts\/([^\&\?\/]+)/',   // Shorts URL
            '/facebook\.com\/.*\/videos\/([0-9]+)/', // Facebook video URL
            '/facebook\.com\/watch\?v=([^\&\?\/]+)/', // Facebook video URL
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }
}
