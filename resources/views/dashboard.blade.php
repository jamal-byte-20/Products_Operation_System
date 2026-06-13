@extends('layouts.app')

@section('title', 'Dashboard | StockOps')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Welcome back, {{ auth()->user()->name }}!</h1>
        <p class="mt-1 text-sm text-slate-500 font-medium">Here is an overview of your operation statistics.</p>
    </div>

    <!-- Stats Cards Grid -->
    <div class="grid gap-6 sm:grid-cols-3">
        <!-- Users Card -->
        <div class="relative overflow-hidden rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm">
            <div class="flex items-center gap-4">
                <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0110.089 20.08c-2.114 0-4.084-.567-5.777-1.558a11.35 11.35 0 01-1.39-1.049A4.125 4.125 0 0110 12.06c1.171 0 2.261.279 3.228.78M15 10.028a3.3 3.3 0 001.954-3.078 3.3 3.3 0 00-3.3-3.3M9 10.028a3.3 3.3 0 01-3.3-3.3M9 10.028a3.3 3.3 0 003.3 3.3m0 0a3.3 3.3 0 003.3-3.3M9 10.028v-.002" />
                    </svg>
                </span>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Users</p>
                    <p class="text-3xl font-bold text-slate-900 mt-0.5">{{ $users }}</p>
                </div>
            </div>
            <div class="absolute bottom-0 inset-x-0 h-1 bg-gradient-to-r from-blue-500 to-sky-400"></div>
        </div>

        <!-- Products Card -->
        <div class="relative overflow-hidden rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm">
            <div class="flex items-center gap-4">
                <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                    </svg>
                </span>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Products</p>
                    <p class="text-3xl font-bold text-slate-900 mt-0.5">{{ $products }}</p>
                </div>
            </div>
            <div class="absolute bottom-0 inset-x-0 h-1 bg-gradient-to-r from-indigo-500 to-violet-400"></div>
        </div>

        <!-- Orders Card -->
        <div class="relative overflow-hidden rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm">
            <div class="flex items-center gap-4">
                <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.893l.895 12c.076 1.02-.746 1.893-1.77 1.893H5.304c-1.025 0-1.846-.872-1.77-1.893l.895-12c.069-.933.84-1.645 1.777-1.645h11.954c.938 0 1.708.712 1.777 1.645z" />
                    </svg>
                </span>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Orders</p>
                    <p class="text-3xl font-bold text-slate-900 mt-0.5">{{ $orders }}</p>
                </div>
            </div>
            <div class="absolute bottom-0 inset-x-0 h-1 bg-gradient-to-r from-emerald-500 to-teal-400"></div>
        </div>
    </div>

    <!-- Quick Shortcuts / Actions Section -->
    <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm">
        <h2 class="text-lg font-bold text-slate-900 mb-4">Quick Actions</h2>
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <a href="{{ route('products.index') }}" class="group flex items-center justify-between rounded-xl border border-slate-200 p-4 transition hover:border-indigo-500 hover:bg-slate-50/50">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-100 text-slate-600 transition group-hover:bg-indigo-50 group-hover:text-indigo-650">
                        >
                    </span>
                    <div>
                        <p class="text-sm font-semibold text-slate-900">View Products List</p>
                        <p class="text-xs text-slate-400 font-medium">Browse and search products</p>
                    </div>
                </div>
                >
            </a>

            <a href="{{ route('products.create') }}" class="group flex items-center justify-between rounded-xl border border-slate-200 p-4 transition hover:border-indigo-500 hover:bg-slate-50/50">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-100 text-slate-600 transition group-hover:bg-indigo-50 group-hover:text-indigo-650">
                        >
                    </span>
                    <div>
                        <p class="text-sm font-semibold text-slate-900">Add New Product</p>
                        <p class="text-xs text-slate-400 font-medium">Create a new product listing</p>
                    </div>
                </div>
                >
            </a>
        </div>
    </div>
</div>
@endsection