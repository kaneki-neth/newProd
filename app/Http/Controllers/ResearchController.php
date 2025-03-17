<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Storage;
use Validator;

class ResearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:research-read', ['only' => ['index', 'show']]);
        $this->middleware('permission:research-write', ['only' => ['create', 'store', 'edit', 'update']]);
    }

    public function index(Request $request)
    {
        $title = '';
        $date_from = '';
        $date_to = '';
        $enabled = '';

        $query = DB::table('research')
            ->select('r_id', 'title', 'date', 'enabled')
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

        $researches = $query->orderBy('date', 'desc')
            ->paginate(20)
            ->appends($request->except('page'));

        return view('research.index', compact('researches', 'title', 'date_from', 'date_to', 'enabled'));
    }

    public function show($r_id)
    {
        $files = DB::table('research_files')
            ->select('file_path')
            ->where('r_id', $r_id)
            ->get()
            ->toArray();

        $authors = DB::table('research_author')
            ->where('r_id', $r_id)
            ->pluck('author_name') // Gets an array of values
            ->toArray();

        $research = DB::table('research')
            ->select('r_id', 'title', 'date', 'description', 'image_file', 'enabled')
            ->where('r_id', $r_id)
            ->first();

        $subImages = DB::table('research_images')
            ->select('ri_id', 'image_file')
            ->where('r_id', $r_id)
            ->get()
            ->toArray();

        return view('research.show', compact('research', 'subImages', 'files', 'authors'));
    }

    public function create()
    {
        return view('research.create');
    }

    public function edit($r_id)
    {
        $research = DB::table('research')
            ->select('r_id', 'title', 'date', 'description', 'image_file', 'enabled')
            ->where('r_id', $r_id)
            ->first();

        $subImages = DB::table('research_images')
            ->select('ri_id', 'image_file')
            ->where('r_id', $r_id)
            ->get()
            ->toArray();

        // Get unique files to avoid duplicates in the view
        $files = DB::table('research_files')
            ->select('file_path')
            ->where('r_id', $r_id)
            // ->distinct() // Add this to get only unique file paths
            ->get()
            ->toArray();

        $authors = DB::table('research_author')
            ->where('r_id', $r_id)
            ->whereNotNull('author_name') // Only get non-null author names
            // ->distinct() // In case there are duplicate author names
            ->pluck('author_name')
            ->toArray();

        return view('research.edit', compact('research', 'subImages', 'files', 'authors'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        return $this->handleRequest($request);
    }

    public function update(Request $request, $r_id)
    {
        return $this->handleRequest($request, $r_id);
    }

    // Helper methods
    protected function handleRequest(Request $request, $r_id = null)
    {
        $validator = $this->validateRequest($request, $r_id);

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
                if ($r_id) {
                    $oldMainImage = DB::table('research')->where('r_id', $r_id)->value('image_file');
                    if ($oldMainImage) {
                        Storage::disk('public')->delete($oldMainImage);
                    }
                }
                $mainImagePath = $request->file('mainImage')->store('research', 'public');
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

            if ($r_id) {
                DB::table('research')->where('r_id', $r_id)->update($data);
            } else {
                $data['created_by'] = auth()->id();
                $data['created_at'] = now();
                $r_id = DB::table('research')->insertGetId($data);
            }

            // Handle file deletions
            if ($request->has('filesToDelete') && !empty($request->filesToDelete)) {
                foreach ($request->filesToDelete as $filePath) {
                    // Check if this file belongs to this research
                    $fileExists = DB::table('research_files')
                        ->where('r_id', $r_id)
                        ->where('file_path', $filePath)
                        ->exists();

                    if ($fileExists) {
                        // Check if this file is used by other research entries
                        $fileUsedElsewhere = DB::table('research_files')
                            ->where('file_path', $filePath)
                            ->where('r_id', '!=', $r_id)
                            ->exists();

                        // Only delete the physical file if it's not used elsewhere
                        if (!$fileUsedElsewhere && Storage::disk('public')->exists($filePath)) {
                            Storage::disk('public')->delete($filePath);
                        }

                        // Delete only the database records for this research
                        DB::table('research_files')
                            ->where('r_id', $r_id)
                            ->where('file_path', $filePath)
                            ->delete();
                    }
                }
            }

            // Handle the uploaded files
            if ($request->hasFile('uploadFiles')) {
                // Save all files to research_files table
                foreach ($request->file('uploadFiles') as $file) {
                    $uploadFilePath = $file->storeAs('files/research', $file->getClientOriginalName(), 'public');

                    // Insert file record in research_files table
                    DB::table('research_files')->insert([
                        'r_id' => $r_id,
                        'file_path' => $uploadFilePath,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // Handle authors - moved outside the uploadFiles condition
            if ($request->has('authors') && !empty($request->authors)) {
                // If updating, delete existing authors first
                if ($r_id) {
                    DB::table('research_author')->where('r_id', $r_id)->delete();
                }

                // Insert all authors
                foreach ($request->authors as $author) {
                    if (!empty($author)) {
                        DB::table('research_author')->insert([
                            'r_id' => $r_id,
                            'author_name' => $author,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }

            if ($request->hasFile('sub_images')) {
                $storedImagePaths = array_merge(
                    $storedImagePaths,
                    $this->storeSubImages($r_id, $request->file('sub_images'), $r_id ? true : false)
                );
            }

            DB::commit();

            if ($request->has('subImagesToDelete')) {
                $sub_image_ids = $request->input('subImagesToDelete');
                DB::table('research_images')->whereIn('ri_id', $sub_image_ids)->delete();
            }

            $message = $r_id ? 'Research updated successfully.' : 'Research created successfully.';
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

    protected function validateRequest(Request $request, $r_id = null)
    {
        if ($request->has('date') && $request->date) {
            $request->merge(input: ['date' => date('Y-m-d', strtotime($request->date))]);
        }
        if (!preg_match('/>(\s*[^<\s].*?)</', $request->description)) {
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
            'mainImage' => ($r_id ? 'sometimes' : 'required') . '|image|mimes:jpeg,png,jpg,gif,svg|max:102400',
            'sub_images' => 'sometimes|array',
            'sub_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:102400',
            'uploadFiles.*' => 'sometimes|file|mimes:pdf,doc,docx,ppt,pptx|max:102400',
            'subImagesToDelete' => 'sometimes|array',
            'subImagesToDelete.*' => 'integer',
            'filesToDelete' => 'sometimes|array',
            'filesToDelete.*' => 'string',
            'enabled' => 'required|in:0,1',
        ], messages: [
            'title.required' => 'The title field is required.',
            'date.required' => 'The date field is required.',
            'description.required' => 'The description field is required.',
            'mainImage.required' => 'The main image is required.',
            'mainImage.max' => 'The main image must not be greater than 100MB.',
            'sub_images.*.max' => 'The sub images must not be greater than 100MB.',
            'uploadFiles.*.max' => 'The uploaded file must not be greater than 100MB.',
        ]);
    }

    protected function storeSubImages($r_id, $subImages, $update = false)
    {
        $storedImagePaths = [];
        $imageData = [];
        foreach ($subImages as $subImage) {
            $storedImagePath = $subImage->store('research', 'public');
            $storedImagePaths[] = $storedImagePath;

            $imageData[] = [
                'r_id' => $r_id,
                'image_file' => $storedImagePath,
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('research_images')->insert($imageData);

        return $storedImagePaths;
    }

    protected function deleteImages($imagePaths)
    {
        foreach ($imagePaths as $imagePath) {
            Storage::disk('public')->delete($imagePath);
        }
    }
}
