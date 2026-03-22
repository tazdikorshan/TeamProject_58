@extends('layouts.admin')

@section('title', 'Change Password | HomeDome')

@section('content')
    <style>
        .page {
            width: 100%;
            height: 100%;
            margin: 0;
            border: none;
            border-radius: 0;
            box-shadow: none;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 0 16px;
        }

        .card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            box-shadow: 0 10px 26px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .card-head {
            padding: 18px 20px;
            border-bottom: 1px solid #e5e7eb;
            background: rgba(245, 124, 0, 0.07);
        }

        .title {
            font-size: 22px;
            font-weight: 900;
            color: var(--hd-black);
            margin-bottom: 6px;
        }

        .subtitle {
            font-size: 13px;
            color: var(--hd-text-muted);
        }

        .card-body {
            padding: 20px;
        }

        .alert{
            border: 1px solid #f1c0c0;
            background: #fff1f1;
            color:#7a1f1f;
            padding: 12px 14px;
            border-radius: 10px;
            margin-bottom: 16px;
        }

        .field {
            margin-bottom: 12px;
        }

        .field label {
            display: block;
            font-size: 13px;
            margin-bottom: 4px;
            color: #374151;
            font-weight: 700;
        }

        .field input {
            width: 100%;
            padding: 10px 11px;
            border-radius: 10px;
            border: 1px solid #d1d5db;
            font-size: 14px;
        }

        .field input:focus {
            outline: none;
            border-color: var(--hd-orange);
            box-shadow: 0 0 0 1px rgba(245, 124, 0, 0.25);
        }

        .btn-primary {
            border: none;
            border-radius: 999px;
            padding: 10px 18px;
            background: var(--hd-dark-red);
            color: #ffffff;
            font-weight: 700;
            font-size: 15px;
            cursor: pointer;
            box-shadow: 0 12px 36px rgba(176, 58, 46, 0.35);
        }

        .btn-primary:hover {
            background: #8b241b;
        }

        .rules {
            margin-top: 12px;
            font-size: 13px;
            color: var(--hd-text-muted);
        }

        .rules ul {
            margin-top: 6px;
            padding-left: 18px;
        }
    </style>

    <div class="page">
        <div class="container">
            <div class="card">
                <div class="card-head">
                    <div class="title">Change your password</div>
                    <div class="subtitle">For the purpose of security, new admin accounts must create a new password after first login.</div>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert">
                            <ul style="margin:0; padding-left:18px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="/force-password-change">
                        @csrf

                        <div class="field">
                            <label for="password">New password</label>
                            <input id="password" type="password" name="password" required>
                        </div>

                        <div class="field">
                            <label for="password_confirmation">Confirm new password</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required>
                        </div>

                        <button type="submit" class="btn-primary">Update password</button>

                        <div class="rules">
                            <ul>
                                <li>Must have at least 8 characters</li>
                                <li>Cannot reuse old password</li>
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection