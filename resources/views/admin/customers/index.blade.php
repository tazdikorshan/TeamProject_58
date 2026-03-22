@extends('layouts.admin')

@section('title', 'Customer Management')

@section('content')

<style>
    :root {
        --hd-orange: #F57C00;
        --hd-dark-red: #B03A2E;
        --hd-grey: #333333;
        --hd-muted: #6b7280;
        --hd-border: #e5e7eb;
    }

    .page-wrap {
        max-width: 1100px;
        margin: 25px auto;
        padding: 0 16px;
    }

    h1 {
        font-size: 22px;
        margin-bottom: 6px;
        color: var(--hd-grey);
    }

    .sub {
        font-size: 13px;
        color: var(--hd-muted);
        margin-bottom: 16px;
    }

    .box {
        background: #fff;
        border: 1px solid var(--hd-border);
        border-radius: 10px;
        padding: 16px;
        margin-bottom: 18px;
    }

    .row {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .field {
        flex: 1 1 220px;
    }

    .field label {
        display: block;
        font-size: 13px;
        margin-bottom: 4px;
        color: var(--hd-grey);
    }

    .field input {
        width: 100%;
        padding: 9px 10px;
        border-radius: 8px;
        border: 1px solid #d1d5db;
        font-size: 14px;
    }

    .field input:focus {
        outline: none;
        border-color: var(--hd-orange);
        box-shadow: 0 0 0 1px rgba(245, 124, 0, 0.2);
    }

    .btn {
        border: none;
        border-radius: 8px;
        padding: 8px 12px;
        cursor: pointer;
        font-size: 13px;
        font-weight: 600;
    }

    .btn-primary {
        background: var(--hd-dark-red);
        color: #fff;
    }

    .btn-primary:hover {
        background: #8b241b;
    }

    .btn-edit {
        background: #f3f4f6;
        color: #111827;
    }

    .btn-edit:hover {
        background: #e5e7eb;
    }

    .btn-danger {
        background: #ef4444;
        color: #fff;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    th, td {
        border-bottom: 1px solid var(--hd-border);
        padding: 10px 8px;
        text-align: left;
        font-size: 14px;
    }

    th {
        font-size: 12px;
        color: var(--hd-muted);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .msg-success {
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #065f46;
        padding: 10px 12px;
        border-radius: 8px;
        margin-bottom: 14px;
        font-size: 14px;
    }

    .msg-error {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
        padding: 10px 12px;
        border-radius: 8px;
        margin-bottom: 14px;
        font-size: 14px;
    }

    .edit-area {
        background: #f9fafb;
        border: 1px solid var(--hd-border);
        border-radius: 8px;
        padding: 12px;
        margin-top: 10px;
    }

    .actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
</style>

<div class="page-wrap">

    <h1>Customer Management</h1>
    <p class="sub">Manage all customer accounts (view, add, delete and update customers’ details).</p>

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
        <h2 style="font-size:16px; margin-bottom:10px;">Create Customer</h2>

        <form method="POST" action="/admin/customers">
            @csrf

            <div class="row">
                <div class="field">
                    <label>Full name</label>
                    <input name="name" value="{{ old('name') }}" required>
                </div>

                <div class="field">
                    <label>Email</label>
                    <input name="email" type="email" value="{{ old('email') }}" required>
                </div>

                <div class="field">
                    <label>Password</label>
                    <input name="password" type="password" required>
                </div>

                <div class="field">
                    <label>Confirm password</label>
                    <input name="password_confirmation" type="password" required>
                </div>
            </div>

            <div style="margin-top: 12px;">
                <button class="btn btn-primary" type="submit">Create Customer</button>
            </div>
        </form>
    </div>

    <div class="box">
        <h2 style="font-size:16px; margin-bottom:10px;">All Customers</h2>

        <table>
            <thead>
                <tr>
                    <th style="width: 28%;">Name</th>
                    <th style="width: 36%;">Email</th>
                    <th style="width: 16%;">Created</th>
                    <th style="width: 20%;">Actions</th>
                </tr>
            </thead>

            <tbody>
            @forelse($customers as $c)
                <tr>
                    <td>{{ $c->name }}</td>
                    <td>{{ $c->email }}</td>
                    <td style="color: var(--hd-muted); font-size: 13px;">
                        {{ $c->created_at?->format('d M Y') }}
                    </td>
                    <td>
                        <div class="actions">
                            <button class="btn btn-edit" type="button" onclick="toggleEdit({{ $c->id }})">
                                Edit
                            </button>

                            <form method="POST" action="/admin/customers/{{ $c->id }}/delete"
                                  onsubmit="return confirm('Are you certain you want to delete this customer?');">
                                @csrf
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>

                {{-- Inline edit section --}}
                <tr id="edit-row-{{ $c->id }}" style="display:none;">
                    <td colspan="4">
                        <div class="edit-area">
                            <form method="POST" action="/admin/customers/{{ $c->id }}/update">
                                @csrf

                                <div class="row">
                                    <div class="field">
                                        <label>Full name</label>
                                        <input name="name" value="{{ $c->name }}" required>
                                    </div>

                                    <div class="field">
                                        <label>Email</label>
                                        <input name="email" type="email" value="{{ $c->email }}" required>
                                    </div>

                                    <div class="field">
                                        <label>New password</label>
                                        <input name="password" type="password" placeholder="Optional">
                                    </div>

                                    <div class="field">
                                        <label>Confirm new password</label>
                                        <input name="password_confirmation" type="password" placeholder="********">
                                    </div>
                                </div>

                                <p style="margin-top: 8px; font-size: 12px; color: var(--hd-muted);">
                                    Only fill in the fields you want changed.
                                </p>

                                <div style="margin-top: 12px; display:flex; gap: 10px;">
                                    <button class="btn btn-edit" type="button" onclick="toggleEdit({{ $c->id }})">
                                        Cancel
                                    </button>
                                    <button class="btn btn-primary" type="submit">
                                        Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="4" style="color: var(--hd-muted); padding: 12px 8px;">
                        No customers found.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

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

@endsection