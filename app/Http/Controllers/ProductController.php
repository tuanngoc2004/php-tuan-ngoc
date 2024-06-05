<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Repositories\Product\ProductRepositoryInterface;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        // $categories = Category::all();
        // $products = Product::all();
        // return response()->json(['products'=>$products, 'categories'=>$categories]);
             
        // $products = Product::
        //     join('categories', 'products.category_id', '=', 'categories.id')
        //     ->select(
        //         'products.*',
        //         'categories.name as categories'
        //     )->get();
        $products = $this->productRepository->getAllWithCategories();
        return response()->json($products); 
    }
    public function store(Request $request)
    {
        // $product = Product::create($request->all());
        $product = $this->productRepository->create($request->all());
        return response()->json($product);
    }

    public function edit($id)
    {
        // $product = Product::with('category')->findOrFail($id);
        $product = $this->productRepository->find($id);
        return response()->json($product);
    }


    public function update(Request $request, $id)
    {
        // $product = Product::findOrFail($id);
        // $product->update($request->all());
        // $product->load('category');
        $product = $this->productRepository->update($id, $request->all());
        return response()->json($product);
    }

    public function destroy($id)
    {
        // Product::findOrFail($id)->delete();
        $this->productRepository->find($id)->delete($id);
        // $result = $this->productRepository->delete($id);
        // return $result ? response()->noContent() : response()->json(['error' => 'Product not found'], 404);
        return 204;
    }


    // public function index(Request $request)
    // {
    //     $query = Product::query();

    //     if ($request->filled('search')) {
    //         $query->where('name', 'like', '%' . $request->search . '%')
    //               ->orWhere('description', 'like', '%' . $request->search . '%');
    //     }

    //     $products = $query->with('category')->get();
    //     return view('products.index', compact('products'));
    // }

    // public function create()
    // {
    //     $categories = Category::all();
    //     return view('products.create', compact('categories'));
    // }

    // public function store(ProductRequest $request)
    // {
    //     // $request->validate([
    //     //     'category_id' => 'required|exists:categories,id',
    //     //     'name' => 'required|string|max:255',
    //     //     'description' => 'nullable|string',
    //     //     'price' => 'required|numeric',
    //     // ]);

    //     Product::create($request->validated());

    //     return redirect()->route('products.index');
    // }

    // public function show(Product $product)
    // {
    //     return view('products.show', compact('product'));
    // }

    // public function edit(Product $product)
    // {
    //     $categories = Category::all();
    //     return view('products.edit', compact('product', 'categories'));
    // }

    // public function update(ProductRequest $request, Product $product)
    // {
    //     // $request->validate([
    //     //     'category_id' => 'required|exists:categories,id',
    //     //     'name' => 'required|string|max:255',
    //     //     'description' => 'nullable|string',
    //     //     'price' => 'required|numeric',
    //     // ]);

    //     $product->update($request->validated());

    //     return redirect()->route('products.index');
    // }

    // public function destroy(Product $product)
    // {
    //     $product->delete();

    //     return redirect()->route('products.index');
    // }


    // public function index()
    // {
    //     $categories = Category::all();
    //     $products = Product::all();
    //     return view('products.index', compact('products', 'categories'));
    // }

    // public function store(Request $request)
    // {
    //     $product = Product::create($request->all());
    //     $product->load('category'); // Load category relationship
    //     // $product = Product::create($request->all());
    //     return response()->json($product);
    // }

    // public function edit($id)
    // {
    //     // $product = Product::findOrFail($id);
    //     $product = Product::with('category')->findOrFail($id);
    //     return response()->json($product);
    // }


    // public function update(Request $request, $id)
    // {
    //     $product = Product::findOrFail($id);
    //     $product->update($request->all());
    //     $product->load('category');
    //     return response()->json($product);
    // }

    // public function destroy($id)
    // {
    //     Product::findOrFail($id)->delete();
    //     return response()->json(['message' => 'Product deleted successfully']);
    // }
}
