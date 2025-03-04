<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = DB::table('videos')->get();
        return view('videos.index', compact('videos'));
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
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            // 'video' => 'mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime|max:102400', // 100MB max
            'video_url' => 'required',
            'date' => 'required',
            'description' => 'required',
        ], messages: [
            // 'video.required' => 'The video is required.',
            // 'video.mimetypes' => 'The video must be a video file.',
            // 'video.max' => 'The video may not be greater than 100MB.',
            'title.required' => 'The title is required.',
            'video_url.required' => 'The video URL is required.',
            'date.required' => 'The date is required.',
            'description.required' => 'The description is required.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // if ($request->hasFile('video')) {
        //     $videoPath = $request->file('video')->store('videos', 'public'); // Store in "storage/app/public/videos"

        //     $videoData = [
        //         'title' => $request->input('title'),
        //         'description' => $request->input('description'),
        //         'date' => $request->input('date'),
        //         'video_url' => $request->input('video_url'),
        //         'video_file' => $videoPath,
        //         'updated_by' => auth()->id(),
        //         'updated_at' => now(),
        //     ];

        //     $videoId = DB::table('videos')->insertGetId($videoData);

        //     return response()->json(['success' => 'Video uploaded successfully!', 'videoId' => $videoId]);
        // }

        $videoData = [
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'date' => $request->input('date'),
            'video_url' => $request->input('video_url'),
            'status' => 1,
            'created_by' => auth()->id(),
            'created_at' => now(),
            'updated_by' => auth()->id(),
            'updated_at' => now(),
        ];

        DB::table('videos')->insert($videoData);

        session()->flash('success', 'Video created successfully.');

        return response()->json(['success' => 'Video created successfully!']);

    }

    /**
     * Display the specified resource.
     */
    public function edit(string $id)
    {
        $video = DB::table('videos')->where('v_id', $id)->first();

        return view('videos.edit', compact('video'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $video = DB::table('videos')->where('v_id', $id)->first();

        return view('videos.show', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $videoId)
    {
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
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $videoData = [
            'title' => $request->input('title'),
            'date' => $request->input('date'),
            'video_url' => $request->input('video_url'),
            'description' => $request->input('description'),
            'status' => 1,
            'updated_by' => auth()->id(),
            'updated_at' => now(),
        ];

        try {
            DB::table('videos')
                ->where('v_id', $videoId)
                ->update($videoData);

            $video = DB::table('videos')->where('v_id', $videoId)->first();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Video updated successfully!',
                    'video' => $video
                ]);
            }

            return redirect()
                ->route('videos.edit', $videoId)
                ->with('success', 'Video updated successfully');

        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Failed to update video'], 500);
            }

            return redirect()
                ->back()
                ->with('error', 'Failed to update video');
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
        $url = $request->query('url');

        if (empty($url)) {
            return response()->json(['error' => 'URL is required'], 400);
        }

        try {
            // Extract video ID from different types of YouTube URLs
            $videoId = $this->extractYoutubeId($url);

            if (!$videoId) {
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
                'thumbnail' => $thumbnailUrl
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
            '/youtube\.com\/v\/([^\&\?\/]+)/'        // Alternative embed URL
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }
}
