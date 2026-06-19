<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Use 'categories' (plural) not 'category' (singular)
        $query = Product::with('categories'); // Changed from 'category' to 'categories'

        // Search filter
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Category filter - using whereHas for many-to-many
        if ($request->filled('category')) {
            $query->whereHas('categories', function($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }

        // Sorting
        switch ($request->get('sort', 'latest')) {
            case 'latest':
                $query->latest();
                break;
            case 'oldest':
                $query->oldest();
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'stock_asc':
                $query->orderBy('stock', 'asc');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(15);
        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    public function create(){
        $categories = Category::all();
        return view('products.create',compact('categories'));
    }
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'quantity' => 'nullable|integer|min:0',
        'image' => 'nullable|url',
        'categories' => 'nullable|array',
        'categories.*' => 'exists:categories,id'
    ]);

    // Create the product
    $product = Product::create([
        'name' => $validated['name'],
        'description' => $validated['description'],
        'price' => $validated['price'],
        'stock' => $validated['stock'],
        'quantity' => $validated['quantity'],
        'image' => $validated['image']

    ]);
    
    // Attach categories (many-to-many)
    if ($request->has('categories')) {
        $product->categories()->attach($request->categories);
    }

    return redirect()->route('products.index')
        ->with('success', 'Product created successfully!');
}

    public function show(Product $product)
    {
        // Load categories relationship
        $product->load('categories');
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        // Load categories relationship
        $product->load('categories');
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|url',
            'categories' => 'nullable|array', // For many-to-many
            'categories.*' => 'exists:categories,id'
        ]);

        $product->update($validated);
        
        // Sync categories for many-to-many relationship
        if ($request->has('categories')) {
            $product->categories()->sync($request->categories);
        }

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        // Detach all categories first (many-to-many)
        $product->categories()->detach();
        $product->delete();
        
        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully!');
    }
}