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
            'categories'=> $categories,
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
            'message'=>'Category created successfully',
            'category'=>$category
        ],201);
    }

    public function show($id)
    {
        $category= Category::with('subCategories','products','mainCategory')->findOrFail($id);

        return response()->json([
            'category'=>$category,
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
            'message'=>'Category updated successfully',
            'category'=>$category
        ]);
    }

    public function destroy($id)
    {
      $category= Category::findOrFail($id);
      $category->delete();
        return response()->json([
            'message'=>'Category deleted successfully',
        ]);

    }
}
