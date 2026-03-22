@extends('layouts.admin')

@section('title', 'Admin Created | HomeDome')

@section('content')
    <style>
        .wrap{max-width:700px;margin:50px auto;padding:0 16px}
        .card{border:1px solid #e5e7eb;border-radius:14px;padding:18px;box-shadow:0 10px 26px rgba(0,0,0,.08)}
        h1{margin:0 0 10px;font-size:22px}
        .box{margin-top:12px;border:1px dashed #d1d5db;border-radius:12px;padding:12px;background:#fafafa}
        .label{color:#6b7280;font-size:12px;margin-bottom:6px}
        .value{font-weight:800;font-size:16px}
        .warn{margin-top:12px;color:#6b7280;font-size:13px}
        .btn{display:inline-block;margin-top:14px;text-decoration:none;border-radius:999px;padding:10px 16px;background:#F57C00;color:#fff;font-weight:800}
        .btn:hover{opacity:.9}
    </style>

    <div class="wrap">
        <div class="card">
            <h1>Admin account created</h1>

            <div class="box">
                <div class="label">Name</div>
                <div class="value">{{ $adminName }}</div>
            </div>

            <div class="box">
                <div class="label">Email</div>
                <div class="value">{{ $adminEmail }}</div>
            </div>

            <div class="box">
                <div class="label">Temporary automated password</div>
                <div class="value">{{ $tempPassword }}</div>
            </div>

            <div class="warn">
                Careful this password is shown only ONCE. The new admin will be forced to change it after first login.
            </div>

            <a class="btn" href="/">Return to homepage</a>
        </div>
    </div>
@endsection