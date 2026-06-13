@extends('layouts.app')

@section('title', 'Products | StockOps')

@section('content')
<div class="space-y-8">
    <!-- Page header -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Products</h1>
            <p class="mt-1 text-sm text-slate-500 font-medium">Manage your inventory, prices, and stock levels.</p>
        </div>
        <div>
            <a href="{{ route('products.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md shadow-indigo-100 hover:bg-indigo-500 hover:shadow-lg hover:shadow-indigo-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="h-4.5 w-4.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Add Product
            </a>
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Stat 1 -->
        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm flex items-center gap-4">
            <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                </svg>
            </span>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Products</p>
                <p class="text-2xl font-bold text-slate-900 mt-0.5">{{ $products->count() }}</p>
            </div>
        </div>

        <!-- Stat 2 -->
        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm flex items-center gap-4">
            <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
            </span>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Low Stock (≤10)</p>
                <p class="text-2xl font-bold text-slate-900 mt-0.5">{{ $products->where('stock', '>', 0)->where('stock', '<=', 10)->count() }}</p>
            </div>
        </div>

        <!-- Stat 3 -->
        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm flex items-center gap-4">
            <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-rose-50 text-rose-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </span>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Out of Stock</p>
                <p class="text-2xl font-bold text-slate-900 mt-0.5">{{ $products->where('stock', 0)->count() }}</p>
            </div>
        </div>

        <!-- Stat 4 -->
        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm flex items-center gap-4">
            <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </span>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Average Price</p>
                <p class="text-2xl font-bold text-slate-900 mt-0.5">${{ number_format($products->avg('price'), 2) }}</p>
            </div>
        </div>
    </div>

    <!-- Products Table Card -->
    <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm">
        @if($products->isEmpty())
            <div class="py-16 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto h-12 w-12 text-slate-300">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                </svg>
                <h3 class="mt-4 text-sm font-semibold text-slate-900">No products found</h3>
                <p class="mt-1.5 text-xs text-slate-500 font-medium">Get started by creating a new product.</p>
                <div class="mt-6">
                    <a href="{{ route('products.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-indigo-500 transition shadow-sm">
                        Add Product
                    </a>
                </div>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-left text-sm text-slate-500">
                    <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-700 border-b border-slate-200">
                        <tr>
                            <th scope="col" class="px-6 py-4">Product Info</th>
                            <th scope="col" class="px-6 py-4">Price</th>
                            <th scope="col" class="px-6 py-4">Stock Status</th>
                            <th scope="col" class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($products as $product)
                            <tr class="hover:bg-slate-50/60 transition duration-150">
                                <td class="px-6 py-4.5">
                                    <div class="font-semibold text-slate-900">{{ $product->name }}</div>
                                    @if($product->description)
                                        <div class="mt-1 text-xs text-slate-400 max-w-sm truncate">{{ $product->description }}</div>
                                    @else
                                        <div class="mt-1 text-xs text-slate-350 italic">No description provided.</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4.5 font-medium text-slate-900">
                                    ${{ number_format($product->price, 2) }}
                                </td>
                                <td class="px-6 py-4.5">
                                    @if($product->stock == 0)
                                        <span class="inline-flex items-center gap-1 rounded-md bg-rose-50 px-2 py-1 text-xs font-semibold text-rose-700 ring-1 ring-inset ring-rose-600/10">
                                            Out of stock
                                        </span>
                                    @elseif($product->stock <= 10)
                                        <span class="inline-flex items-center gap-1 rounded-md bg-amber-50 px-2 py-1 text-xs font-semibold text-amber-700 ring-1 ring-inset ring-amber-600/10">
                                            Low stock: {{ $product->stock }} left
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 rounded-md bg-emerald-50 px-2 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-600/10">
                                            In stock: {{ $product->stock }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4.5 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('products.edit', $product->id) }}" class="rounded-lg p-2 text-slate-500 hover:text-indigo-600 hover:bg-indigo-50/50 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4.5 w-4.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-lg p-2 text-slate-500 hover:text-rose-600 hover:bg-rose-50/50 transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4.5 w-4.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection