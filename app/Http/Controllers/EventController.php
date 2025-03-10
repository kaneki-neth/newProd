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
        $location = '';

        $query = DB::table('events')
            ->select('e_id', 'title', 'date', 'time', 'location', 'enabled')
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

        if ($request->has('location')) {
            $location = $request->location;
            $query->where('location', 'like', "%$location%");
        }

        $events = $query->orderBy('date', 'desc')->paginate(20);

        return view('events.index', compact('events', 'title', 'date_from', 'date_to', 'enabled', 'location'));
    }

    public function show($e_id)
    {
        $event = DB::table('events')
            ->select('e_id', 'title', 'date', 'time', 'location', 'registration_link', 'description', 'image_file', 'enabled')
            ->where('e_id', $e_id)
            ->first();

        $subImages = DB::table('events_images')
            ->select('ei_id', 'image_file')
            ->where('e_id', $e_id)
            ->get()
            ->toArray();

        return view('events.show', compact('event', 'subImages'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function edit($e_id)
    {
        $event = DB::table('events')
            ->select('e_id', 'title', 'date', 'time', 'location', 'registration_link', 'description', 'image_file', 'enabled')
            ->where('e_id', $e_id)
            ->first();

        $subImages = DB::table('events_images')
            ->select('ei_id', 'image_file')
            ->where('e_id', $e_id)
            ->get()
            ->toArray();

        return view('events.edit', compact('event', 'subImages'));
    }

    public function store(Request $request)
    {
        return $this->handleRequest($request);
    }

    public function update(Request $request, $e_id)
    {
        return $this->handleRequest($request, $e_id);
    }

    // Helper methods
    protected function handleRequest(Request $request, $e_id = null)
    {
        $validator = $this->validateRequest($request, $e_id);

        if ($request->has('time')) {
            $time = date('H:i', strtotime($request->time));
            $request->merge(['time' => $time]);
        }

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
                if ($e_id) {
                    $oldMainImage = DB::table('events')->where('e_id', $e_id)->value('image_file');
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
                'time' => $request->time,
                'location' => $request->location,
                'registration_link' => $request->registration_link,
                'description' => $request->description,
                'updated_by' => auth()->id(),
                'updated_at' => now(),
                'enabled' => $request->enabled,
            ];

            if ($request->has('mainImage')) {
                $data['image_file'] = $mainImagePath;
            }

            if ($e_id) {
                DB::table('events')->where('e_id', $e_id)->update($data);
            } else {
                $data['created_by'] = auth()->id();
                $data['created_at'] = now();
                $e_id = DB::table('events')->insertGetId($data);
            }

            if ($request->hasFile('sub_images')) {
                $storedImagePaths = array_merge(
                    $storedImagePaths,
                    $this->storeSubImages($e_id, $request->file('sub_images'), $e_id ? true : false)
                );
            }

            DB::commit();

            if ($request->has('subImagesToDelete')) {
                $sub_image_ids = $request->input('subImagesToDelete');
                DB::table('events_images')->whereIn('ei_id', $sub_image_ids)->delete();
            }

            $message = $e_id ? 'Event updated successfully.' : 'Event created successfully.';
            session()->flash('success', $message);

            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->deleteImages($storedImagePaths);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing the request.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    protected function validateRequest(Request $request, $e_id = null)
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
            'time' => 'required|date_format:g:i A',
            'location' => 'required|max:255',
            'registration_link' => 'sometimes|max:255',
            'description' => 'required',
            'mainImage' => ($e_id ? 'sometimes' : 'required').'|image|mimes:jpeg,png,jpg,gif,svg|max:102400',
            'sub_images' => 'sometimes|array',
            'sub_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:102400',
            'subImagesToDelete' => 'sometimes|array',
            'subImagesToDelete.*' => 'integer',
            'enabled' => 'required|in:0,1',
        ], messages: [
            'title.required' => 'The title field is required.',
            'date.required' => 'The date field is required.',
            'date.date' => 'The date field must be a valid date.',
            'time.required' => 'The time field is required.',
            'time.date_format' => 'The time field must be a valid time format.',
            'location' => 'The location field is required',
            'description.required' => 'The description field is required.',
            'mainImage.required' => 'The main image is required.',
            'mainImage.max' => 'The main image must not be greater than 100MB.',
            'sub_images.*.max' => 'The sub images must not be greater than 100MB.',
        ]);
    }

    protected function storeSubImages($e_id, $subImages, $update = false)
    {
        $storedImagePaths = [];
        $imageData = [];
        foreach ($subImages as $subImage) {
            $storedImagePath = $subImage->store('events', 'public');
            $storedImagePaths[] = $storedImagePath;

            $imageData[] = [
                'e_id' => $e_id,
                'image_file' => $storedImagePath,
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('events_images')->insert($imageData);

        return $storedImagePaths;
    }

    protected function deleteImages($imagePaths)
    {
        foreach ($imagePaths as $imagePath) {
            Storage::disk('public')->delete($imagePath);
        }
    }
}
