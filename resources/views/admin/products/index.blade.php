@extends('layouts.admin')

@section('title', 'Inventory | HomeDome')

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
        --hd-danger: #ef4444;
        --hd-danger-hover: #dc2626;
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
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    }

    .box h2 {
        font-size: 1.1rem;
        margin-top: 0;
        margin-bottom: 1rem;
        color: #111827;
    }

    .row {
        display: flex;
        gap: 1.25rem;
        flex-wrap: wrap;
        margin-bottom: 1rem;
    }

    .field {
        flex: 1 1 220px;
    }

    .field label {
        display: block;
        font-size: 0.875rem;
        margin-bottom: 0.4rem;
        color: var(--hd-text);
        font-weight: 600;
    }

    .field select {
        width: 100%;
        padding: 0.6rem 0.75rem;
        border-radius: 6px;
        border: 1px solid var(--hd-border);
        font-size: 0.95rem;
        font-family: inherit;
        background-color: #fff;
        box-sizing: border-box;
        transition: border-color 0.2s, box-shadow 0.2s;
        cursor: pointer;
        appearance: auto;
    }


    .field select:focus {
        outline: none;
        border-color: var(--hd-primary);
        box-shadow: 0 0 0 3px rgba(255, 123, 0, 0.15);
    }



    .field input[type="text"],
    .field input[type="number"],
    .field input[type="file"],
    .field textarea {
        width: 100%;
        padding: 0.6rem 0.75rem;
        border-radius: 6px;
        border: 1px solid var(--hd-border);
        font-size: 0.95rem;
        font-family: inherit;
        background: #fff;
        box-sizing: border-box;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .field textarea {
        resize: vertical;
        min-height: 80px;
    }

    .field input:focus,
    .field textarea:focus {
        outline: none;
        border-color: var(--hd-primary);
        box-shadow: 0 0 0 3px rgba(255, 123, 0, 0.15);
    }

    .checkbox-field {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }

    .checkbox-field input[type="checkbox"] {
        width: 1.1rem;
        height: 1.1rem;
        accent-color: var(--hd-primary);
        cursor: pointer;
    }

    .checkbox-field label {
        margin: 0;
        font-size: 0.9rem;
        color: var(--hd-text);
        font-weight: 500;
        cursor: pointer;
    }

    .btn {
        display: inline-block;
        padding: 0.6rem 1.2rem;
        font-size: 0.95rem;
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

    .btn-danger {
        background: var(--hd-danger);
        color: #fff;
    }

    .btn-danger:hover {
        background: var(--hd-danger-hover);
    }

    .actions {
        display: flex;
        gap: 0.5rem;
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

    tbody tr:not(.edit-row):hover {
        background-color: #f9fafb;
    }

    .edit-area {
        background: #f9fafb;
        padding: 1.5rem;
        border-radius: 8px;
        border: 1px solid var(--hd-border);
        margin: 0.5rem 0;
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

    .badge {
        padding: 0.25rem 0.6rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
        text-transform: uppercase;
        letter-spacing: 0.02em;
    }

    .badge-in-stock {
        background: #d1fae5;
        color: #065f46;
    }

    .badge-low-stock {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-out-of-stock {
        background: #fee2e2;
        color: #991b1b;
    }

    .restock-form {
        display: flex;
        gap: 5px;
        align-items: center;
        border-top: 1px solid #e5e7eb;
        padding-top: 8px;
    }

    .restock-input {
        width: 70px;
        padding: 0.3rem;
        border: 1px solid #e5e7eb;
        border-radius: 4px;
        font-size: 0.85rem;
    }

    .btn-receive {
        padding: 0.3rem 0.6rem;
        font-size: 0.85rem;
        background-color: #10b981;
        color: #ffffff;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .btn-receive:hover {
        background-color: #059669;
    }
</style>

<div class="page-wrap">

    <h1>Inventory Management</h1>
    <p class="sub">Manage product listings, stock levels, and view inventory status alerts.</p>

    @if(session('success'))
    <div class="msg-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
    <div class="msg-error">
        <strong>Error:</strong>
        <ul style="margin: 6px 0 0 18px;">
            @foreach($errors->all() as $e)
            <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="box">
        <h2>Add New Product</h2>

        <form method="POST" action="/admin/products" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="field">
                    <label>Product Name *</label>
                    <input name="name" type="text" value="{{ old('name') }}" required>
                </div>

                <div class="field">
                    <label>SKU (Unique ID) *</label>
                    <input name="sku" type="text" value="{{ old('sku') }}" required>
                </div>

                <div class="field">
                    <label>Price (£) *</label>
                    <input name="price" type="number" step="0.01" min="0" value="{{ old('price') }}" required>
                </div>
            </div>

            <div class="row">
                <div class="field">
                    <label>Initial Stock Quantity *</label>
                    <input name="stock_quantity" type="number" min="0" value="{{ old('stock_quantity', 0) }}" required>
                </div>

                <div class="field">
                    <label>Low Stock Threshold *</label>
                    <input name="low_stock_threshold" type="number" min="0" value="{{ old('low_stock_threshold', 5) }}" required title="When stock hits this number, show a Low Stock alert">
                </div>

                <div class="field">
                    <label>Product Images</label>
                    <input name="images[]" type="file" multiple accept="image/*">
                </div>
            </div>

            <div class="row">
                <div class="field">
                    <label>Category *</label>
                    <select name="category_id" id="category_id" required>
                        <option value="">Select a Category</option>
                        @php
                            $parents = $categories->whereNull('parent_id');
                            $children = $categories->whereNotNull('parent_id');
                        @endphp
                        @foreach($parents as $parent)
                            @php $subs = $children->where('parent_id', $parent->id); @endphp
                            @if($subs->isNotEmpty())
                                <optgroup label="{{ $parent->name }}">
                                    <option value="{{ $parent->id }}">{{ $parent->name }} (General)</option>
                                    @foreach($subs as $sub)
                                        <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                                    @endforeach
                                </optgroup>
                            @else
                                <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="field">
                    <label>Dimensions (e.g., 50x40x30 cm)</label>
                    <input name="dimensions" type="text" value="{{ old('dimensions') }}">
                </div>

                <div class="field">
                    <label>Energy Rating</label>
                    <input name="energy_rating" type="text" value="{{ old('energy_rating') }}" placeholder="e.g., A+++">
                </div>
            </div>

            <div class="row">
                <div class="field" style="flex: 1 1 100%;">
                    <label>Product Description</label>
                    <textarea name="description">{{ old('description') }}</textarea>
                </div>
            </div>

            <div class="checkbox-field">
                <input type="checkbox" name="is_available" id="is_available" value="1" {{ old('is_available', true) ? 'checked' : '' }}>
                <label for="is_available">Product is available for purchase</label>
            </div>

            <div style="margin-top: 1.5rem;">
                <button class="btn btn-primary" type="submit">Save Product</button>
            </div>
        </form>
    </div>

    <div class="box">

        <div class="box" style="background: #fdfdfd;">
            <h2 style="margin-bottom: 15px; font-size: 1.1rem;">Filter Inventory</h2>

            <form method="GET" action="/admin/products" style="display: flex; gap: 15px; align-items: flex-end; flex-wrap: wrap;">

                <div class="field" style="flex: 2; min-width: 200px;">
                    <label>Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by product name or SKU...">
                </div>

                <div class="field" style="flex: 1; min-width: 150px;">
                    <label>Category</label>
                    <select name="category_id">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="field" style="flex: 1; min-width: 150px;">
                    <label>Stock Status</label>
                    <select name="stock_status">
                        <option value="">All Statuses</option>
                        <option value="in" {{ request('stock_status') == 'in' ? 'selected' : '' }}>In Stock</option>
                        <option value="low" {{ request('stock_status') == 'low' ? 'selected' : '' }}>Low Stock</option>
                        <option value="out" {{ request('stock_status') == 'out' ? 'selected' : '' }}>Out of Stock</option>
                    </select>
                </div>

                <div style="display: flex; gap: 10px; margin-bottom: 2px;">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                    @if(request()->has('search') || request()->has('category_id') || request()->has('stock_status'))
                    <a href="/admin/products" class="btn btn-edit" style="text-decoration: none; line-height: 1.5;">Clear</a>
                    @endif
                </div>
            </form>
        </div>

        <h2>Current Inventory</h2>

        <table>
            <thead>
                <tr>
                    <th style="width: 25%;">Product</th>
                    <th style="width: 15%;">SKU</th>
                    <th style="width: 15%;">Price</th>
                    <th style="width: 20%;">Stock Status</th>
                    <th style="width: 25%;">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($products as $p)
                <tr>
                    <td><strong>{{ $p->name }}</strong></td>
                    <td>{{ $p->sku }}</td>
                    <td>£{{ number_format($p->price, 2) }}</td>
                    <td>
                        @if($p->stock_status === 'In Stock!')
                        <span class="badge badge-in-stock">{{ $p->stock_quantity }} In Stock</span>
                        @elseif($p->stock_status === 'Low Stock')
                        <span class="badge badge-low-stock">{{ $p->stock_quantity }} Low Stock!</span>
                        @elseif($p->stock_status === 'Out of Stock!')
                        <span class="badge badge-out-of-stock">Out of Stock!</span>
                        @endif
                    </td>
                    <!-- <td>
                        <div class="actions">
                            <button class="btn btn-edit" type="button" onclick="toggleEdit({{ $p->id }})">Edit</button>

                            <form method="POST" action="/admin/products/{{ $p->id }}/delete" onsubmit="return confirm('Delete this product?');">
                                @csrf
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                        </div>
                    </td> -->

                    <td>
                        <div class="actions" style="margin-bottom: 8px;">
                            <button class="btn btn-edit" type="button" onclick="toggleEdit({{ $p->id }})">Edit Details</button>

                            <form method="POST" action="/admin/products/{{ $p->id }}/delete" onsubmit="return confirm('Delete this product?');">
                                @csrf
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                        </div>

                        <form method="POST" action="/admin/products/{{ $p->id }}/restock" style="display: flex; gap: 5px; align-items: center; border-top: 1px solid #e5e7eb; padding-top: 8px;">
                            @csrf
                            <input type="number" name="restock_amount" min="1" placeholder="+ Qty" class="restock-input" required title="Enter the amount of new stock received">
                            <button class="btn btn-receive" type="submit">Receive Stock</button>
                        </form>
                    </td>

                </tr>

                <tr id="edit-row-{{ $p->id }}" class="edit-row" style="display:none;">
                    <td colspan="5" style="border-bottom: none; padding-top: 0;">
                        <div class="edit-area">
                            <form method="POST" action="/admin/products/{{ $p->id }}/update" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="field">
                                        <label>Product Name</label>
                                        <input name="name" type="text" value="{{ $p->name }}" required>
                                    </div>
                                    <div class="field">
                                        <label>Category</label>
                                        <select name="category_id" required>
                                            @php
                                                $parents = $categories->whereNull('parent_id');
                                                $children = $categories->whereNotNull('parent_id');
                                                $currentCatId = DB::table('product_category')->where('product_id', $p->id)->value('category_id');
                                            @endphp
                                            @foreach($parents as $parent)
                                                @php $subs = $children->where('parent_id', $parent->id); @endphp
                                                @if($subs->isNotEmpty())
                                                    <optgroup label="{{ $parent->name }}">
                                                        <option value="{{ $parent->id }}" {{ $currentCatId == $parent->id ? 'selected' : '' }}>{{ $parent->name }} (General)</option>
                                                        @foreach($subs as $sub)
                                                            <option value="{{ $sub->id }}" {{ $currentCatId == $sub->id ? 'selected' : '' }}>{{ $sub->name }}</option>
                                                        @endforeach
                                                    </optgroup>
                                                @else
                                                    <option value="{{ $parent->id }}" {{ $currentCatId == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="field">
                                        <label>Price (£)</label>
                                        <input name="price" type="number" step="0.01" value="{{ $p->price }}" required>
                                    </div>
                                    <div class="field">
                                        <label>Stock Quantity</label>
                                        <input name="stock_quantity" type="number" value="{{ $p->stock_quantity }}" required>
                                    </div>
                                    <div class="field">
                                        <label>Low Stock Threshold</label>
                                        <input name="low_stock_threshold" type="number" value="{{ $p->low_stock_threshold }}" required>
                                    </div>
                                </div>

                                <div class="row" style="align-items: center;">
                                    <div class="field">
                                        <label>Update Images (Optional)</label>
                                        <input name="images[]" type="file" multiple accept="image/*">
                                    </div>
                                    <div class="checkbox-field field" style="margin-top: 1rem;">
                                        <input type="checkbox" name="is_available" id="edit_is_available_{{ $p->id }}" value="1" {{ $p->is_available ? 'checked' : '' }}>
                                        <label for="edit_is_available_{{ $p->id }}">Available for Sale</label>
                                    </div>
                                </div>

                                <div class="actions" style="margin-top: 1.5rem;">
                                    <button class="btn btn-primary" type="submit">Update Product</button>
                                    <button class="btn btn-edit" type="button" onclick="toggleEdit({{ $p->id }})">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: var(--hd-muted);">No products found in inventory.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script>
        function toggleEdit(id) {
            const row = document.getElementById('edit-row-' + id);
            if (!row) return;

            if (row.style.display === 'none' || row.style.display === '') {
                row.style.display = 'table-row';
            } else {
                row.style.display = 'none';
            }
        }
    </script>

</div>
@endsection