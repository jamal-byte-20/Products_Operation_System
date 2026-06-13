{{-- resources/views/products/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Products Management')

@section('content')
<div class="products-page">
    <div class="page-container">
        {{-- Header Section --}}
        <div class="page-header">
            <div class="header-left">
                <h1 class="page-title">
                    <span class="title-icon">📦</span>
                    Products Management
                </h1>
                <p class="page-subtitle">Manage your product inventory</p>
            </div>
            <div class="header-right">
                <a href="{{ route('products.create') }}" class="btn-primary">
                    <span class="btn-icon">+</span>
                    Add New Product
                </a>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">📊</div>
                <div class="stat-info">
                    <h3>Total Products</h3>
                    <p></p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">💰</div>
                <div class="stat-info">
                    <h3>Total Value</h3>
                    <p>${{ number_format($products->sum('price'), 2) }}</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">📦</div>
                <div class="stat-info">
                    <h3>Low Stock</h3>
                    <p>{{ $products->where('stock', '<=', 10)->count() }}</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">🏷️</div>
                <div class="stat-info">
                    <h3>Categories</h3>
                    <p>{{ \App\Models\Category::count() }}</p>
                </div>
            </div>
        </div>

        {{-- Filters Section --}}
        <div class="filters-card">
            <form method="GET" action="{{ route('products.index') }}" class="filters-form">
                <div class="filter-group">
                    <label for="category">
                        <span class="filter-icon">🔍</span>
                        Category
                    </label>
                    <select name="category" id="category" class="filter-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->icon ?? '📁' }} {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label for="search">
                        <span class="filter-icon">🔎</span>
                        Search
                    </label>
                    <input type="text" name="search" id="search" class="filter-input" 
                           placeholder="Search products..." value="{{ request('search') }}">
                </div>

                <div class="filter-group">
                    <label for="sort">
                        <span class="filter-icon">⚡</span>
                        Sort by
                    </label>
                    <select name="sort" id="sort" class="filter-select">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name: A to Z</option>
                        <option value="stock_asc" {{ request('sort') == 'stock_asc' ? 'selected' : '' }}>Stock: Low to High</option>
                    </select>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn-filter">Apply Filters</button>
                    @if(request('category') || request('search') || request('sort'))
                        <a href="{{ route('products.index') }}" class="btn-reset">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="alert alert-success">
                <span class="alert-icon">✅</span>
                {{ session('success') }}
                <button class="alert-close" onclick="this.parentElement.remove()">✕</button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <span class="alert-icon">❌</span>
                {{ session('error') }}
                <button class="alert-close" onclick="this.parentElement.remove()">✕</button>
            </div>
        @endif

        {{-- Products Table --}}
        <div class="table-container">
            <table class="products-table">
                <thead>
                    <tr>
                        <th class="col-id">ID</th>
                        <th class="col-image">Image</th>
                        <th class="col-name">Product</th>
                        <th class="col-category">Category</th>
                        <th class="col-price">Price</th>
                        <th class="col-stock">Stock</th>
                        <th class="col-date">Created</th>
                        <th class="col-actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr class="product-row">
                            <td class="col-id" data-label="ID">
                                <span class="product-id">#{{ $product->id }}</span>
                            </td>
                            <td class="col-image" data-label="Image">
                                <div class="product-image">
                                    <img src="{{ $product->image ?? 'https://via.placeholder.com/50x50?text=No+Image' }}" 
                                         alt="{{ $product->name }}"
                                         onerror="this.src='https://via.placeholder.com/50x50?text=No+Image'">
                                </div>
                            </td>
                            <td class="col-name" data-label="Product">
                                <div class="product-info">
                                    <div class="product-name">{{ $product->name }}</div>
                                    <div class="product-description">{{ Str::limit($product->description, 60) }}</div>
                                </div>
                            </td>
                            <td class="col-category" data-label="Category">
                                @if($product->category)
                                    <span class="category-badge">
                                        {{ $product->category->icon ?? '📦' }}
                                        {{ $product->category->name }}
                                    </span>
                                @else
                                    <span class="category-badge uncategorized">📁 Uncategorized</span>
                                @endif
                            </td>
                            <td class="col-price" data-label="Price">
                                <div class="price-container">
                                    <span class="currency">$</span>
                                    <span class="price-value">{{ number_format($product->price, 2) }}</span>
                                </div>
                            </td>
                            <td class="col-stock" data-label="Stock">
                                <div class="stock-container">
                                    <span class="stock-badge {{ $product->stock > 10 ? 'stock-high' : ($product->stock > 0 ? 'stock-medium' : 'stock-out') }}">
                                        @if($product->stock == 0)
                                            Out of Stock
                                        @elseif($product->stock <= 10)
                                            Low Stock ({{ $product->stock }})
                                        @else
                                            In Stock ({{ $product->stock }})
                                        @endif
                                    </span>
                                </div>
                            </td>
                            <td class="col-date" data-label="Created">
                                <div class="date-info">
                                    <span class="date-day">{{ $product->created_at->format('d M Y') }}</span>
                                    <span class="date-time">{{ $product->created_at->format('H:i') }}</span>
                                </div>
                            </td>
                            <td class="col-actions" data-label="Actions">
                                <div class="action-buttons">
                                    <a href="{{ route('products.show', $product->id) }}" class="action-btn btn-view" title="View Product">
                                        👁️
                                    </a>
                                    <a href="{{ route('products.edit', $product->id) }}" class="action-btn btn-edit" title="Edit Product">
                                        ✏️
                                    </a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="delete-form" 
                                          onsubmit="return confirmDelete('{{ addslashes($product->name) }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn btn-delete" title="Delete Product">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="empty-state">
                                <div class="empty-state-content">
                                    <span class="empty-icon">📭</span>
                                    <h3>No Products Found</h3>
                                    <p>Get started by creating your first product</p>
                                    <a href="{{ route('products.create') }}" class="btn-primary btn-sm">
                                        + Add New Product
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($products->hasPages())
            <div class="pagination-wrapper">
                {{ $products->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>

<style>
    /* ========== GLOBAL STYLES ========== */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .products-page {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .page-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 1.5rem;
    }

    /* ========== HEADER SECTION ========== */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .header-left {
        flex: 1;
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 700;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .title-icon {
        font-size: 2rem;
    }

    .page-subtitle {
        color: #4a5568;
        font-size: 0.95rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(102, 126, 234, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .btn-icon {
        font-size: 1.3rem;
        font-weight: bold;
    }

    /* ========== STATS CARDS ========== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    .stat-icon {
        font-size: 2.5rem;
    }

    .stat-info h3 {
        font-size: 0.85rem;
        color: #718096;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .stat-info p {
        font-size: 1.75rem;
        font-weight: 700;
        color: #2d3748;
    }

    /* ========== FILTERS SECTION ========== */
    .filters-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .filters-form {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        align-items: flex-end;
    }

    .filter-group {
        flex: 1;
        min-width: 180px;
    }

    .filter-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #4a5568;
        font-size: 0.85rem;
    }

    .filter-icon {
        margin-right: 0.25rem;
    }

    .filter-select,
    .filter-input {
        width: 100%;
        padding: 0.6rem 1rem;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .filter-select:focus,
    .filter-input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .filter-actions {
        display: flex;
        gap: 0.5rem;
    }

    .btn-filter,
    .btn-reset {
        padding: 0.6rem 1.2rem;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-filter {
        background: #667eea;
        color: white;
    }

    .btn-filter:hover {
        background: #5a67d8;
        transform: translateY(-1px);
    }

    .btn-reset {
        background: #e2e8f0;
        color: #4a5568;
    }

    .btn-reset:hover {
        background: #cbd5e0;
    }

    /* ========== ALERTS ========== */
    .alert {
        padding: 1rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        animation: slideDown 0.3s ease;
        position: relative;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert-success {
        background: #c6f6d5;
        color: #22543d;
        border-left: 4px solid #38a169;
    }

    .alert-error {
        background: #fed7d7;
        color: #742a2a;
        border-left: 4px solid #e53e3e;
    }

    .alert-icon {
        font-size: 1.2rem;
    }

    .alert-close {
        margin-left: auto;
        background: none;
        border: none;
        font-size: 1.2rem;
        cursor: pointer;
        opacity: 0.6;
        transition: opacity 0.3s;
    }

    .alert-close:hover {
        opacity: 1;
    }

    /* ========== TABLE STYLES ========== */
    .table-container {
        background: white;
        border-radius: 15px;
        overflow-x: auto;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        margin-bottom: 1.5rem;
    }

    .products-table {
        width: 100%;
        border-collapse: collapse;
    }

    .products-table thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .products-table th {
        padding: 1rem;
        color: white;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-align: left;
    }

    .products-table td {
        padding: 1rem;
        border-bottom: 1px solid #e2e8f0;
        vertical-align: middle;
    }

    .product-row:hover {
        background: #f7fafc;
        transition: background 0.3s;
    }

    /* Column widths */
    .col-id { width: 5%; }
    .col-image { width: 8%; }
    .col-name { width: 25%; }
    .col-category { width: 12%; }
    .col-price { width: 10%; }
    .col-stock { width: 10%; }
    .col-date { width: 12%; }
    .col-actions { width: 10%; }

    /* Product image */
    .product-image {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        overflow: hidden;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-id {
        font-weight: 600;
        color: #4a5568;
        font-family: monospace;
    }

    .product-name {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0.25rem;
    }

    .product-description {
        font-size: 0.8rem;
        color: #718096;
    }

    /* Category badge */
    .category-badge {
        display: inline-block;
        padding: 0.3rem 0.8rem;
        background: linear-gradient(135deg, #e9d8fd 0%, #d6bcfa 100%);
        color: #553c9a;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .category-badge.uncategorized {
        background: #e2e8f0;
        color: #718096;
    }

    /* Price */
    .price-container {
        display: flex;
        align-items: baseline;
        gap: 0.15rem;
    }

    .currency {
        font-size: 0.8rem;
        font-weight: 600;
        color: #48bb78;
    }

    .price-value {
        font-weight: 700;
        font-size: 1.1rem;
        color: #2c7a2c;
    }

    /* Stock badge */
    .stock-badge {
        display: inline-block;
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-align: center;
    }

    .stock-high {
        background: #c6f6d5;
        color: #22543d;
    }

    .stock-medium {
        background: #feebc8;
        color: #975a16;
    }

    .stock-out {
        background: #fed7d7;
        color: #742a2a;
    }

    /* Date info */
    .date-info {
        display: flex;
        flex-direction: column;
    }

    .date-day {
        font-size: 0.85rem;
        font-weight: 500;
        color: #2d3748;
    }

    .date-time {
        font-size: 0.7rem;
        color: #a0aec0;
    }

    /* Action buttons */
    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.4rem 0.6rem;
        border-radius: 8px;
        text-decoration: none;
        font-size: 1rem;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
    }

    .btn-view {
        background: #e2e8f0;
        color: #4a5568;
    }

    .btn-view:hover {
        background: #cbd5e0;
        transform: scale(1.05);
    }

    .btn-edit {
        background: #fefcbf;
        color: #975a16;
    }

    .btn-edit:hover {
        background: #fde68a;
        transform: scale(1.05);
    }

    .btn-delete {
        background: #fed7d7;
        color: #c53030;
    }

    .btn-delete:hover {
        background: #feb2b2;
        transform: scale(1.05);
    }

    .delete-form {
        display: inline;
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 4rem !important;
    }

    .empty-state-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
    }

    .empty-icon {
        font-size: 4rem;
    }

    .empty-state-content h3 {
        font-size: 1.5rem;
        color: #2d3748;
    }

    .empty-state-content p {
        color: #718096;
    }

    .btn-sm {
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
    }

    /* Pagination */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
    }

    .pagination-wrapper nav {
        display: inline-block;
    }

    /* ========== RESPONSIVE DESIGN ========== */
    @media (max-width: 768px) {
        .page-container {
            padding: 0 1rem;
        }

        .page-title {
            font-size: 1.8rem;
        }

        .stats-grid {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        /* Mobile table view */
        .products-table thead {
            display: none;
        }

        .products-table tbody tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            background: white;
        }

        .products-table td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            padding: 0.75rem;
            border-bottom: 1px solid #edf2f7;
        }

        .products-table td:before {
            content: attr(data-label);
            font-weight: 600;
            color: #4a5568;
            min-width: 100px;
        }

        .products-table td:last-child {
            border-bottom: none;
        }

        .action-buttons {
            justify-content: flex-end;
        }

        .filter-group {
            min-width: 100%;
        }

        .filter-actions {
            width: 100%;
        }

        .btn-filter, .btn-reset {
            flex: 1;
            text-align: center;
        }
    }
</style>

<script>
    function confirmDelete(productName) {
        return confirm(`Are you sure you want to delete "${productName}"? This action cannot be undone.`);
    }
</script>
@endsection