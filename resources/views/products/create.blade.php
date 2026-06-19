{{-- resources/views/products/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Create New Product | StockOps')

@section('content')
<div class="create-product-page">
    <div class="page-container">
        
        {{-- Header Section --}}
        <div class="page-header">
            <div class="header-left">
                <div class="breadcrumb">
                    <a href="{{ route('products.index') }}">Products</a>
                    <span class="separator">/</span>
                    <span class="current">Create Product</span>
                </div>
                <h1 class="page-title">Add New Product</h1>
                <p class="page-subtitle">Fill in the details to append a new entry to the active inventory registry.</p>
            </div>
            <div class="header-right">
                <a href="{{ route('products.index') }}" class="btn-secondary">
                    ← Back to Products
                </a>
            </div>
        </div>

        {{-- Form Configuration Layout --}}
        <div class="form-container">
            <form action="{{ route('products.store') }}" method="POST" class="product-form">
                @csrf

                <div class="form-split-grid">
                    
                    {{-- Left Column: Primary Data Inputs --}}
                    <div class="form-column-main">
                        
                        {{-- Section: Basic Specs --}}
                        <div class="form-section">
                            <h3 class="section-title">Basic Information</h3>
                            
                            <div class="form-group">
                                <label for="name" class="form-label required">Product Name</label>
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name') }}"
                                       placeholder="e.g. Mechanical Keyboard"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" 
                                          id="description" 
                                          class="form-control @error('description') is-invalid @enderror" 
                                          rows="6"
                                          placeholder="Describe internal specifications, build properties, or characteristics..."></textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Section: Financial & Inventory Logistics --}}
                        <div class="form-section pt-edge">
                            <h3 class="section-title">Pricing & Stock</h3>
                            
                            <div class="form-row-split">
                                <div class="form-group">
                                    <label for="price" class="form-label required">Price ($)</label>
                                    <div class="input-currency-wrapper">
                                        <span class="currency-prefix">$</span>
                                        <input type="number" 
                                               name="price" 
                                               id="price" 
                                               class="form-control padded-left @error('price') is-invalid @enderror" 
                                               value="{{ old('price') }}"
                                               step="0.01"
                                               min="0"
                                               placeholder="0.00"
                                               required>
                                    </div>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="stock" class="form-label required">Stock Quantity</label>
                                    <input type="number" 
                                           name="stock" 
                                           id="stock" 
                                           class="form-control @error('stock') is-invalid @enderror" 
                                           value="{{ old('stock', 0) }}"
                                           min="0"
                                           required>
                                    @error('stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Right Column: Categorization & Visual Meta --}}
                    <div class="form-column-sidebar">
                        
                        {{-- Section: Categories Taxonomy --}}
                        <div class="sidebar-section">
                            <h3 class="section-title">Categories</h3>
                            <p class="section-desc-meta">Map record to system parameters</p>
                            
                            <div class="categories-list-wrapper">
                                @if($categories->count() > 0)
                                    @foreach($categories as $category)
                                        <label class="custom-tag-checkbox">
                                            <input type="checkbox" 
                                                   name="categories[]" 
                                                   value="{{ $category->id }}"
                                                   {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                                            <span class="tag-label-text">{{ $category->name }}</span>
                                        </label>
                                    @endforeach
                                @else
                                    <p class="empty-fallback-text">No active categories found in system layout views.</p>
                                @endif
                            </div>
                            @error('categories')
                                <div class="invalid-feedback block-display">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Section: Image Storage Allocation --}}
                        <div class="sidebar-section pt-edge">
                            <h3 class="section-title">Product Image</h3>
                            
                            <div class="form-group">
                                <label for="image_path" class="form-label">Asset Image URL</label>
                                <input type="url" 
                                       name="image" 
                                       id="image" 
                                       class="form-control @error('image') is-invalid @enderror" 
                                       value="{{ old('image') }}"
                                       placeholder="https://images.unsplash.com/photo-example">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="image-preview-viewport" id="imagePreviewContainer" style="display: none;">
                                <div class="preview-frame">
                                    <img id="imagePreview" src="" alt="Dynamic Asset Vector Preview">
                                    <button type="button" class="btn-clear-preview" onclick="clearImagePreview()">Remove</button>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                {{-- Lower Operational Actions Row Panel --}}
                <div class="form-action-footer">
                    <a href="{{ route('products.index') }}" class="btn-cancel">Cancel</a>
                    <button type="submit" class="btn-submit">Save Product</button>
                </div>
            </form>
        </div>

    </div>
</div>

