<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Storage;
use Validator;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $title = '';
        $date_from = '';
        $date_to = '';
        $enabled = '';

        $query = DB::table('events')
            ->select('e_id', 'title', 'date', 'enabled')
            ->orderBy('date', 'desc');

        if ($request->has('title')) {
            $title = $request->title;
            $query->where('title', 'like', "%$title%");
        }

        if ($request->has('enabled') && in_array($request->input('enabled'), ['0', '1'])) {
            $enabled = $request->input('enabled');
            $query->where('enabled', $enabled);
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

        $events = $query->orderBy('date', 'desc')->paginate(20);

        return view('events.index', compact('events', 'title', 'date_from', 'date_to', 'enabled'));
    }

    public function show($n_id)
    {
        $event = DB::table('events')
            ->select('e_id', 'title', 'date', 'description', 'image_file', 'enabled')
            ->where('e_id', $n_id)
            ->first();

        $subImages = DB::table('event_images')
            ->select('ei_id', 'image_file')
            ->where('e_id', $n_id)
            ->get()
            ->toArray();

        return view('events.show', compact('event', 'subImages'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function edit($n_id)
    {
        $event = DB::table('events')
            ->select('e_id', 'title', 'date', 'description', 'image_file', 'enabled')
            ->where('e_id', $n_id)
            ->first();

        $subImages = DB::table('event_images')
            ->select('ei_id', 'image_file')
            ->where('e_id', $n_id)
            ->get()
            ->toArray();

        return view('events.edit', compact('event', 'subImages'));
    }

    public function store(Request $request)
    {
        return $this->handleRequest($request);
    }

    public function update(Request $request, $n_id)
    {
        return $this->handleRequest($request, $n_id);
    }

    // Helper methods
    protected function handleRequest(Request $request, $n_id = null)
    {
        $validator = $this->validateRequest($request, $n_id);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),
            ], 400);
        }

        $storedImagePaths = [];
        try {
            DB::beginTransaction();

            $mainImagePath = null;
            if ($request->has('mainImage')) {
                if ($n_id) {
                    $oldMainImage = DB::table('events')->where('e_id', $n_id)->value('image_file');
                    if ($oldMainImage) {
                        Storage::disk('public')->delete($oldMainImage);
                    }
                }
                $mainImagePath = $request->file('mainImage')->store('events', 'public');
                $storedImagePaths[] = $mainImagePath;
            }
            $data = [
                'title' => $request->title,
                'date' => $request->date,
                'description' => $request->description,
                'updated_by' => auth()->id(),
                'updated_at' => now(),
                'enabled' => $request->enabled,
            ];

            if ($request->has('mainImage')) {
                $data['image_file'] = $mainImagePath;
            }

            if ($n_id) {
                DB::table('events')->where('e_id', $n_id)->update($data);
            } else {
                $data['created_by'] = auth()->id();
                $data['created_at'] = now();
                $n_id = DB::table('events')->insertGetId($data);
            }

            if ($request->hasFile('sub_images')) {
                $storedImagePaths = array_merge(
                    $storedImagePaths,
                    $this->storeSubImages($n_id, $request->file('sub_images'), $n_id ? true : false)
                );
            }

            DB::commit();

            if ($request->has('subImagesToDelete')) {
                $sub_image_ids = $request->input('subImagesToDelete');
                DB::table('event_images')->whereIn('ei_id', $sub_image_ids)->delete();
            }

            $message = $n_id ? 'Event updated successfully.' : 'Event created successfully.';
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

    protected function validateRequest(Request $request, $n_id = null)
    {
        if ($request->has('date') && $request->date) {
            $request->merge(['date' => date('Y-m-d', strtotime($request->date))]);
        }
        if (! preg_match('/>(\s*[^<\s].*?)</', $request->description)) {
            $request->merge(['description' => strip_tags($request->description)]);
        }
        if ($request->description == strip_tags($request->description)) {
            $request->merge(['description' => trim(str_replace('&nbsp;', '', $request->description))]);
        }
        // <p>&nbsp;</p><p><br></p> not handled yet

        return Validator::make($request->all(), [
            'title' => 'required|max:255',
            'date' => 'required|date',
            'description' => 'required',
            'mainImage' => ($n_id ? 'sometimes' : 'required').'|image|mimes:jpeg,png,jpg,gif,svg|max:102400',
            'sub_images' => 'sometimes|array',
            'sub_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:102400',
            'subImagesToDelete' => 'sometimes|array',
            'subImagesToDelete.*' => 'integer',
            'enabled' => 'required|in:0,1',
        ], messages: [
            'title.required' => 'The title field is required.',
            'date.required' => 'The date field is required.',
            'description.required' => 'The description field is required.',
            'mainImage.required' => 'The main image is required.',
            'mainImage.max' => 'The main image must not be greater than 100MB.',
            'sub_images.*.max' => 'The sub images must not be greater than 100MB.',
        ]);
    }

    protected function storeSubImages($n_id, $subImages, $update = false)
    {
        $storedImagePaths = [];
        $imageData = [];
        foreach ($subImages as $subImage) {
            $storedImagePath = $subImage->store('events', 'public');
            $storedImagePaths[] = $storedImagePath;

            $imageData[] = [
                'e_id' => $n_id,
                'image_file' => $storedImagePath,
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('event_images')->insert($imageData);

        return $storedImagePaths;
    }

    protected function deleteImages($imagePaths)
    {
        foreach ($imagePaths as $imagePath) {
            Storage::disk('public')->delete($imagePath);
        }
    }
}
