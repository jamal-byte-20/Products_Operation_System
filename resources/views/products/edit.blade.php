{{-- resources/views/products/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Modify Product | StockOps')

@section('content')
<div class="edit-product-page">
    <div class="page-container">
        
        {{-- Header Section --}}
        <div class="page-header">
            <div class="header-left">
                <div class="system-breadcrumb">
                    <a href="{{ route('products.index') }}">Products Index</a>
                    <span class="delimiter">/</span>
                    <a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a>
                    <span class="delimiter">/</span>
                    <span class="active-node">Modify Node</span>
                </div>
                <h1 class="page-title">Edit Product Record</h1>
                <p class="page-subtitle">Amend the attributes, valuation, allocation, and media metadata within database storage.</p>
            </div>
            <div class="header-right">
                <a href="{{ route('products.show', $product->id) }}" class="btn-secondary">
                    ← Back to Layout
                </a>
            </div>
        </div>

        {{-- Configuration Update Form Layout --}}
        <div class="form-viewport-card">
            <form action="{{ route('products.update', $product->id) }}" method="POST" class="structured-form" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-asymmetric-grid">
                    
                    {{-- Primary Content Parameters (Left Column) --}}
                    <div class="form-primary-column">
                        
                        {{-- Core Identity Definition Block --}}
                        <div class="form-section-card">
                            <div class="section-card-header">
                                <h3>Core Properties</h3>
                            </div>
                            
                            <div class="section-card-body">
                                {{-- Product Name --}}
                                <div class="input-form-group">
                                    <label for="name" class="control-label label-required">
                                        Product Title
                                    </label>
                                    <input type="text" 
                                           name="name" 
                                           id="name" 
                                           class="control-field @error('name') validation-error @enderror" 
                                           value="{{ old('name', $product->name) }}"
                                           placeholder="e.g. Enterprise Processor Core"
                                           required>
                                    @error('name')
                                        <div class="field-feedback-error">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Description --}}
                                <div class="input-form-group">
                                    <label for="description" class="control-label">
                                        Specifications & Description
                                    </label>
                                    <textarea name="description" 
                                              id="description" 
                                              class="control-field text-area-field @error('description') validation-error @enderror" 
                                              rows="6"
                                              placeholder="Provide explicit physical configuration specs...">{{ old('description', $product->description) }}</textarea>
                                    @error('description')
                                        <div class="field-feedback-error">{{ $message }}</div>
                                    @enderror
                                    <span class="field-context-note">Character limit constraint max: 500 characters. No HTML tags allowed.</span>
                                </div>
                            </div>
                        </div>

                        {{-- Financial & Asset Metrics Definition Block --}}
                        <div class="form-section-card">
                            <div class="section-card-header">
                                <h3>Financials & Metrics</h3>
                            </div>
                            
                            <div class="section-card-body">
                                <div class="form-bilateral-row">
                                    <div class="input-form-group">
                                        <label for="price" class="control-label label-required">
                                            Unit Evaluation Price ($)
                                        </label>
                                        <div class="appended-input-frame">
                                            <span class="input-add-on">$</span>
                                            <input type="number" 
                                                   name="price" 
                                                   id="price" 
                                                   class="control-field @error('price') validation-error @enderror" 
                                                   value="{{ old('price', $product->price) }}"
                                                   step="0.01"
                                                   min="0"
                                                   placeholder="0.00"
                                                   required>
                                        </div>
                                        @error('price')
                                            <div class="field-feedback-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="input-form-group">
                                        <label for="stock" class="control-label label-required">
                                            Physical System Stock
                                        </label>
                                        <input type="number" 
                                               name="stock" 
                                               id="stock" 
                                               class="control-field @error('stock') validation-error @enderror" 
                                               value="{{ old('stock', $product->stock) }}"
                                               min="0"
                                               placeholder="0"
                                               required>
                                        @error('stock')
                                            <div class="field-feedback-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="input-form-group">
                                    <label for="quantity" class="control-label">
                                        Allocation Allotment Override
                                    </label>
                                    <input type="number" 
                                           name="quantity" 
                                           id="quantity" 
                                           class="control-field @error('quantity') validation-error @enderror" 
                                           value="{{ old('quantity', $product->quantity ?? $product->stock) }}"
                                           min="0"
                                           placeholder="0">
                                    @error('quantity')
                                        <div class="field-feedback-error">{{ $message }}</div>
                                    @enderror
                                    <span class="field-context-note">Overriding parameters explicitly dedicated to sales allocation targets.</span>
                                </div>

                                {{-- Flat Context Stock Status Badge --}}
                                <div class="status-indicator-block">
                                    @if($product->stock > 0)
                                        <span class="status-text-flag flag-success">✓ Item inventory verified within baseline thresholds.</span>
                                    @else
                                        <span class="status-text-flag flag-danger">⚠️ Warning: Depleted status register actively assigned.</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Metadata & Taxonomy (Right Side Column) --}}
                    <div class="form-secondary-column">
                        
                        {{-- Taxonomy Segmentation Block --}}
                        <div class="form-section-card">
                            <div class="section-card-header">
                                <h3>Structural Groupings</h3>
                            </div>
                            
                            <div class="section-card-body">
                                <div class="input-form-group">
                                    <label class="control-label">Taxonomy Alignment</label>
                                    <div class="checkbox-scroll-viewport">
                                        @foreach($categories as $category)
                                            @php
                                                $isChecked = old('categories', $product->categories->pluck('id')->toArray());
                                                $checked = in_array($category->id, $isChecked);
                                            @endphp
                                            <label class="matrix-checkbox-item">
                                                <input type="checkbox" 
                                                       name="categories[]" 
                                                       value="{{ $category->id }}"
                                                       {{ $checked ? 'checked' : '' }}>
                                                <span class="custom-indicator-box"></span>
                                                <span class="indicator-label-text">{{ $category->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                    @error('categories')
                                        <div class="field-feedback-error" style="margin-top: 0.5rem;">{{ $message }}</div>
                                    @enderror
                                    @error('categories.*')
                                        <div class="field-feedback-error" style="margin-top: 0.5rem;">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Active Taxonomy Badges --}}
                                @if($product->categories->count() > 0)
                                    <div class="assigned-taxonomies-box">
                                        <span class="mini-meta-label">Active Deployments:</span>
                                        <div class="flat-badge-cluster">
                                            @foreach($product->categories as $category)
                                                <span class="flat-outline-badge">{{ $category->name }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Storage Media Target Asset Block --}}
                        <div class="form-section-card">
                            <div class="section-card-header">
                                <h3>Product Media Asset</h3>
                            </div>
                            
                            <div class="section-card-body">
                                {{-- Active Data Target Image Preview --}}
                                @if($product->image)
                                    <div class="media-preview-context-box">
                                        <span class="mini-meta-label">Current Node Frame:</span>
                                        <div class="asset-preview-frame">
                                            <img src="{{ $product->image }}" alt="{{ $product->name }}">
                                            <button type="button" class="remove-asset-trigger" onclick="removeCurrentImage()" title="Purge Asset Link">✕</button>
                                        </div>
                                    </div>
                                @endif

                                {{-- Media Reference Routing URL --}}
                                <div class="input-form-group">
                                    <label for="image" class="control-label">
                                        Resource Object URL Reference
                                    </label>
                                    <input type="url" 
                                           name="image" 
                                           id="image" 
                                           class="control-field @error('image') validation-error @enderror" 
                                           value="{{ old('image', $product->image) }}"
                                           placeholder="https://assets.storage.net/item.jpg">
                                    @error('image')
                                        <div class="field-feedback-error">{{ $message }}</div>
                                    @enderror
                                    <span class="field-context-note">Requires absolute HTTP/HTTPS destination target layout routing.</span>
                                </div>

                                {{-- Client-side Realtime Image Render Sandbox --}}
                                <div class="image-preview-container" id="imagePreviewContainer" style="display: none;">
                                    <span class="mini-meta-label">Staged Buffer Frame Preview:</span>
                                    <div class="asset-preview-frame staged-frame">
                                        <img id="imagePreview" src="" alt="Staged Input Pipeline">
                                        <button type="button" class="remove-asset-trigger" onclick="clearImagePreview()">✕</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Timestamps Registry Information Block --}}
                        <div class="form-section-card">
                            <div class="section-card-header">
                                <h3>Node Registry Properties</h3>
                            </div>
                            
                            <div class="section-card-body">
                                <div class="registry-data-list">
                                    <div class="registry-row-item">
                                        <span class="reg-label">Unique Identity Hash:</span>
                                        <span class="reg-value">#{{ $product->id }}</span>
                                    </div>
                                    <div class="registry-row-item">
                                        <span class="reg-label">System Insertion Timestamp:</span>
                                        <span class="reg-value">{{ $product->created_at->format('Y-m-d H:i') }}</span>
                                    </div>
                                    <div class="registry-row-item">
                                        <span class="reg-label">State Log Transmutation:</span>
                                        <span class="reg-value">{{ $product->updated_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Action Pipeline Footer --}}
                <div class="form-action-pipeline-row">
                    <a href="{{ route('products.show', $product->id) }}" class="btn-cancel">
                        Cancel Transmutation
                    </a>
                    <button type="submit" class="btn-submit">
                        Commit Variations
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* ========== CLEAN INDUSTRIAL HIGH-CONTRAST DESIGN CORE SYSTEM ========== */
    .edit-product-page {
        background-color: #fdfdfd;
        min-height: 100vh;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
        color: #333;
        padding: 2.5rem 0;
    }

    .page-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    /* ========== NEUTRAL SYSTEMS BREADCRUMB ========== */
    .system-breadcrumb {
        margin-bottom: 0.65rem;
        font-size: 0.78rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .system-breadcrumb a {
        color: #868e96;
        text-decoration: none;
    }

    .system-breadcrumb a:hover {
        color: #222;
        text-decoration: underline;
    }

    .system-breadcrumb .delimiter {
        margin: 0 0.4rem;
        color: #dee2e6;
    }

    .system-breadcrumb .active-node {
        color: #222;
        font-weight: 600;
    }

    /* ========== TYPOGRAPHY HEADERS LAYOUT ========== */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 2.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #e9ecef;
    }

    .header-left {
        flex: 1;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        color: #222;
        margin: 0;
        letter-spacing: -0.5px;
    }

    .page-subtitle {
        color: #6c757d;
        font-size: 0.95rem;
        margin: 0.35rem 0 0 0;
    }

    .btn-secondary {
        background-color: white;
        border: 1px solid #ccc;
        color: #333;
        padding: 0.55rem 1.1rem;
        border-radius: 4px;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 500;
        transition: background-color 0.15s;
    }

    .btn-secondary:hover {
        background-color: #f8f9fa;
        color: #222;
    }

    /* ========== COMPACT UNIFORM VIEWPORT CARD ========== */
    .form-viewport-card {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 6px;
        overflow: hidden;
    }

    .structured-form {
        padding: 2rem;
    }

    .form-asymmetric-grid {
        display: grid;
        grid-template-columns: 1fr 360px;
        gap: 2rem;
    }

    /* ========== CONTENT MODULE CARDS ========== */
    .form-section-card {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 4px;
        margin-bottom: 1.5rem;
    }

    .section-card-header {
        background-color: #f8f9fa;
        padding: 0.75rem 1.25rem;
        border-bottom: 1px solid #e9ecef;
    }

    .section-card-header h3 {
        margin: 0;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #495057;
    }

    .section-card-body {
        padding: 1.25rem;
    }

    /* ========== ASSET & STRUCTURAL FIELDS ========== */
    .input-form-group {
        margin-bottom: 1.25rem;
    }

    .input-form-group:last-child {
        margin-bottom: 0;
    }

    .control-label {
        display: block;
        margin-bottom: 0.4rem;
        font-weight: 600;
        color: #333;
        font-size: 0.82rem;
    }

    .control-label.label-required::after {
        content: ' *';
        color: #dc3545;
    }

    .control-field {
        width: 100%;
        padding: 0.55rem 0.65rem;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 0.88rem;
        color: #222;
        background-color: white;
        box-sizing: border-box;
    }

    .control-field:focus {
        outline: none;
        border-color: #333;
    }

    .control-field.validation-error {
        border-color: #dc3545;
        background-color: #fffafa;
    }

    .text-area-field {
        resize: vertical;
        font-family: inherit;
    }

    .field-feedback-error {
        color: #dc3545;
        font-size: 0.78rem;
        margin-top: 0.3rem;
        font-weight: 500;
    }

    .field-context-note {
        font-size: 0.75rem;
        color: #868e96;
        margin-top: 0.35rem;
        display: block;
    }

    .appended-input-frame {
        display: flex;
        align-items: center;
        width: 100%;
    }

    .input-add-on {
        background: #f1f3f5;
        border: 1px solid #ccc;
        border-right: none;
        padding: 0.55rem 0.85rem;
        border-radius: 4px 0 0 4px;
        font-size: 0.88rem;
        font-weight: 600;
        color: #495057;
    }

    .appended-input-frame .control-field {
        border-radius: 0 4px 4px 0;
    }

    .form-bilateral-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    /* ========== STOCK STATE INDICATOR LABELS ========== */
    .status-indicator-block {
        margin-top: 1rem;
    }

    .status-text-flag {
        display: block;
        font-size: 0.8rem;
        font-weight: 600;
        padding: 0.5rem 0.75rem;
        border-radius: 4px;
        border: 1px solid transparent;
    }

    .status-text-flag.flag-success {
        background-color: #f4fbf7;
        color: #28a745;
        border-color: rgba(40,167,69,0.15);
    }

    .status-text-flag.flag-danger {
        background-color: #fff5f5;
        color: #dc3545;
        border-color: rgba(220,53,69,0.15);
    }

    /* ========== MATRIX REGULAR CHECKBOX VIEWPORT ========== */
    .checkbox-scroll-viewport {
        border: 1px solid #ccc;
        border-radius: 4px;
        background: #fff;
        max-height: 200px;
        overflow-y: auto;
        padding: 0.5rem;
    }

    .matrix-checkbox-item {
        display: flex;
        align-items: center;
        position: relative;
        padding: 0.4rem 0.5rem;
        cursor: pointer;
        font-size: 0.85rem;
        user-select: none;
        border-radius: 3px;
    }

    .matrix-checkbox-item:hover {
        background-color: #f8f9fa;
    }

    .matrix-checkbox-item input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    .custom-indicator-box {
        height: 14px;
        width: 14px;
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 2px;
        margin-right: 0.5rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .matrix-checkbox-item input:checked + .custom-indicator-box {
        background-color: #333;
        border-color: #333;
    }

    .matrix-checkbox-item input:checked + .custom-indicator-box::after {
        content: "";
        width: 4px;
        height: 8px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
        margin-bottom: 2px;
    }

    .indicator-label-text {
        color: #333;
        font-weight: 500;
    }

    .assigned-taxonomies-box {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #edf2f7;
    }

    .mini-meta-label {
        display: block;
        font-size: 0.75rem;
        font-weight: 600;
        color: #868e96;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        margin-bottom: 0.4rem;
    }

    .flat-badge-cluster {
        display: flex;
        flex-wrap: wrap;
        gap: 0.35rem;
    }

    .flat-outline-badge {
        font-size: 0.78rem;
        background-color: #f1f3f5;
        color: #495057;
        padding: 0.15rem 0.45rem;
        border-radius: 3px;
        font-weight: 500;
        border: 1px solid #e9ecef;
    }

    /* ========== FLAT ASSET CROPPERS PREVIEWS ========== */
    .media-preview-context-box {
        margin-bottom: 1rem;
    }

    .asset-preview-frame {
        position: relative;
        display: inline-block;
        margin-top: 0.25rem;
        width: 120px;
        height: 120px;
        border: 1px solid #ccc;
        border-radius: 4px;
        overflow: hidden;
        background-color: #f8f9fa;
    }

    .asset-preview-frame img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .remove-asset-trigger {
        position: absolute;
        top: 4px;
        right: 4px;
        background: #333;
        color: white;
        border: none;
        border-radius: 2px;
        width: 20px;
        height: 20px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        opacity: 0.85;
    }

    .remove-asset-trigger:hover {
        opacity: 1;
        background-color: #dc3545;
    }

    .image-preview-container {
        margin-top: 1.25rem;
        padding-top: 1.25rem;
        border-top: 1px solid #edf2f7;
    }

    /* ========== REGISTRY STRUCTURE ========== */
    .registry-data-list {
        display: flex;
        flex-direction: column;
        gap: 0.6rem;
    }

    .registry-row-item {
        display: flex;
        justify-content: space-between;
        font-size: 0.85rem;
        border-bottom: 1px dashed #e9ecef;
        padding-bottom: 0.4rem;
    }

    .registry-row-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .reg-label {
        color: #6c757d;
    }

    .reg-value {
        color: #222;
        font-weight: 600;
    }

    /* ========== STRUCTURAL ACTION PIPELINE FOOTER ========== */
    .form-action-pipeline-row {
        margin-top: 2.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e9ecef;
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
    }

    .btn-submit {
        background-color: #333;
        color: white;
        padding: 0.6rem 1.4rem;
        border: 1px solid #333;
        border-radius: 4px;
        font-size: 0.88rem;
        font-weight: 600;
        cursor: pointer;
        transition: opacity 0.15s;
    }

    .btn-submit:hover {
        opacity: 0.9;
    }

    .btn-cancel {
        background-color: transparent;
        border: 1px solid #ccc;
        color: #555;
        padding: 0.6rem 1.4rem;
        border-radius: 4px;
        text-decoration: none;
        font-size: 0.88rem;
        font-weight: 500;
        transition: background-color 0.15s, color 0.15s;
    }

    .btn-cancel:hover {
        background-color: #f1f3f5;
        color: #222;
    }

    /* ========== CONFIGURATION MONITOR RESPONSIVENESS ========== */
    @media (max-width: 968px) {
        .form-asymmetric-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        .form-secondary-column {
            order: 2;
        }
        .form-primary-column {
            order: 1;
        }
        .form-bilateral-row {
            grid-template-columns: 1fr;
            gap: 0;
        }
    }

    @media (max-width: 768px) {
        .edit-product-page {
            padding: 1.5rem 0;
        }
        .page-container {
            padding: 0 0.75rem;
        }
        .structured-form {
            padding: 1.25rem;
        }
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        .btn-secondary {
            width: 100%;
            text-align: center;
            box-sizing: border-box;
        }
        .form-action-pipeline-row {
            flex-direction: column-reverse;
        }
        .btn-submit, .btn-cancel {
            width: 100%;
            text-align: center;
        }
    }

    /* Custom Webkit scrollbar fields */
    .checkbox-scroll-viewport::-webkit-scrollbar {
        width: 5px;
    }
    .checkbox-scroll-viewport::-webkit-scrollbar-track {
        background: #f8f9fa;
    }
    .checkbox-scroll-viewport::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 2px;
    }
