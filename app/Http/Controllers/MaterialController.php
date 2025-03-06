<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Validator;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $name = '';
        $material_code = '';

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

        $query = $query->orderBy('name', 'asc');

        $materials = $query->get();

        return view('materials.index', compact('materials', 'name', 'material_code'));
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
            ->where('type', '=', "soft")
            ->get(); 

        $techProperties = DB::table('properties')
            ->select('*')
            ->where('m_id', $id)
            ->where('type', '=', "technical")
            ->get(); 

        $susProperties = DB::table('properties')
            ->select('*')
            ->where('m_id', $id)
            ->where('type', '=', "application")
            ->get(); 


        
        $images = DB::table('material_images')
            ->where('m_id', $id)
            ->pluck('image_file')
            ->toArray();

        return view('materials.edit', compact('material', 'categories', 'selectedCategories', 'properties', 'techProperties', 'susProperties', 'images'));
    }

    public function store(Request $request)
    {
        return $this->handleMaterialRequest($request);
    }

    public function update(Request $request, $m_id)
    {
        dd("hello u reached update");
        return $this->handleMaterialRequest($request, $m_id);
    }

    public function show(string $m_id)
    {
        $material = DB::table('materials')
            ->select('materials.material_code', 'materials.name', 'materials.description', 'materials.year', 'm_id')
            ->where('m_id', $m_id)
            ->first();

        $categories = DB::table('item_categories')
            ->leftJoin('categories', 'item_categories.c_id', '=', 'categories.c_id')
            ->select('categories.name as category_name', 'categories.description as category_description')
            ->where('m_id', $m_id)
            ->orderBy('categories.name', 'asc')
            ->get();

        $images = DB::table('material_images')
            ->where('m_id', $m_id)
            ->pluck('image_file')
            ->first();

        $soft_properties = DB::table('item_properties')
            ->leftJoin('properties', 'item_properties.p_id', '=', 'properties.p_id')
            ->select('item_properties.*', 'properties.name as property_name', 'properties.type')
            ->where('m_id', $m_id)
            ->where('properties.type', 'soft')
            ->get();

        $technical_properties = DB::table('item_properties')
            ->leftJoin('properties', 'item_properties.p_id', '=', 'properties.p_id')
            ->select('item_properties.*', 'properties.name as property_name', 'properties.type')
            ->where('m_id', $m_id)
            ->where('properties.type', 'technical')
            ->get();

        $application_properties = DB::table('item_properties')
            ->leftJoin('properties', 'item_properties.p_id', '=', 'properties.p_id')
            ->select('item_properties.*', 'properties.name as property_name', 'properties.type')
            ->where('m_id', $m_id)
            ->where('properties.type', 'application')
            ->get();

        // dd(compact('material', 'categories', 'images', 'soft_properties', 'technical_properties', 'application_properties'));

        return view('materials.show', compact('material', 'categories', 'images', 'soft_properties', 'technical_properties', 'application_properties'));
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
                'message' => 'Error deleting material: ' . $e->getMessage(),
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

            $mainImagePath = $request->file('mainImage')->store('material_images', 'public');
            $storedImagePaths[] = $mainImagePath;
            $materialId = $this->createOrUpdateMaterial($request, $mainImagePath, $materialId);
            
            $this->syncCategories($materialId, $request->input('categories'));
            if($request->input('properties')){
                $this->syncProperties($materialId, $request->input('properties'));
            }

            if ($request->hasFile('imageFiles')) {
                $storedImagePaths = array_merge(
                    $storedImagePaths,
                    $this->uploadAndStoreImages($materialId, $request->file('imageFiles'))
                );
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Material ' . ($materialId ? 'updated' : 'created') . ' successfully',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            $this->deleteUploadedImages($storedImagePaths);

            return response()->json([
                'success' => false,
                'message' => 'Error processing material: ' . $e->getMessage(),
            ], 500);
        }
    }

    protected function validateMaterialRequest(Request $request, $materialId = null)
    {
        $uniqueCodeRule = 'unique:materials,material_code' . ($materialId ? ",{$materialId},m_id" : '');

        return Validator::make($request->all(), [
            'code' => 'required|' . $uniqueCodeRule,
            'name' => 'required',
            'categories' => 'sometimes|array',
            'categories.*' => 'exists:categories,c_id',
            'properties' => 'sometimes|array',
            'properties.*.name' => 'required',
            'properties.*.value' => 'required',
            'properties.*.type' => 'required|in:soft,technical,application',
            'mainImage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:102400',
            'imageFiles' => 'sometimes|array',
            'imageFiles.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:102400',
            'year' => 'required|digits:4',
            'description' => 'required',
        ], messages: [
            'code.required' => 'The material code is required.',
            'code.unique' => 'The material code must be unique.',
            'name.required' => 'The material name is required.',
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
            'description' => $request->input('description'),
            'image_file' => $imageFilePath,
            'year' => $request->input('year'),
            'updated_by' => auth()->id(),
            'updated_at' => now(),
        ];

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

    // item_properties table
    protected function syncProperties($materialId, $properties)
    {
        DB::table('item_properties')->where('m_id', $materialId)->delete();

        $propertyData = [];
        foreach ($properties as $property) {
            $propertyId = $this->getOrCreatePropertyId(
                $property['name'],
                $property['type']
            );

            $propertyData[] = [
                'm_id' => $materialId,
                'p_id' => $propertyId,
                'value' => $property['value'],
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('item_properties')->insert($propertyData);
    }

    // properties table
    protected function getOrCreatePropertyId($name, $type)
    {
        $propertyId = DB::table('properties')
            ->where('name', $name)
            ->where('type', $type)
            ->value('p_id');

        if (!$propertyId) {
            $propertyId = DB::table('properties')->insertGetId([
                'name' => $name,
                'type' => $type,
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return $propertyId;
    }

    // material_images table
    protected function uploadAndStoreImages($materialId, $imageFiles)
    {
        DB::table('material_images')->where('m_id', $materialId)->delete();
        
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
