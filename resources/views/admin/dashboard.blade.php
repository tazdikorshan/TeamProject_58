@extends('layouts.admin')

@section('title', 'Dashboard | HomeDome')

@section('content')

<style>
    :root {
        --hd-primary: #ff7b00;
        --hd-primary-hover: #e06c00;
        --hd-bg: #f3f4f6;
        --hd-card-bg: #ffffff;
        --hd-text: #1f2937;
        --hd-muted: #6b7280;
        --hd-border: #e5e7eb;
        --hd-warning: #f59e0b;
        --hd-alert: #ef4444;
    }


    body {
        background-color: var(--hd-bg);
        color: var(--hd-text);
        font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        margin: 0;
    }

    .page-wrap {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1.5rem;
    }

    .page-wrap h1 {
        margin: 0 0 0.5rem 0;
        font-size: 1.75rem;
        color: #111827;
    }

    p.sub {
        color: var(--hd-muted);
        margin-bottom: 2rem;
        font-size: 0.95rem;
    }

    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .report-card,
    .box {
        background-color: var(--hd-card-bg);
        border: 1px solid var(--hd-border);
        border-radius: 8px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    }

    .report-card {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .report-card h3 {
        margin: 0 0 0.75rem 0;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--hd-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .report-card .value {
        font-size: 2rem;
        font-weight: 700;
        color: var(--hd-text);
    }

    .report-card .value.status-warning {
        color: var(--hd-warning);
    }

    .report-card .value.status-alert {
        color: var(--hd-alert);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 0.5rem;
    }

    th {
        text-align: left;
        padding: 0.75rem 1rem;
        background-color: #f9fafb;
        color: var(--hd-muted);
        font-size: 0.875rem;
        font-weight: 600;
        border-bottom: 2px solid var(--hd-border);
    }

    td {
        padding: 1rem;
        border-bottom: 1px solid var(--hd-border);
        font-size: 0.95rem;
    }

    tbody tr:last-child td {
        border-bottom: none;
    }

    tbody tr:hover {
        background-color: #f9fafb;
    }

    .btn {
        display: inline-block;
        padding: 0.6rem 1.2rem;
        font-size: 0.95rem;
        font-weight: 500;
        border-radius: 6px;
        transition: background-color 0.2s ease, transform 0.1s ease;
        cursor: pointer;
        border: none;
    }

    .btn-primary {
        background-color: var(--hd-primary);
        color: #ffffff;
    }

    .btn-primary:hover {
        background-color: var(--hd-primary-hover);
    }
</style>

<div class="page-wrap">
    <h1>System Overview</h1>
    <p class="sub">Real-time reports on inventory levels and order fulfillment.</p>

    <div class="dashboard-grid">
        <div class="report-card">
            <h3>Total Revenue</h3>
            <div class="value">£{{ number_format($totalRevenue, 2) }}</div>
        </div>

        <div class="report-card">
            <h3>Pending Orders</h3>
            <div class="value @if($pendingOrders > 0) status-warning @endif">{{ $pendingOrders }}</div>
        </div>

        <div class="report-card">
            <h3>Low Stock Items</h3>
            <div class="value @if($lowStockCount > 0) status-warning @endif">{{ $lowStockCount }}</div>
        </div>

        <div class="report-card">
            <h3>Out of Stock</h3>
            <div class="value @if($outOfStockCount > 0) status-alert @endif">{{ $outOfStockCount }}</div>
        </div>
    </div>

    <div style="display: flex; gap: 20px; flex-wrap: wrap;">
        <div class="box" style="flex: 2; min-width: 400px;">
            <h2 style="font-size: 16px; margin-bottom: 15px;">Recent Transactions</h2>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->user->name ?? 'Guest User' }}</td>
                        <td>£{{ number_format($order->total_amount, 2) }}</td>
                        <td>{{ $order->status }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="box" style="flex: 1; min-width: 280px;">
            <h2 style="font-size: 16px; margin-bottom: 15px;">Inventory Health</h2>
            <div style="margin-bottom: 20px;">
                <p style="font-size: 14px; color: var(--hd-muted);">Total Products Managed:</p>
                <p style="font-size: 24px; font-weight: 700;">{{ \App\Models\Product::count() }}</p>
            </div>
            <a href="{{ route('admin.products.index') }}" class="btn btn-primary" style="text-decoration:none; display:block; text-align:center;">Manage Products</a>
        </div>
    </div>
</div>

@endsection