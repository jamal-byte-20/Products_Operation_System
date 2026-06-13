@extends('layouts.app')

@section('title', 'Edit Product | StockOps')

@section('content')
<div class="mx-auto max-w-2xl">
    <!-- Breadcrumb & Header -->
    <div class="mb-6">
        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wider text-slate-500 hover:text-indigo-650 transition">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="h-3.5 w-3.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
            Back to Products
        </a>
        <h1 class="mt-2 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Edit Product</h1>
        <p class="mt-1 text-sm text-slate-500 font-medium">Update the product specifications, stock levels, and pricing.</p>
    </div>

    <!-- Form Card -->
    <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm sm:p-8">
        <form action="{{ route('products.update', $product->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Name Field -->
            <div>
                <label for="name" class="block text-sm font-semibold text-slate-900">Product Name</label>
                <div class="mt-2">
                    <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                        class="block w-full rounded-xl border border-slate-200 px-4 py-2.5 text-slate-900 placeholder-slate-400 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm transition @error('name') border-rose-500 focus:border-rose-500 focus:ring-rose-500 @enderror"
                        placeholder="e.g. Wireless Ergonomic Mouse">
                </div>
                @error('name')
                    <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description Field -->
            <div>
                <label for="description" class="block text-sm font-semibold text-slate-900">Description</label>
                <div class="mt-2">
                    <textarea name="description" id="description" rows="4"
                        class="block w-full rounded-xl border border-slate-200 px-4 py-2.5 text-slate-900 placeholder-slate-400 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm transition @error('description') border-rose-500 focus:border-rose-500 focus:ring-rose-500 @enderror"
                        placeholder="Provide a detailed description of the product...">{{ old('description', $product->description) }}</textarea>
                </div>
                @error('description')
                    <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price & Stock Grid -->
            <div class="grid gap-6 sm:grid-cols-2">
                <!-- Price -->
                <div>
                    <label for="price" class="block text-sm font-semibold text-slate-900">Price ($)</label>
                    <div class="mt-2 relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                            <span class="text-slate-400 sm:text-sm font-medium">$</span>
                        </div>
                        <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" required
                            class="block w-full rounded-xl border border-slate-200 pl-8 pr-4 py-2.5 text-slate-900 placeholder-slate-400 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm transition @error('price') border-rose-500 focus:border-rose-500 focus:ring-rose-500 @enderror"
                            placeholder="0.00">
                    </div>
                    @error('price')
                        <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stock -->
                <div>
                    <label for="stock" class="block text-sm font-semibold text-slate-900">Current Stock</label>
                    <div class="mt-2">
                        <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" min="0" required
                            class="block w-full rounded-xl border border-slate-200 px-4 py-2.5 text-slate-900 placeholder-slate-400 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm transition @error('stock') border-rose-500 focus:border-rose-500 focus:ring-rose-500 @enderror"
                            placeholder="e.g. 50">
                    </div>
                    @error('stock')
                        <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-6">
                <a href="{{ route('products.index') }}" class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-655 hover:bg-slate-50 transition">
                    Cancel
                </a>
                <button type="submit" class="rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md shadow-indigo-100 hover:bg-indigo-500 hover:shadow-lg transition">
                    Update Product
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
