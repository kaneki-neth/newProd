<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Storage;
use Validator;

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

        $news_events = $query->orderBy('date', 'desc')->get();

        return view('news_events.index', compact('news_events', 'title', 'category', 'date_from', 'date_to'));
    }

    public function create()
    {
        return view('news_events.create');
    }

    public function edit($ne_id)
    {
        //
    }

    public function store(Request $request)
    {
        return $this->handleRequest($request);
    }

    public function update(Request $request, $ne_id)
    {
        return $this->handleRequest($request, $ne_id);
    }

    // Helper methods
    protected function handleRequest(Request $request, $ne_id = null)
    {
        $validator = $this->validateRequest($request, $ne_id);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),
            ], 400);
        }

        $storedImagePaths = [];
        try {
            DB::beginTransaction();

            $mainImagePath = $request->file('mainImage')->store('news_events', 'public');
            $storedImagePaths[] = $mainImagePath;
            $category = $request->category;
            $data = [
                'category' => $category,
                'title' => $request->title,
                'date' => $request->date,
                'description' => $request->description,
                'image_file' => $mainImagePath,
                'updated_by' => auth()->id(),
                'updated_at' => now(),
            ];

            if ($ne_id) {
                DB::table('news_events')->where('ne_id', $ne_id)->update($data);
            } else {
                $data['created_by'] = auth()->id();
                $data['created_at'] = now();
                $ne_id = DB::table('news_events')->insertGetId($data);
            }

            if ($request->hasFile('sub_images')) {
                $storedImagePaths = array_merge(
                    $storedImagePaths,
                    $this->storeSubImages($ne_id, $request->file('sub_images'))
                );
            }

            DB::commit();

            $message = $ne_id
                ? ($category == 'news' ? 'News updated successfully.' : 'Event updated successfully.')
                : ($category == 'news' ? 'News created successfully.' : 'Event created successfully.');
            session()->flash('success', $message);

            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->deleteImages($storedImagePaths);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing the request.',
            ], 500);
        }
    }

    protected function validateRequest(Request $request, $ne_id = null)
    {
        return Validator::make($request->all(), [
            'category' => 'required|in:news,events',
            'title' => 'required|max:255',
            'date' => 'required|date',
            'description' => 'required',
            'mainImage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:102400',
            'sub_images' => 'sometimes|array',
            'sub_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:102400',
        ], messages: [
            'category.required' => 'The category is required.',
            'title.required' => 'The title field is required.',
            'date.required' => 'The date field is required.',
            'description.required' => 'The description field is required.',
            'mainImage.required' => 'The main image is required.',
            'mainImage.max' => 'The main image must not be greater than 100MB.',
            'sub_images.*.max' => 'The sub images must not be greater than 100MB.',
        ]);
    }

    protected function storeSubImages($ne_id, $subImages)
    {
        DB::table('news_events_images')->where('ne_id', $ne_id)->delete();
        $storedImagePaths = [];
        $imageData = [];
        foreach ($subImages as $subImage) {
            $storedImagePath = $subImage->store('news_events', 'public');
            $storedImagePaths[] = $storedImagePath;

            $imageData[] = [
                'ne_id' => $ne_id,
                'image_file' => $storedImagePath,
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('news_events_images')->insert($imageData);

        return $storedImagePaths;
    }

    protected function deleteImages($imagePaths)
    {
        foreach ($imagePaths as $imagePath) {
            Storage::disk('public')->delete($imagePath);
        }
    }
}
