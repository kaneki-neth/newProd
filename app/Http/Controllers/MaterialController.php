<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Validator;

class MaterialController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:material-read', ['only' => ['index', 'show']]);
        $this->middleware('permission:material-write', ['only' => ['create', 'store', 'edit', 'update']]);
    }

    public function index(Request $request)
    {
        $name = '';
        $material_code = '';
        $enabled = '';
        $year = '';

        $query = DB::table('materials')
            ->select('materials.*');

        if ($request->has('name')) {
            $name = $request->input('name');
            $query->where('name', 'like', "%$name%");
        }

        if ($request->has('material_code')) {
            $material_code = $request->input('material_code');
            $query->where('material_code', 'like', "%$material_code%");
        }
        if ($request->has('enabled') && in_array($request->input('enabled'), ['0', '1'])) {
            $enabled = $request->input('enabled');
            $query->where('enabled', $enabled);
        }
        if ($request->has('year')) {
            $year = $request->input('year');
            $query->where('year', 'like', "%$year%");
        }

        $query = $query->orderBy('name', 'asc');

        $materials = $query->paginate(3);

        $materials->appends(compact('name', 'material_code', 'enabled', 'year'));

        return view('materials.index', compact('materials', 'name', 'material_code', 'enabled', 'year'));
    }

    public function create()
    {
        $categories = DB::table('categories')->orderBy('name', 'asc')->get();

        return view('materials.create', compact('categories'));
    }

    public function edit(string $id)
    {
        $material = DB::table('materials')
            ->where('m_id', $id)
            ->first();

        $categories = DB::table('categories')->orderBy('name', 'asc')->get();
        $selectedCategories = DB::table('item_categories')
            ->where('m_id', $id)
            ->pluck('c_id')
            ->toArray();

        $properties = DB::table('properties')
            ->select('*')
            ->where('m_id', $id)
            ->where('type', '=', 'soft')
            ->get();

        $techProperties = DB::table('properties')
            ->select('*')
            ->where('m_id', $id)
            ->where('type', '=', 'technical')
            ->get();

        $susProperties = DB::table('properties')
            ->select('*')
            ->where('m_id', $id)
            ->where('type', '=', 'application')
            ->get();

        $images = DB::table('material_images')
            ->select('mi_id', 'image_file')
            ->where('m_id', $id)
            ->get()
            ->toArray();

        // dd(compact('material', 'categories', 'selectedCategories', 'properties', 'techProperties', 'susProperties', 'images'));

        return view('materials.edit', compact('material', 'categories', 'selectedCategories', 'properties', 'techProperties', 'susProperties', 'images'));
    }

    public function store(Request $request)
    {
        return $this->handleMaterialRequest($request);
    }

    public function update(Request $request, $m_id)
    {
        return $this->handleMaterialRequest($request, $m_id);
    }

    public function show(string $m_id)
    {
        $material = DB::table('materials')
            ->select('materials.material_code', 'materials.name', 'materials.description', 'materials.year', 'm_id', 'image_file', 'enabled', 'material_source')
            ->where('m_id', $m_id)
            ->first();

        $categories = DB::table('item_categories')
            ->leftJoin('categories', 'item_categories.c_id', '=', 'categories.c_id')
            ->select('categories.name', 'categories.description as category_description', 'categories.c_id')
            ->where('m_id', $m_id)
            ->orderBy('categories.name', 'asc')
            ->get();

        $selectedCategories = DB::table('item_categories')
            ->where('m_id', $m_id)
            ->pluck('c_id')
            ->toArray();

        $images = DB::table('material_images')
            ->select('mi_id', 'image_file')
            ->where('m_id', $m_id)
            ->get()
            ->toArray();

        $properties = DB::table('properties')
            ->select('*')
            ->where('m_id', $m_id)
            ->where('type', '=', 'soft')
            ->get();

        $techProperties = DB::table('properties')
            ->select('*')
            ->where('m_id', $m_id)
            ->where('type', '=', 'technical')
            ->get();

        $susProperties = DB::table('properties')
            ->select('*')
            ->where('m_id', $m_id)
            ->where('type', '=', 'application')
            ->get();

        // dd(compact('material', 'categories', 'images', 'properties', 'techProperties', 'susProperties', 'selectedCategories'));

        return view('materials.show', compact('material', 'categories', 'images', 'properties', 'techProperties', 'susProperties', 'selectedCategories'));
    }

    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            $imagePaths = DB::table('material_images')->where('m_id', $id)->pluck('image_file')->toArray();

            DB::table('item_categories')->where('m_id', $id)->delete();
            DB::table('item_properties')->where('m_id', $id)->delete();
            DB::table('material_images')->where('m_id', $id)->delete();
            DB::table('materials')->where('m_id', $id)->delete();

            $this->deleteUploadedImages($imagePaths);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Material deleted successfully',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error deleting material: '.$e->getMessage(),
            ], 500);
        }
    }

    // Helper methods
    protected function handleMaterialRequest(Request $request, $materialId = null)
    {
        $validator = $this->validateMaterialRequest($request, $materialId);
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
                if ($materialId) {
                    $oldMainImage = DB::table('materials')->where('m_id', $materialId)->value('image_file');
                    if ($oldMainImage) {
                        \Storage::disk('public')->delete($oldMainImage);
                    }
                }
                $mainImagePath = $request->file('mainImage')->store('material_images', 'public');
                $storedImagePaths[] = $mainImagePath;
            }
            $materialId = $this->createOrUpdateMaterial($request, $mainImagePath, $materialId);

            $this->syncCategories($materialId, $request->input('categories'));
            if ($request->input('properties')) {
                $this->syncProperties($materialId, $request->input('properties'));
            }

            if ($request->hasFile('imageFiles')) {
                $storedImagePaths = array_merge(
                    $storedImagePaths,
                    $this->uploadAndStoreImages($materialId, $request->file('imageFiles'))
                );
            }

            DB::commit();

            if ($request->has('deleteOldSubImageIds')) {
                DB::table('material_images')
                    ->whereIn('mi_id', $request->input('deleteOldSubImageIds'))
                    ->delete();
            }

            if ($request->has('deleteOldProps')) {
                DB::table('properties')
                    ->whereIn('p_id', $request->input('deleteOldProps'))
                    ->delete();
            }
            if ($request->has('deleteOldTechProps')) {
                DB::table('properties')
                    ->whereIn('p_id', $request->input('deleteOldTechProps'))
                    ->delete();
            }
            if ($request->has('deleteOldAppProps')) {
                DB::table('properties')
                    ->whereIn('p_id', $request->input('deleteOldAppProps'))
                    ->delete();
            }
            session()->flash('success', 'Material '.($materialId ? 'updated' : 'created').' successfully!');

            return response()->json([
                'success' => true,
                'message' => 'Material '.($materialId ? 'updated' : 'created').' successfully',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            $this->deleteUploadedImages($storedImagePaths);

            return response()->json([
                'success' => false,
                'message' => 'Error processing material: '.$e->getMessage(),
            ], 500);
        }
    }

    protected function validateMaterialRequest(Request $request, $materialId = null)
    {
        $uniqueCodeRule = 'unique:materials,material_code'.($materialId ? ",{$materialId},m_id" : '');
        if (! preg_match('/>(\s*[^<\s].*?)</', $request->description)) {
            $request->merge(['description' => strip_tags($request->description)]);
        }
        if ($request->description == strip_tags($request->description)) {
            $request->merge(['description' => trim(str_replace('&nbsp;', '', $request->description))]);
        }
        // <p>&nbsp;</p><p><br></p> not handled yet

        return Validator::make($request->all(), [
            'code' => 'required|'.$uniqueCodeRule,
            'name' => 'required',
            'material_source' => 'nullable|string|min:3|max:255',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,c_id',
            'properties' => 'sometimes|array',
            'properties.*.name' => 'required',
            'properties.*.value' => 'required',
            'properties.*.type' => 'required|in:soft,technical,application',
            'mainImage' => ($materialId ? 'sometimes' : 'required').'|image|mimes:jpeg,png,jpg,gif,svg|max:102400',
            'imageFiles' => 'sometimes|array',
            'imageFiles.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:102400',
            'year' => 'required|digits:4',
            'description' => 'required',
            'deleteOldSubImageIds' => 'sometimes|array',
            'deleteOldSubImageIds.*' => 'exists:material_images,mi_id',
            'deleteOldProps' => 'sometimes|array',
            'deleteOldProps.*' => 'exists:properties,p_id',
            'deleteOldTechProps' => 'sometimes|array',
            'deleteOldTechProps.*' => 'exists:properties,p_id',
            'deleteOldAppProps' => 'sometimes|array',
            'deleteOldAppProps.*' => 'exists:properties,p_id',
            'enabled' => 'required|in:0,1',
        ], messages: [
            'code.required' => 'The material code is required.',
            'code.unique' => 'The material code must be unique.',
            'name.required' => 'The material name is required.',
            'material_source.max' => 'The material source must not exceed 255 characters.',
            'categories.required' => 'At least one category is required.',
            'categories.*.exists' => 'A selected category is invalid.',
            'properties.*.name.required' => 'The property name is required.',
            'properties.*.value.required' => 'The property value is required.',
            'properties.*.type.required' => 'The property type is required.',
            'mainImage.required' => 'The main image is required.',
            'mainImage.image' => 'The main image must be an image file.',
            'mainImage.max' => 'The main image may not be greater than 100MB.',
            'imageFiles.*.image' => 'Each image file must be an image.',
            'imageFiles.*.max' => 'Each image file may not be greater than 100MB.',
            'year.required' => 'The year is required.',
            'year.digits' => 'Invalid year',
            'description.required' => 'The description is required.',
        ]);
    }

    // materials table
    protected function createOrUpdateMaterial(Request $request, $imageFilePath, $materialId = null)
    {
        $materialData = [
            'material_code' => $request->input('code'),
            'name' => $request->input('name'),
            'material_source' => $request->input('material_source'),
            'description' => $request->input('description'),
            'year' => $request->input('year'),
            'updated_by' => auth()->id(),
            'updated_at' => now(),
            'enabled' => $request->input('enabled'),
        ];

        if ($request->has('mainImage')) {
            $materialData['image_file'] = $imageFilePath;
        }

        if ($materialId) {
            DB::table('materials')
                ->where('m_id', $materialId)
                ->update($materialData);
        } else {
            $materialData['created_by'] = auth()->id();
            $materialData['created_at'] = now();
            $materialId = DB::table('materials')->insertGetId($materialData);
        }

        return $materialId;
    }

    // item_categories table
    protected function syncCategories($materialId, $categories)
    {
        DB::table('item_categories')->where('m_id', $materialId)->delete();

        $categoryData = array_map(function ($c_id) use ($materialId) {
            return [
                'm_id' => $materialId,
                'c_id' => $c_id,
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $categories);
        DB::table('item_categories')->insert($categoryData);
    }

    // properties table
    protected function syncProperties($materialId, $properties)
    {
        DB::table('properties')->where('m_id', $materialId)->delete();
        $propertyData = [];
        foreach ($properties as $property) {
            $propertyData[] = [
                'm_id' => $materialId,
                'name' => $property['name'],
                'type' => $property['type'],
                'value' => $property['value'],
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('properties')->insert($propertyData);
    }

    // material_images table
    protected function uploadAndStoreImages($materialId, $imageFiles)
    {
        $storedPaths = [];
        $imageData = [];

        foreach ($imageFiles as $file) {
            $path = $file->store('material_images', 'public');
            $storedPaths[] = $path;

            $imageData[] = [
                'm_id' => $materialId,
                'image_file' => $path,
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('material_images')->insert($imageData);

        return $storedPaths;
    }

    protected function deleteUploadedImages($paths)
    {
        foreach ($paths as $path) {
            \Storage::disk('public')->delete($path);
        }
    }
}
