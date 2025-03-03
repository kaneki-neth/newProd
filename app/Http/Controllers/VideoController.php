<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'video' => 'required|mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime|max:102400', // 100MB max
            'date' => 'required',
            'description' => 'required',
        ], messages: [
            'video.required' => 'The video is required.',
            'video.mimetypes' => 'The video must be a video file.',
            'video.max' => 'The video may not be greater than 100MB.',
            'title.required' => 'The title is required.',
            'date.required' => 'The date is required.',
            'description.required' => 'The description is required.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('videos', 'public'); // Store in "storage/app/public/videos"

            $videoData = [
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'date' => $request->input('date'),
                'video_file' => $videoPath,
                'updated_by' => auth()->id(),
                'updated_at' => now(),
            ];

            $videoId = DB::table('videos')->insertGetId($videoData);

            return response()->json(['success' => 'Video uploaded successfully!', 'videoId' => $videoId]);
        }



    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
