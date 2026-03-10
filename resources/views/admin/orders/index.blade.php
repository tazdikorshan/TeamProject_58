@extends('layouts.admin')

@section('title', 'Orders | HomeDome')

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
    }

    body {
        background-color: var(--hd-bg);
        color: var(--hd-text);
        font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
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

    .box {
        background-color: var(--hd-card-bg);
        border: 1px solid var(--hd-border);
        border-radius: 8px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    }

    .msg-success {
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #065f46;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        font-size: 0.95rem;
    }

    .msg-error {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        font-size: 0.95rem;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        text-align: left;
        padding: 0.75rem 1rem;
        background-color: #f9fafb;
        color: var(--hd-muted);
        font-size: 0.85rem;
        font-weight: 600;
        border-bottom: 2px solid var(--hd-border);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    td {
        padding: 1rem;
        border-bottom: 1px solid var(--hd-border);
        font-size: 0.95rem;
        vertical-align: middle;
    }

    tbody tr:not(.details-row):hover {
        background-color: #f9fafb;
    }

    .order-details {
        background: #f9fafb;
        padding: 1.5rem;
        border-radius: 8px;
        border: 1px solid var(--hd-border);
        margin: 0.5rem 0;
    }

    .order-details h3 {
        font-size: 0.95rem;
        margin-top: 0;
        margin-bottom: 0.75rem;
        color: var(--hd-text);
    }

    .order-details ul {
        margin-bottom: 1rem;
        padding-left: 1.25rem;
        font-size: 0.9rem;
        color: var(--hd-muted);
    }

    .order-details li {
        margin-bottom: 0.25rem;
    }

    .order-details hr {
        border: 0;
        border-top: 1px solid var(--hd-border);
        margin-bottom: 1rem;
    }

    .status-update-form {
        display: flex;
        align-items: center;
    }

    .status-update-form label {
        font-size: 0.9rem;
        font-weight: 600;
        margin-right: 0.75rem;
        color: var(--hd-text);
    }

    .status-select {
        padding: 0.6rem 0.75rem;
        border-radius: 6px;
        border: 1px solid var(--hd-border);
        font-size: 0.95rem;
        font-family: inherit;
        background: #fff;
        margin-right: 1rem;
        cursor: pointer;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .status-select:focus {
        outline: none;
        border-color: var(--hd-primary);
        box-shadow: 0 0 0 3px rgba(255, 123, 0, 0.15);
    }

    .btn {
        display: inline-block;
        padding: 0.6rem 1.2rem;
        font-size: 0.9rem;
        font-weight: 500;
        border-radius: 6px;
        transition: background-color 0.2s ease;
        cursor: pointer;
        border: none;
        text-align: center;
    }

    .btn-primary {
        background-color: var(--hd-primary);
        color: #ffffff;
    }

    .btn-primary:hover {
        background-color: var(--hd-primary-hover);
    }

    .btn-edit {
        background: #f3f4f6;
        color: #111827;
        border: 1px solid var(--hd-border);
    }

    .btn-edit:hover {
        background: #e5e7eb;
    }

    .badge {
        padding: 0.35rem 0.7rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
        text-transform: uppercase;
        letter-spacing: 0.02em;
    }

    .badge-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-processing {
        background: #dbeafe;
        color: #1e40af;
    }

    .badge-shipped {
        background: #d1fae5;
        color: #065f46;
    }

    .badge-cancelled {
        background: #fee2e2;
        color: #991b1b;
    }
</style>

<div class="page-wrap">

    <h1>Order Processing</h1>
    <p class="sub">View customer transactions, process shipments, and update order statuses.</p>

    @if(session('success'))
    <div class="msg-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
    <div class="msg-error">{{ $errors->first() }}</div>
    @endif

    <div class="box">
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td><strong>#{{ $order->id }}</strong></td>
                    <td>{{ $order->user->name ?? 'Unknown Customer' }}</td>
                    <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</td>
                    <td>£{{ number_format($order->total_amount, 2) }}</td>
                    <td>
                        <span class="badge 
                            @if(strtolower($order->status) == 'pending') badge-pending 
                            @elseif(strtolower($order->status) == 'processing') badge-processing 
                            @elseif(strtolower($order->status) == 'shipped' || strtolower($order->status) == 'delivered') badge-shipped 
                            @else badge-cancelled @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-edit" type="button" onclick="toggleDetails({{ $order->id }})">
                            Process / View Details
                        </button>
                    </td>
                </tr>

                <tr id="details-row-{{ $order->id }}" style="display:none;">
                    <td colspan="6">
                        <div class="order-details">
                            <h3 style="font-size: 14px; margin-bottom: 10px; color: var(--hd-grey);">Items to Ship:</h3>
                            <ul style="margin-bottom: 16px; padding-left: 20px; font-size: 13px; color: var(--hd-muted);">
                                @foreach($order->items as $item)
                                <li>
                                    {{ $item->quantity }}x <strong>{{ $item->product->name ?? 'Deleted Product' }}</strong>
                                    (SKU: {{ $item->product->sku ?? 'N/A' }}) - £{{ number_format($item->unit_price, 2) }} each
                                </li>
                                @endforeach
                            </ul>

                            <hr style="border: 0; border-top: 1px solid var(--hd-border); margin-bottom: 12px;">

                            <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}" style="display: flex; align-items: center;">
                                @csrf
                                <label style="font-size: 13px; font-weight: 600; margin-right: 10px;">Update Status:</label>
                                <select name="status" class="status-select">
                                    <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Processing" {{ $order->status == 'Processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="Shipped" {{ $order->status == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="Delivered" {{ $order->status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="Cancelled" {{ $order->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </form>

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: var(--hd-muted);">No orders found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<script>
    function toggleDetails(id) {
        const row = document.getElementById('details-row-' + id);
        if (row.style.display === 'none' || row.style.display === '') {
            row.style.display = 'table-row';
        } else {
            row.style.display = 'none';
        }
    }
</script>

@endsection