</style>

<script>
    // Realtime URL data preview layout tracking logic
    const imageInput = document.getElementById('image');
    const previewContainer = document.getElementById('imagePreviewContainer');
    const previewImage = document.getElementById('imagePreview');

    if (imageInput) {
        imageInput.addEventListener('input', function() {
            const url = this.value.trim();
            if (url && url !== '{{ $product->image }}' && (url.startsWith('http://') || url.startsWith('https://'))) {
                previewImage.src = url;
                previewContainer.style.display = 'block';
                
                previewImage.onerror = function() {
                    previewImage.src = 'https://via.placeholder.com/120x120?text=Invalid+Object+Target';
                };
            } else if (!url || url === '{{ $product->image }}') {
                previewContainer.style.display = 'none';
            }
        });
    }

    function clearImagePreview() {
        if(imageInput) {
            imageInput.value = '';
            previewContainer.style.display = 'none';
            previewImage.src = '';
        }
    }

    function removeCurrentImage() {
        if (confirm('Purge active asset reference URL? Stored property changes will apply on commit.')) {
            if(imageInput) {
                imageInput.value = '';
                previewContainer.style.display = 'none';
                previewImage.src = '';
            }
            const currentImageDiv = document.querySelector('.media-preview-context-box');
            if (currentImageDiv) {
                currentImageDiv.style.display = 'none';
            }
        }
    }
</script>
@endsection