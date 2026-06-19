{{-- resources/views/products/show.blade.php --}}
@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="product-details-page">
    <div class="page-container">
        
        {{-- Header Section / Breadcrumb --}}
        <div class="page-header">
            <div class="header-left">
                <div class="breadcrumb">
                    <a href="{{ route('products.index') }}">Products</a>
                    <span class="separator">/</span>
                    <span class="current">{{ $product->name }}</span>
                </div>
                <h1 class="page-title">{{ $product->name }}</h1>
            </div>
            <div class="header-right">
                <a href="{{ route('products.index') }}" class="btn-secondary">
                    ← Back to Products
                </a>
            </div>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Main Layout Split --}}
        <div class="details-container">
            
            {{-- Left Side: Product Image Layout --}}
            <div class="details-left">
                <div class="image-wrapper">
                    @if($product->image)
                        <img src="{{ $product->image}}" alt="{{ $product->name }}">
                    @else
                        <div class="no-image-placeholder">No Image Available</div>
                    @endif
                </div>
            </div>

            {{-- Right Side: Clean Structured Product Info --}}
            <div class="details-right">
                
                {{-- Status & Meta --}}
                <div class="status-meta-row">
                    <span class="status-badge {{ $product->stock > 0 ? 'in-stock' : 'out-of-stock' }}">
                        {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                    </span>
                    <span class="product-sku">SKU: PROD-{{ str_pad($product->id, 6, '0', STR_PAD_LEFT) }}</span>
                </div>

                {{-- Price Callout --}}
                <div class="price-box">
                    <span class="price-value">${{ number_format($product->price, 2) }}</span>
                    <span class="stock-count">({{ $product->stock }} units available)</span>
                </div>

                {{-- Categories Section --}}
                @if($product->categories && $product->categories->count() > 0)
                    <div class="info-section">
                        <h4 class="section-title">Categories</h4>
                        <div class="categories-list">
                            @foreach($product->categories as $category)
                                <span class="category-tag">{{ $category->name }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Description Section --}}
                <div class="info-section">
                    <h4 class="section-title">Description</h4>
                    <p class="description-text">
                        {{ $product->description ?? 'No description provided for this product.' }}
                    </p>
                </div>

                {{-- Technical System Data --}}
                <div class="info-section metadata-grid">
                    <div class="meta-cell">
                        <span class="cell-label">Created Date</span>
                        <span class="cell-value">{{ $product->created_at->format('F d, Y') }}</span>
                    </div>
                    <div class="meta-cell">
                        <span class="cell-label">Last Updated</span>
                        <span class="cell-value">{{ $product->updated_at->diffForHumans() }}</span>
                    </div>
                </div>

                {{-- Action Panel matching your management layout --}}
                <div class="action-buttons-group">
                    <a href="{{ route('products.edit', $product->id) }}" class="btn-edit">
                        Edit Product
                    </a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="delete-form" 
                          onsubmit="return confirm('Are you sure you want to delete this product?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">
                            Delete Product
                        </button>
                    </form>
                </div>

            </div>
        </div>

        {{-- Related Products Component Section --}}
        @if($product->categories && $product->categories->count() > 0)
            @php
                $relatedProducts = \App\Models\Product::whereHas('categories', function($q) use ($product) {
                    $q->whereIn('categories.id', $product->categories->pluck('id'));
                })
                ->where('id', '!=', $product->id)
                ->limit(4)
                ->get();
            @endphp

            @if($relatedProducts->count() > 0)
                <div class="related-section">
                    <h3 class="related-main-title">Related Products</h3>
                    <div class="products-grid">
                        @foreach($relatedProducts as $related)
                            <div class="related-card">
                                <div class="related-img-box">
                                    @if($related->image)
                                        <img src="{{ $related->image }}" alt="{{ $related->name }}">
                                    @else
                                        <span>No Image</span>
                                    @endif
                                </div>
                                <div class="related-body">
                                    <h4>{{ Str::limit($related->name, 40) }}</h4>
                                    <div class="related-meta">
                                        <span class="related-price">${{ number_format($related->price, 2) }}</span>
                                        <a href="{{ route('products.show', $related->id) }}" class="related-btn">View</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif

    </div>
</div>

