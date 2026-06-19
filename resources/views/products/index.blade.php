{{-- resources/views/products/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Products Management | StockOps')

@section('content')
<div class="products-page">
    <div class="page-container">
        
        {{-- Header Section --}}
        <div class="page-header">
            <div class="header-left">
                <span class="system-status"><span class="status-dot"></span> Catalog Live</span>
                <h1 class="page-title">Products Management</h1>
                <p class="page-subtitle">Inspect, modify, filter, and append items within the active system storage layout.</p>
            </div>
            <div class="header-right">
                <a href="{{ route('products.create') }}" class="btn-primary">
                    + Add New Product
                </a>
            </div>
        </div>

        {{-- Core Metrics Stats Grid Layout --}}
        <div class="stats-grid">
            <div class="stat-card">
                <span class="stat-label">Total Products</span>
                <span class="stat-number">{{ $products->total() ?? $products->count() }}</span>
            </div>
            <div class="stat-card">
                <span class="stat-label">Total Value</span>
                <span class="stat-number">${{ number_format($products->sum('price'), 2) }}</span>
            </div>
            <div class="stat-card">
                <span class="stat-label">Low Stock Items</span>
                <span class="stat-number" style="{{ $products->where('stock', '<=', 10)->count() > 0 ? 'color: #dc3545;' : '' }}">
                    {{ $products->where('stock', '<=', 10)->count() }}
                </span>
            </div>
            <div class="stat-card">
                <span class="stat-label">Active Categories</span>
                <span class="stat-number">{{ \App\Models\Category::count() }}</span>
            </div>
        </div>

        {{-- Filters & Structural Search Panel --}}
        <div class="filters-panel-card">
            <form method="GET" action="{{ route('products.index') }}" class="filters-form">
                
                <div class="filter-group">
                    <label for="search" class="filter-label">Search Catalog</label>
                    <input type="text" name="search" id="search" class="filter-input" 
                           placeholder="Filter by title or slug..." value="{{ request('search') }}">
                </div>

                <div class="filter-group">
                    <label for="category" class="filter-label">Category Filter</label>
                    <select name="category" id="category" class="filter-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label for="sort" class="filter-label">Sort Parameters</label>
                    <select name="sort" id="sort" class="filter-select">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest Entries</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest Logs</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Alphabetical (A-Z)</option>
                        <option value="stock_asc" {{ request('sort') == 'stock_asc' ? 'selected' : '' }}>Stock Quantity Available</option>
                    </select>
                </div>

                <div class="filter-actions-row">
                    <button type="submit" class="btn-apply-filters">Apply</button>
                    @if(request('category') || request('search') || request('sort'))
                        <a href="{{ route('products.index') }}" class="btn-clear-reset">Clear Filters</a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Status Notification Alerts Layout --}}
        @if(session('success'))
            <div class="system-alert alert-success">
                <span class="alert-message"><strong>Success:</strong> {{ session('success') }}</span>
                <button class="alert-dismiss-btn" onclick="this.parentElement.remove()">✕</button>
            </div>
        @endif

        @if(session('error'))
            <div class="system-alert alert-error">
                <span class="alert-message"><strong>Error:</strong> {{ session('error') }}</span>
                <button class="alert-dismiss-btn" onclick="this.parentElement.remove()">✕</button>
            </div>
        @endif

        {{-- Minimalist Structured Products Data Table --}}
        <div class="table-viewport-wrapper">
            <table class="inventory-data-table">
                <thead>
                    <tr>
                        <th class="col-id">ID</th>
                        <th class="col-image">Asset</th>
                        <th class="col-name">Product Details</th>
                        <th class="col-category">Category Alignment</th>
                        <th class="col-price">Unit Price</th>
                        <th class="col-stock">Inventory Status</th>
                        <th class="col-date">Date Modified</th>
                        <th class="col-actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr class="data-table-row">
                            <td class="col-id" data-label="ID">
                                <span class="monospaced-id">#{{ $product->id }}</span>
                            </td>
                            <td class="col-image" data-label="Asset">
                                <div class="table-avatar-frame">
                                    <img src="{{ $product->image ?? 'https://via.placeholder.com/40x40?text=📦' }}" 
                                         alt="{{ $product->name }}"
                                         onerror="this.src='https://via.placeholder.com/40x40?text=📦'">
                                </div>
                            </td>
                            <td class="col-name" data-label="Product Details">
                                <div class="product-identity-block">
                                    <span class="primary-identity-name">{{ $product->name }}</span>
                                    <span class="secondary-identity-desc">{{ Str::limit($product->description, 55) }}</span>
                                </div>
                            </td>
                            <td class="col-category" data-label="Category Alignment">
                                <div class="tag-badge-container">
                                    @if($product->categories && $product->categories->count() > 0)
                                        @foreach ($product->categories as $category)
                                            <span class="flat-text-badge">{{ $category->name }}</span>
                                        @endforeach
                                    @else
                                        <span class="flat-text-badge muted-fallback">Unassigned</span>
                                    @endif
                                </div>
                            </td>
                            <td class="col-price" data-label="Unit Price">
                                <span class="tabular-price-text">${{ number_format($product->price, 2) }}</span>
                            </td>
                            <td class="col-stock" data-label="Inventory Status">
                                <span class="status-indicator-pill {{ $product->stock > 10 ? 'status-pill-ok' : ($product->stock > 0 ? 'status-pill-warning' : 'status-pill-danger') }}">
                                    @if($product->stock == 0)
                                        Out of Stock
                                    @elseif($product->stock <= 10)
                                        Low Stock ({{ $product->stock }})
                                    @else
                                        In Stock ({{ $product->stock }})
                                    @endif
                                </span>
                            </td>
                            <td class="col-date" data-label="Date Modified">
                                <div class="tabular-date-block">
                                    <span class="date-calendar-day">{{ $product->created_at->format('d M Y') }}</span>
                                    <span class="date-clock-time">{{ $product->created_at->format('H:i') }}</span>
                                </div>
                            </td>
                            <td class="col-actions" data-label="Actions">
                                <div class="table-action-links">
                                    <a href="{{ route('products.show', $product->id) }}" class="action-link-item" title="View Details">View</a>
                                    <a href="{{ route('products.edit', $product->id) }}" class="action-link-item" title="Edit Properties">Edit</a>
                                    
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline-delete-form" 
                                          onsubmit="return confirmRemoval('{{ addslashes($product->name) }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-link-item danger-link-item" title="Delete Row">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="table-empty-fallback">
                                <div class="empty-state-viewport">
                                    <h4 class="empty-state-title">No Catalog Records Retrieved</h4>
                                    <p class="empty-state-desc">Adjust your parameters or initialize a new record below.</p>
                                    <a href="{{ route('products.create') }}" class="btn-primary" style="margin-top: 0.5rem; font-size: 0.85rem; padding: 0.5rem 1rem;">
                                        + Add New Product
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Links Wrapper Row --}}
        @if($products->hasPages())
            <div class="pagination-navigation-row">
                {{ $products->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>

<style>
    /* ========== CLEAN HOME & MANAGEMENT VIEW DESIGN SYSTEM ========== */
    .products-page {
        background-color: #fdfdfd;
        min-height: 100vh;
        font-family: system-ui, sans-serif;
        color: #333;
        padding: 2rem 0;
    }

    .page-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    /* ========== BREADCRUMBS & HEADERS ========== */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 2.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #e9ecef;
    }

    .system-status {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.75rem;
        font-weight: bold;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }

    .status-dot {
        height: 6px;
        width: 6px;
        background-color: #28a745;
        border-radius: 50%;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        color: #222;
        margin: 0;
    }

    .page-subtitle {
        font-size: 0.95rem;
        color: #6c757d;
        margin: 0.25rem 0 0 0;
    }

    .btn-primary {
        background-color: #333;
        color: white;
        padding: 0.6rem 1.2rem;
        border-radius: 4px;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 500;
        transition: opacity 0.2s;
        display: inline-block;
    }

    .btn-primary:hover {
        opacity: 0.9;
        color: white;
    }

    /* ========== FLAT UNIFORM METRICS CARDS ========== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }

    .stat-card {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 6px;
        padding: 1.25rem;
        box-shadow: 0 4px 6px rgba(0,0,0,0.005);
    }

    .stat-label {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #868e96;
        display: block;
        font-weight: 600;
    }

    .stat-number {
        font-size: 1.85rem;
        font-weight: bold;
        color: #222;
        display: block;
        margin-top: 0.25rem;
    }

    /* ========== MANAGEMENT FILTERS BOX PANEL ========== */
    .filters-panel-card {
        background-color: white;
        border: 1px solid #e9ecef;
        border-radius: 6px;
        padding: 1.25rem;
        margin-bottom: 2rem;
    }

    .filters-form {
        display: grid;
        grid-template-columns: 1.5fr 1fr 1fr auto;
        gap: 1rem;
        align-items: flex-end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
    }

    .filter-label {
        font-size: 0.8rem;
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.4rem;
    }

    .filter-input, .filter-select {
        width: 100%;
        padding: 0.5rem 0.65rem;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 0.85rem;
        color: #333;
        background-color: white;
    }

    .filter-input:focus, .filter-select:focus {
        outline: none;
        border-color: #333;
    }

    .filter-actions-row {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .btn-apply-filters {
        background-color: #f1f3f5;
        border: 1px solid #ccc;
        color: #333;
        padding: 0.5rem 1rem;
        border-radius: 4px;
        font-size: 0.85rem;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .btn-apply-filters:hover {
        background-color: #e9ecef;
    }

    .btn-clear-reset {
        font-size: 0.8rem;
        color: #6c757d;
        text-decoration: none;
        padding: 0.5rem 0.25rem;
    }

    .btn-clear-reset:hover {
        color: #333;
    }

    /* ========== SYSTEM BROADCAST ALERTS ========== */
    .system-alert {
        padding: 0.85rem 1.25rem;
        border-radius: 4px;
        margin-bottom: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.85rem;
        border: 1px solid transparent;
    }

    .alert-success {
        background-color: #f4fbf7;
        border-color: #28a745;
        color: #1e5e2f;
    }

    .alert-error {
        background-color: #fff5f5;
        border-color: #dc3545;
        color: #721c24;
    }

    .alert-dismiss-btn {
        background: transparent;
        border: none;
        cursor: pointer;
        color: inherit;
        font-size: 0.85rem;
        opacity: 0.7;
    }

    .alert-dismiss-btn:hover {
        opacity: 1;
    }

    /* ========== TABULAR SYSTEM STRUCTURE ========== */
    .table-viewport-wrapper {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 6px;
        overflow: hidden;
    }

    .inventory-data-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .inventory-data-table th {
        background-color: #f8f9fa;
        color: #495057;
        font-weight: 600;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 0.85rem 1rem;
        border-bottom: 1px solid #e9ecef;
    }

    .inventory-data-table td {
        padding: 1rem;
        border-bottom: 1px solid #e9ecef;
        vertical-align: middle;
        font-size: 0.9rem;
    }

    .data-table-row:last-child td {
        border-bottom: none;
    }

    .data-table-row:hover {
        background-color: #fdfdfd;
    }

    /* Explicit width proportions */
    .col-id { width: 6%; }
    .col-image { width: 7%; }
    .col-name { width: 33%; }
    .col-category { width: 14%; }
    .col-price { width: 10%; }
    .col-stock { width: 13%; }
    .col-date { width: 12%; }
    .col-actions { width: 5%; }

    /* Component elements */
    .monospaced-id {
        font-family: monospace;
        color: #868e96;
        font-weight: 500;
    }

    .table-avatar-frame {
        width: 36px;
        height: 36px;
        border: 1px solid #e9ecef;
        border-radius: 4px;
        overflow: hidden;
        background-color: #f8f9fa;
    }

    .table-avatar-frame img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-identity-block {
        display: flex;
        flex-direction: column;
    }

    .primary-identity-name {
        font-weight: 600;
        color: #222;
        margin-bottom: 0.15rem;
    }

    .secondary-identity-desc {
        font-size: 0.8rem;
        color: #6c757d;
    }

    /* Flat minimal text category labels */
    .tag-badge-container {
        display: flex;
        flex-wrap: wrap;
        gap: 0.35rem;
    }

    .flat-text-badge {
        display: inline-block;
        font-size: 0.78rem;
        background-color: #f1f3f5;
        color: #495057;
        padding: 0.2rem 0.5rem;
        border-radius: 3px;
        font-weight: 500;
    }

    .flat-text-badge.muted-fallback {
        color: #adb5bd;
        background-color: transparent;
        padding-left: 0;
    }

    .tabular-price-text {
        font-weight: 600;
        color: #222;
    }

    /* Modern text context status rows */
    .status-indicator-pill {
        font-size: 0.8rem;
        font-weight: 600;
    }

    .status-pill-ok { color: #28a745; }
    .status-pill-warning { color: #fd7e14; }
    .status-pill-danger { color: #dc3545; }

    .tabular-date-block {
        display: flex;
        flex-direction: column;
    }

    .date-calendar-day {
        color: #495057;
        font-size: 0.85rem;
    }

    .date-clock-time {
        font-size: 0.72rem;
        color: #adb5bd;
    }

    /* Clean link listings for table management actions */
    .table-action-links {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .action-link-item {
        color: #007bff;
        text-decoration: none;
        font-size: 0.85rem;
        background: transparent;
        border: none;
        padding: 0;
        cursor: pointer;
    }

    .action-link-item:hover {
        text-decoration: underline;
    }

    .danger-link-item {
        color: #dc3545;
    }

    .inline-delete-form {
        display: inline;
    }

    /* Table empty fallbacks */
    .table-empty-fallback {
        text-align: center;
        padding: 4rem !important;
        background-color: #fff;
    }

    .empty-state-viewport {
        max-width: 320px;
        margin: 0 auto;
    }

    .empty-state-title {
        font-size: 1.1rem;
        margin: 0 0 0.25rem 0;
        color: #222;
    }

    .empty-state-desc {
        font-size: 0.85rem;
        color: #6c757d;
        margin: 0 0 1rem 0;
    }

    .pagination-navigation-row {
        margin-top: 2rem;
        display: flex;
        justify-content: center;
    }

    /* ========== RESPONSIVE GRID LAYOUTS ========== */
    @media (max-width: 900px) {
        .filters-form {
            grid-template-columns: 1fr 1fr;
        }
        .filter-actions-row {
            grid-column: span 2;
            justify-content: flex-end;
        }
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        .btn-primary {
            width: 100%;
            text-align: center;
        }
        .filters-form {
            grid-template-columns: 1fr;
        }
        .filter-actions-row {
            grid-column: span 1;
            width: 100%;
        }
        .btn-apply-filters {
            width: 100%;
            text-align: center;
        }

        /* Responsive Mobile Stack view block structure alternative */
        .inventory-data-table thead {
            display: none;
        }
        .inventory-data-table tbody tr {
            display: block;
            border-bottom: 2px solid #e9ecef;
            padding: 0.5rem 0;
        }
        .inventory-data-table td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.65rem 1rem;
            border-bottom: none;
        }
        .inventory-data-table td::before {
            content: attr(data-label);
            font-weight: 600;
            font-size: 0.8rem;
            color: #6c757d;
        }
        .table-action-links {
            justify-content: flex-end;
        }
    }
</style>

<script>
    function confirmRemoval(productName) {
        return confirm(`Are you sure you want to permanently remove "${productName}" from the product operations index?`);
    }
</script>
@endsection