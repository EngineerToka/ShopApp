<?php

namespace App\Http\Controllers\Category;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Category\Category;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{

    public function index()
    {
        $categories= Category::with('subCategories')->paginate(10);

         return response()->json([
            'success' => true,
            'message' => 'Categories retrieved successfully.',
            'data' => CategoryResource::collection($categories)
        ]);
    }

    public function store(CategoryRequest $request)
    {
        $category = category::create([
            'name'=>$request->name,
            'slug'=> Str::slug($request->name),
            'parent_id'=>$request->parent_id ?? null
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Category created successfully.',
            'data' => new CategoryResource($category)
        ], 201);
    }

    public function show($id)
    {
        $category= Category::with('subCategories','products','mainCategory')->findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Category retrieved successfully.',
            'data' => new CategoryResource($category)
        ]);

    }

    public function update(CategoryRequest $request, $id)
    {
        $category= Category::with('subCategories','products','mainCategory')->findOrFail($id);

        $category->update([
            'name'=>$request->name,
            'slug'=> Str::slug($request->name),
            'parent_id'=>$request->parent_id ?? null
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Category updated successfully.',
            'data' => new CategoryResource($category)
        ]);
    }

    public function destroy($id)
    {
      $category= Category::findOrFail($id);
      $category->delete();
      
         return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully.'
        ]);
    }
}
