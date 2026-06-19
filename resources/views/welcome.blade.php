<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Operation System</title>
    <style>
        /* ========== INDUSTRIAL LAYOUT FRAMEWORK ========== */
        .home-layout-wrapper {
            max-width: 1300px;
            margin: 0 auto;
            padding: 2.5rem 1rem;
            display: grid;
            grid-template-columns: 280px 1fr; /* Fixed sidebar layout width */
            gap: 2.5rem;
            align-items: start;
        }

        /* Responsive Grid Style using standard CSS */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 2rem;
            padding: 1rem 0;
        }

        /* ========== SIDEBAR CATEGORY FILTER COMPONENT ========== */
        .sidebar-filter-column {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
            width: 100%;
        }

        .filter-section-card {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 4px;
        }

        .filter-card-header {
            background-color: #f8f9fa;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .filter-card-header h3 {
            margin: 0;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #495057;
        }

        .clear-filters-trigger {
            font-size: 0.72rem;
            color: #dc3545;
            text-decoration: none;
            font-weight: 600;
            text-transform: uppercase;
        }

        .clear-filters-trigger:hover {
            text-decoration: underline;
        }

        .filter-card-body {
            padding: 1rem;
        }

        .filter-meta-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            color: #868e96;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin-bottom: 0.65rem;
        }

        /* ========== SCROLLABLE CHECKBOX VIEWPORT ========== */
        .sidebar-checkbox-viewport {
            display: flex;
            flex-direction: column;
            gap: 0.15rem;
            max-height: 320px;
            overflow-y: auto;
            padding-right: 0.25rem;
        }

        .matrix-filter-item {
            display: flex;
            align-items: center;
            position: relative;
            padding: 0.45rem 0.5rem;
            cursor: pointer;
            font-size: 0.85rem;
            user-select: none;
            border-radius: 3px;
            transition: background-color 0.1s;
        }

        .matrix-filter-item:hover {
            background-color: #f8f9fa;
        }

        .matrix-filter-item input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        /* Custom Flat Checkbox Box Indicator */
        .custom-indicator-box {
            height: 14px;
            width: 14px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 2px;
            margin-right: 0.65rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .matrix-filter-item input:checked + .custom-indicator-box {
            background-color: #333;
            border-color: #333;
        }

        .matrix-filter-item input:checked + .custom-indicator-box::after {
            content: "";
            width: 4px;
            height: 7px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
            margin-bottom: 1.5px;
        }

        .indicator-label-text {
            color: #333;
            font-weight: 500;
            flex-grow: 1;
        }

        .node-count-flag {
            font-size: 0.75rem;
            color: #868e96;
            font-family: monospace;
            margin-left: 0.5rem;
        }

        /* ========== SIDEBAR META REGISTRY CARD ========== */
        .sidebar-meta-card {
            background-color: #f8f9fa;
            border: 1px dashed #dee2e6;
            border-radius: 4px;
            padding: 0.75rem 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .meta-data-label {
            font-size: 0.75rem;
            color: #6c757d;
            font-weight: 500;
        }

        .meta-data-value {
            font-size: 0.78rem;
            color: #222;
            font-weight: 700;
        }

        /* Sidebar Custom Scrollbars */
        .sidebar-checkbox-viewport::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-checkbox-viewport::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar-checkbox-viewport::-webkit-scrollbar-thumb {
            background: #dee2e6;
            border-radius: 2px;
        }

        /* ========== RESPONSIVE COLLAPSE MEDIA STEP ========== */
        @media (max-width: 850px) {
            .home-layout-wrapper {
                grid-template-columns: 1fr; /* Stack filter on top for mobile screens */
                gap: 1.5rem;
                padding: 1.5rem 1rem;
            }
        }
    </style>
</head>
<body style="margin: 0; font-family: system-ui, sans-serif; background-color: #fdfdfd;">

    <x-navbar />

    {{-- Layout Frame Split Wrapper --}}
    <div class="home-layout-wrapper">
        
        {{-- Left Side Column Filter --}}
        <aside>
            <div class="sidebar-filter-column">
                
                {{-- Filter Module Block --}}
                <div class="filter-section-card">
                    <div class="filter-card-header">
                        <h3>Filter Inventory</h3>
                        @if(request('categories') || request('search'))
                            <a href="{{ route('products.index') }}" class="clear-filters-trigger">Reset Filter [X]</a>
                        @endif
                    </div>
                    
                    <div class="filter-card-body">
                        <form action="{{ route('products.index') }}" method="GET" id="filterStructureForm">
                            
                            {{-- Preserve Existing Active Search Queries --}}
                            @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif

                            <div class="filter-group">
                                <label class="filter-meta-label">System Taxonomies</label>
                                
                                <div class="sidebar-checkbox-viewport">
                                    @foreach($categories as $category)
                                        @php
                                            $activeCategories = request('categories', []);
                                            $isChecked = in_array($category->id, $activeCategories);
                                        @endphp
                                        <label class="matrix-filter-item">
                                            <input type="checkbox" 
                                                   name="categories[]" 
                                                   value="{{ $category->id }}"
                                                   {{ $isChecked ? 'checked' : '' }}
                                                   onchange="document.getElementById('filterStructureForm').submit();">
                                            <span class="custom-indicator-box"></span>
                                            <span class="indicator-label-text">{{ $category->name }}</span>
                                            <span class="node-count-flag">({{ $category->products_count ?? $category->products->count() }})</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <noscript>
                                <button type="submit" style="width:100%; margin-top:0.5rem; padding:0.4rem; background:#333; color:#fff; border:none; border-radius:3px;">Apply Filters</button>
                            </noscript>
                        </form>
                    </div>
                </div>

                {{-- System Node Count Summary Box --}}
                <div class="sidebar-meta-card">
                    <span class="meta-data-label">Active Registry Base:</span>
                    <span class="meta-data-value">{{ $products->total() }} Records Loaded</span>
                </div>
            </div>
        </aside>

        {{-- Right Side Main Feed --}}
        <main style="padding: 0;">
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h2 style="font-size: 1.75rem; color: #222; margin: 0;">Our Products</h2>
                <span style="color: #6c757d; font-size: 0.9rem;">Showing {{ $products->count() }} items</span>
            </div>

            @if($products->isEmpty())
                <div style="text-align: center; padding: 3rem; background: #f8f9fa; border-radius: 8px; border: 1px dashed #ccc;">
                    <p style="color: #6c757d; margin: 0;">No products found in the system.</p>
                </div>
            @else
                <div class="products-grid">
                    @foreach($products as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>
                
                <div style="margin-top: 2rem;">
                    {{ $products->links() }}
                </div>
            @endif

        </main>
    </div>

</body>
</html>