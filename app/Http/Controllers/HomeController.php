<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
{
    // Fetch all categories with dynamic item relations counted for the flags
    $categories = Category::withCount('products')->orderBy('name', 'asc')->get();

    // Query builder initialization pipeline
    $products = Product::query();

    // Handle string search parameters if requested
    $products->when($request->filled('search'), function($query) use ($request) {
        $query->where('name', 'LIKE', '%' . $request->search . '%');
    });

    // Pipeline allocation to filter via requested category array IDs
    $products->when($request->has('categories'), function($query) use ($request) {
        $query->whereHas('categories', function($subQuery) use ($request) {
            $subQuery->whereIn('categories.id', $request->categories);
        });
    });

    // Execute paginated collection instance
    $products = $products->latest()->paginate(12)->withQueryString();

    return view('welcome', compact('products', 'categories'));
}
}
