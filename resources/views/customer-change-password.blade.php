@extends('layouts.app')

@section('content')
<style>
    .wrap{max-width:700px;margin:50px auto;padding:0 16px}
    .card{border:1px solid #e5e7eb;border-radius:14px;padding:18px;box-shadow:0 10px 26px rgba(0,0,0,.08);background:#fff}
    h1{margin:0 0 10px;font-size:22px}
    p{margin:0 0 16px;color:#6b7280;font-size:13px}
    label{display:block;font-weight:700;margin:10px 0 6px;font-size:13px;color:#374151}
    input{width:100%;padding:10px 11px;border:1px solid #d1d5db;border-radius:10px;font-size:14px}
    .btn{display:inline-block;margin-top:14px;border:none;border-radius:999px;padding:10px 16px;background:#B03A2E;color:#fff;font-weight:700;cursor:pointer}
    .btn:hover{background:#8b241b}
    .alert{border:1px solid #f1c0c0;background:#fff1f1;color:#7a1f1f;padding:12px 14px;border-radius:10px;margin-bottom:12px}
    .rules{margin-top:12px;color:#6b7280;font-size:13px}
    .rules ul{margin-top:6px;padding-left:18px}
</style>

<div class="wrap">
    <div class="card">
        <h1>Change Password</h1>
        <p>Update your password regularly for better security.</p>

        @if ($errors->any())
            <div class="alert">
                <ul style="margin:0; padding-left:18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/customer/change-password">
            @csrf

            <label for="current_password">Current password</label>
            <input id="current_password" name="current_password" type="password" required>

            <label for="password">New password</label>
            <input id="password" name="password" type="password" required>

            <label for="password_confirmation">Confirm new password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required>

            <button class="btn" type="submit">Update password</button>

            <div class="rules">
                <ul>
                    <li>Must have at least 8 characters</li>
                    <li>Cannot reuse current password</li>
                </ul>
            </div>
        </form>
    </div>
</div>
@endsection