<style>
    /* ========== CLEAN STANDARD OPERATION PALETTE ========== */
    .create-product-page {
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

    /* ========== BREADCRUMB & HEADERS ========== */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 2.5rem;
        padding-bottom: 1.5rem;
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

    .page-subtitle {
        font-size: 0.9rem;
        color: #6c757d;
        margin: 0.25rem 0 0 0;
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

    /* ========== STRUCTURAL LAYOUT BASE ========== */
    .form-container {
        background: white;
    }

    .form-split-grid {
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        gap: 3.5rem;
        align-items: start;
    }

    .form-section, .sidebar-section {
        display: flex;
        flex-direction: column;
    }

    .pt-edge {
        margin-top: 2.5rem;
        padding-top: 2rem;
        border-top: 1px solid #e9ecef;
    }

    .section-title {
        font-size: 1.1rem;
        color: #222;
        margin: 0 0 1.25rem 0;
        font-weight: 600;
    }

    .section-desc-meta {
        font-size: 0.8rem;
        color: #868e96;
        margin: -1rem 0 1rem 0;
    }

    /* ========== ELEMENTAL INPUT FIELD SHELLS ========== */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-size: 0.85rem;
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
    }

    .form-label.required::after {
        content: " *";
        color: #dc3545;
    }

    .form-control {
        width: 100%;
        padding: 0.6rem 0.75rem;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 0.9rem;
        color: #333;
        background-color: #fff;
        transition: border-color 0.15s ease;
        box-sizing: border-box;
    }

    .form-control:focus {
        outline: none;
        border-color: #333;
    }

    .form-control.is-invalid {
        border-color: #dc3545;
    }

    .invalid-feedback {
        color: #dc3545;
        font-size: 0.8rem;
        margin-top: 0.35rem;
    }

    .block-display {
        display: block;
    }

    .form-row-split {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    /* Input Currency Wrappers styling */
    .input-currency-wrapper {
        position: relative;
        display: flex;
        width: 100%;
    }

    .currency-prefix {
        position: absolute;
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: 0.9rem;
        color: #6c757d;
        pointer-events: none;
    }

    .form-control.padded-left {
        padding-left: 1.75rem;
    }

    /* ========== MINIMALIST CATEGORY CHECKBOX TAGS ========== */
    .categories-list-wrapper {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        max-height: 220px;
        overflow-y: auto;
        padding-right: 0.25rem;
    }

    .custom-tag-checkbox {
        cursor: pointer;
    }

    .custom-tag-checkbox input {
        display: none;
    }

    .tag-label-text {
        display: inline-block;
        background-color: #f1f3f5;
        color: #495057;
        padding: 0.4rem 0.8rem;
        border-radius: 4px;
        font-size: 0.85rem;
        border: 1px solid transparent;
        transition: all 0.15s ease;
    }

    .custom-tag-checkbox input:checked + .tag-label-text {
        background-color: #333;
        color: #fff;
        border-color: #333;
    }

    .empty-fallback-text {
        font-size: 0.85rem;
        color: #868e96;
        font-style: italic;
    }

    /* ========== ASSET FRAME IMAGE VIEWPORT ========== */
    .image-preview-viewport {
        margin-top: 1.25rem;
        border-top: 1px dashed #e9ecef;
        padding-top: 1.25rem;
    }

    .preview-frame {
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 4px;
        padding: 0.5rem;
        text-align: center;
        position: relative;
    }

    .preview-frame img {
        max-width: 100%;
        height: auto;
        max-height: 180px;
        display: block;
        margin: 0 auto 0.5rem auto;
        object-fit: contain;
    }

    .btn-clear-preview {
        background: #dc3545;
        color: white;
        border: none;
        padding: 0.25rem 0.6rem;
        font-size: 0.75rem;
        border-radius: 3px;
        cursor: pointer;
    }

    /* ========== BUTTON CONTROLS FOOTER ROW ========== */
    .form-action-footer {
        margin-top: 4rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e9ecef;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 1rem;
    }

    .btn-submit {
        background-color: #333;
        color: white;
        border: none;
        padding: 0.7rem 2rem;
        border-radius: 4px;
        font-size: 0.9rem;
        font-weight: 500;
        cursor: pointer;
        transition: opacity 0.2s;
    }

    .btn-cancel {
        text-decoration: none;
        color: #6c757d;
        font-size: 0.9rem;
        font-weight: 500;
        padding: 0.7rem 1rem;
    }

    .btn-submit:hover {
        opacity: 0.9;
    }

    .btn-cancel:hover {
        color: #333;
    }

    /* ========== RESPONSIVE SYSTEM MEDIA BREAKPOINTS ========== */
    @media (max-width: 900px) {
        .form-split-grid {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        .pt-edge {
            margin-top: 1.5rem;
            padding-top: 1.5rem;
        }
    }

    @media (max-width: 568px) {
        .form-row-split {
            grid-template-columns: 1fr;
            gap: 0;
        }
        .form-action-footer {
            flex-direction: column-reverse;
            gap: 0.5rem;
        }
        .btn-submit, .btn-cancel {
            width: 100%;
            text-align: center;
        }
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
    }
</style>

<script>
    // Asset view dynamic image mapping engine updates
    const imageInput = document.getElementById('image');
    const previewContainer = document.getElementById('imagePreviewContainer');
    const previewImage = document.getElementById('imagePreview');

    if (imageInput) {
        imageInput.addEventListener('input', function() {
            const url = this.value.trim();
            if (url && (url.startsWith('http://') || url.startsWith('https://'))) {
                previewImage.src = url;
                previewContainer.style.display = 'block';
                
                previewImage.onerror = function() {
                    previewImage.src = 'https://via.placeholder.com/400x300?text=Invalid+Asset+Image+URL';
                };
            } else {
                previewContainer.style.display = 'none';
            }
        });
    }

    function clearImagePreview() {
        imageInput.value = '';
        previewContainer.style.display = 'none';
        previewImage.src = '';
    }
</script>
@endsection