<style>
    /* ========== CLEAN MINIMALIST THEME STRUCTURE ========== */
    .product-details-page {
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

    /* ========== BREADCRUMB & HEADER ========== */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e9ecef;
    }

    .breadcrumb {
        font-size: 0.85rem;
        color: #6c757d;
        margin-bottom: 0.5rem;
    }

    .breadcrumb a {
        color: #007bff;
        text-decoration: none;
    }

    .breadcrumb a:hover {
        text-decoration: underline;
    }

    .breadcrumb .separator {
        margin: 0 0.4rem;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        color: #222;
        margin: 0;
    }

    .btn-secondary {
        text-decoration: none;
        color: #333;
        border: 1px solid #ccc;
        padding: 0.5rem 1rem;
        border-radius: 4px;
        font-size: 0.85rem;
        font-weight: 500;
        transition: background 0.2s;
    }

    .btn-secondary:hover {
        background-color: #f8f9fa;
    }

    /* ========== ALERTS ========== */
    .alert-success {
        padding: 1rem;
        background-color: #e6fffa;
        border: 1px solid #b2f5ea;
        color: #234e52;
        border-radius: 6px;
        margin-bottom: 1.5rem;
        font-size: 0.95rem;
    }

    /* ========== MAIN VIEW GRID SPLIT ========== */
    .details-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        margin-bottom: 4rem;
        align-items: start;
    }

    /* Left Side: Clean Frame Image Layout */
    .image-wrapper {
        background-color: #f1f3f5;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        height: 450px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .no-image-placeholder {
        color: #adb5bd;
        font-size: 1rem;
    }

    /* Right Side: Visual Hierarchy Information */
    .status-meta-row {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .status-badge {
        font-size: 0.75rem;
        font-weight: bold;
        text-transform: uppercase;
        padding: 0.25rem 0.6rem;
        border-radius: 4px;
    }

    .in-stock {
        background-color: #d4edda;
        color: #155724;
    }

    .out-of-stock {
        background-color: #f8d7da;
        color: #721c24;
    }

    .product-sku {
        font-size: 0.85rem;
        color: #6c757d;
        font-family: monospace;
    }

    .price-box {
        margin-bottom: 2rem;
    }

    .price-value {
        font-size: 2.25rem;
        font-weight: bold;
        color: #28a745;
        display: block;
    }

    .stock-count {
        font-size: 0.9rem;
        color: #6c757d;
    }

    .info-section {
        margin-bottom: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e9ecef;
    }

    .section-title {
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6c757d;
        margin: 0 0 0.75rem 0;
    }

    .description-text {
        font-size: 1rem;
        line-height: 1.6;
        color: #495057;
        margin: 0;
    }

    .categories-list {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .category-tag {
        background-color: #f1f3f5;
        color: #495057;
        padding: 0.35rem 0.75rem;
        border-radius: 4px;
        font-size: 0.85rem;
    }

    /* Metadata Block */
    .metadata-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .meta-cell {
        display: flex;
        flex-direction: column;
    }

    .cell-label {
        font-size: 0.75rem;
        color: #868e96;
        text-transform: uppercase;
    }

    .cell-value {
        font-size: 0.9rem;
        color: #333;
        font-weight: 500;
    }

    /* Management Action Row Buttons */
    .action-buttons-group {
        display: flex;
        gap: 1rem;
        margin-top: 2.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e9ecef;
    }

    .btn-edit, .btn-delete {
        flex: 1;
        text-align: center;
        padding: 0.75rem;
        border-radius: 4px;
        font-size: 0.9rem;
        font-weight: 500;
        text-decoration: none;
        cursor: pointer;
        border: none;
        transition: opacity 0.2s;
    }

    .btn-edit {
        background-color: #333;
        color: white;
    }

    .btn-delete {
        background-color: #dc3545;
        color: white;
    }

    .btn-edit:hover, .btn-delete:hover {
        opacity: 0.9;
    }

    .delete-form {
        flex: 1;
    }

    /* ========== RELATED PRODUCTS HOME-GRID THEME ========== */
    .related-section {
        margin-top: 4rem;
        border-top: 1px solid #e9ecef;
        padding-top: 2rem;
    }

    .related-main-title {
        font-size: 1.5rem;
        color: #222;
        margin-bottom: 1.5rem;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 2rem;
    }

    .related-card {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
    }

    .related-img-box {
        background-color: #f1f3f5;
        height: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #adb5bd;
        font-size: 0.8rem;
    }

    .related-img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .related-body {
        padding: 1rem;
    }

    .related-body h4 {
        margin: 0 0 0.75rem 0;
        font-size: 1rem;
        color: #333;
    }

    .related-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .related-price {
        font-weight: bold;
        color: #28a745;
    }

    .related-btn {
        text-decoration: none;
        background-color: #333;
        color: white;
        padding: 0.35rem 0.75rem;
        border-radius: 4px;
        font-size: 0.8rem;
    }

    /* ========== RESPONSIVE DESIGN ADJUSTMENTS ========== */
    @media (max-width: 768px) {
        .details-container {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        .image-wrapper {
            height: 300px;
        }
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
    }
</style>
@endsection