<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // public function index()
    // {
    //     $categories = Category::all();
    //     return view('categories.index', compact('categories'));
    // }

    // public function create()
    // {
    //     return view('categories.create');
    // }

    // public function store(CategoryRequest $request)
    // {
    //     // $request->validate([
    //     //     'name' => 'required|string|max:255',
    //     // ]);

    //     // Category::create($request->all());

    //     Category::create($request->validated());

    //     return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    // }

    // // public function show(Category $category)
    // // {
    // //     return view('categories.show', compact('category'));
    // // }

    // public function edit(Category $category)
    // {
    //     return view('categories.edit', compact('category'));
    // }

    // public function update(CategoryRequest $request, Category $category)
    // {
    //     // $request->validate([
    //     //     'name' => 'required|string|max:255',
    //     // ]);
        
    //     // $category->update($request->all());

    //     $category->update($request->validated());

    //     return redirect()->route('categories.index')->with('success', 'Category Update successfully.');
    // }

    // public function destroy(Category $category)
    // {
    //     $category->delete();

    //     return redirect()->route('categories.index');
    // }



    // public function index()
    // {
    //     $categories = Category::all();
    //     // $products = Product::with('category')->get();
    //     return view('categories.index', compact('categories'));
    // }

    // public function store(Request $request)
    // {
    //     $category = Category::create($request->all());
    //     return response()->json($category);
    // }

    // public function edit($id)
    // {
    //     $category = Category::findOrFail($id);
    //     return response()->json($category);
    // }

    // public function update(Request $request, $id)
    // {
    //     $category = Category::findOrFail($id);
    //     $category->update($request->all());
    //     return response()->json($category);
    // }

    // public function destroy($id)
    // {
    //     Category::findOrFail($id)->delete();
    //     return response()->json(['message' => 'Category deleted successfully']);
    // }



    public function index()
    {
        $categories = Category::all(); 
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        return Category::create($request->all());
    }

    public function show($id)
    {
        return Category::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->update($request->all());
        return $category;
    }

    public function destroy($id)
    {
        Category::findOrFail($id)->delete();
        return 204;
    }
}
