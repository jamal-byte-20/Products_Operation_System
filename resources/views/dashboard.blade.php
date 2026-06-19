{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard | StockOps')

@section('content')
<div class="dashboard-page">
    <div class="page-container">
        
        {{-- Header Section --}}
        <div class="page-header">
            <div class="header-left">
                <span class="system-status"><span class="status-dot"></span> System Operational</span>
                <h1 class="page-title">Welcome back, {{ auth()->user()->name }}</h1>
                <p class="page-subtitle">Overview of your system operation statistics.</p>
            </div>
        </div>

        {{-- Core Metrics Stats Grid --}}
        <div class="stats-grid">
            <!-- Users Card -->
            <div class="stat-card">
                <div class="stat-content">
                    <span class="stat-label">Total Users</span>
                    <span class="stat-number">{{ $users }}</span>
                </div>
                <div class="stat-footer">Active system accounts</div>
            </div>

            <!-- Products Card -->
            <div class="stat-card">
                <div class="stat-content">
                    <span class="stat-label">Total Products</span>
                    <span class="stat-number">{{ $products }}</span>
                </div>
                <div class="stat-footer">Items in catalog database</div>
            </div>

            <!-- Orders Card -->
            <div class="stat-card">
                <div class="stat-content">
                    <span class="stat-label">Total Orders</span>
                    <span class="stat-number">{{ $orders }}</span>
                </div>
                <div class="stat-footer">Processed via system operations</div>
            </div>
        </div>

        {{-- Analytical Graphics Split Section --}}
        <div class="analytics-split">
            
            <!-- Graphic 1: Inventory Health Ring -->
            <div class="analytics-card text-center">
                <div class="card-header">
                    <h3 class="analytics-title">Inventory Health</h3>
                    <p class="analytics-subtitle">Stock capacity status</p>
                </div>
                
                <div class="radial-graphic-container">
                    <svg class="radial-svg" viewBox="0 0 128 128">
                        <circle cx="64" cy="64" r="52" stroke="#f1f3f5" stroke-width="10" fill="transparent" />
                        <circle cx="64" cy="64" r="52" stroke="#28a745" stroke-width="10" fill="transparent" 
                                stroke-dasharray="326" stroke-dashoffset="{{ 326 - (326 * 78) / 100 }}" stroke-linecap="round" />
                    </svg>
                    <div class="radial-label">
                        <span class="radial-number">78%</span>
                        <span class="radial-text">Optimal</span>
                    </div>
                </div>

                <div class="card-meta-footer">
                    <span>Status: <strong style="color: #28a745;">Stable</strong></span>
                </div>
            </div>

            <!-- Graphic 2: Pure HTML/CSS Proportion Bar Chart -->
            <div class="analytics-card">
                <div class="card-header">
                    <h3 class="analytics-title">Operational Distribution</h3>
                    <p class="analytics-subtitle">Relative scale of database entries</p>
                </div>

                <div class="bar-chart-container">
                    @php
                        $max = max($users, $products, $orders, 1);
                        $usersPct = ($users / $max) * 100;
                        $productsPct = ($products / $max) * 100;
                        $ordersPct = ($orders / $max) * 100;
                    @endphp
                    
                    <!-- Bar 1 -->
                    <div class="chart-row">
                        <div class="row-info">
                            <span>System Users</span>
                            <strong>{{ $users }}</strong>
                        </div>
                        <div class="bar-track">
                            <div class="bar-fill" style="width: {{ $usersPct }}%; background-color: #6c757d;"></div>
                        </div>
                    </div>

                    <!-- Bar 2 -->
                    <div class="chart-row">
                        <div class="row-info">
                            <span>Active Products</span>
                            <strong>{{ $products }}</strong>
                        </div>
                        <div class="bar-track">
                            <div class="bar-fill" style="width: {{ $productsPct }}%; background-color: #333;"></div>
                        </div>
                    </div>

                    <!-- Bar 3 -->
                    <div class="chart-row">
                        <div class="row-info">
                            <span>Fulfillment Orders</span>
                            <strong>{{ $orders }}</strong>
                        </div>
                        <div class="bar-track">
                            <div class="bar-fill" style="width: {{ $ordersPct }}%; background-color: #28a745;"></div>
                        </div>
                    </div>
                </div>

                <div class="card-meta-footer">
                    <span style="font-size: 0.75rem; color: #868e96;">Values scale automatically based on record metrics.</span>
                </div>
            </div>

        </div>

        {{-- Shortcuts Action Panel Layout --}}
        <div class="shortcuts-section">
            <h2 class="shortcuts-title">Quick Actions</h2>
            <div class="shortcuts-grid">
                
                <a href="{{ route('products.index') }}" class="shortcut-button">
                    <div class="shortcut-content">
                        <span class="shortcut-heading">View Products List</span>
                        <span class="shortcut-desc">Browse and search inventory rows</span>
                    </div>
                    <span class="shortcut-arrow">→</span>
                </a>

                <a href="{{ route('products.create') }}" class="shortcut-button">
                    <div class="shortcut-content">
                        <span class="shortcut-heading">Add New Product</span>
                        <span class="shortcut-desc">Create a dynamic entry link</span>
                    </div>
                    <span class="shortcut-arrow">→</span>
                </a>

            </div>
        </div>

    </div>
</div>

<style>
    /* ========== CLEAN HOME & VIEW DESIGN STANDARD SYSTEM ========== */
    .dashboard-page {
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

    /* ========== HEADER SECTION ========== */
    .page-header {
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

    /* ========== METRICS CARD GRID ========== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2rem;
        margin-bottom: 2.5rem;
    }

    .stat-card {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px rgba(0,0,0,0.01);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .stat-label {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6c757d;
        display: block;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: bold;
        color: #222;
        display: block;
        margin-top: 0.25rem;
    }

    .stat-footer {
        margin-top: 1rem;
        font-size: 0.8rem;
        color: #868e96;
        border-top: 1px solid #f1f3f5;
        padding-top: 0.75rem;
    }

    /* ========== VISUAL ANALYTICS LAYOUT SLIT ========== */
    .analytics-split {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 2rem;
        margin-bottom: 2.5rem;
    }

    @media (max-width: 768px) {
        .analytics-split {
            grid-template-columns: 1fr;
        }
    }

    .analytics-card {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .text-center {
        text-align: center;
    }

    .analytics-title {
        font-size: 1.1rem;
        color: #222;
        margin: 0;
    }

    .analytics-subtitle {
        font-size: 0.8rem;
        color: #6c757d;
        margin: 0.25rem 0 0 0;
    }

    /* Radial Circle Graphics Container */
    .radial-graphic-container {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 2rem auto;
        width: 128px;
        height: 128px;
    }

    .radial-svg {
        transform: rotate(-90deg);
        width: 100%;
        height: 100%;
    }

    .radial-label {
        position: absolute;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .radial-number {
        font-size: 1.75rem;
        font-weight: bold;
        color: #222;
    }

    .radial-text {
        font-size: 0.65rem;
        text-transform: uppercase;
        color: #868e96;
        font-weight: bold;
        letter-spacing: 0.5px;
    }

    /* Bar Charts Container CSS */
    .bar-chart-container {
        padding: 1.5rem 0;
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    .chart-row {
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
    }

    .row-info {
        display: flex;
        justify-content: space-between;
        font-size: 0.85rem;
        color: #495057;
    }

    .bar-track {
        background-color: #f1f3f5;
        height: 10px;
        border-radius: 4px;
        overflow: hidden;
    }

    .bar-fill {
        height: 100%;
        border-radius: 4px;
        transition: width 0.5s ease;
    }

    .card-meta-footer {
        border-top: 1px solid #e9ecef;
        padding-top: 0.75rem;
        font-size: 0.8rem;
        color: #495057;
        text-align: left;
    }

    /* ========== MANAGEMENT ACTION PANELS ========== */
    .shortcuts-section {
        border-top: 1px solid #e9ecef;
        padding-top: 2rem;
    }

    .shortcuts-title {
        font-size: 1.25rem;
        color: #222;
        margin-bottom: 1.25rem;
    }

    .shortcuts-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1.5rem;
    }

    .shortcut-button {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: white;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 1.25rem;
        text-decoration: none;
        transition: border-color 0.2s, background-color 0.2s;
    }

    .shortcut-button:hover {
        border-color: #333;
        background-color: #f8f9fa;
    }

    .shortcut-heading {
        font-size: 0.95rem;
        font-weight: bold;
        color: #333;
        display: block;
    }

    .shortcut-desc {
        font-size: 0.8rem;
        color: #6c757d;
        display: block;
        margin-top: 0.2rem;
    }

    .shortcut-arrow {
        color: #adb5bd;
        font-size: 1.1rem;
        transition: transform 0.2s;
    }

    .shortcut-button:hover .shortcut-arrow {
        color: #333;
        transform: translateX(4px);
    }
</style>
@endsection