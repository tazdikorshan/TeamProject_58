@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')

<style>
    :root {
        --hd-orange: #F57C00;
        --hd-orange-brown: #E67E22;
        --hd-dark-red: #B03A2E;
        --hd-black: #000000;
        --hd-grey: #333333;
        --hd-text-muted: #6b7280;
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    .content {
        display: flex;
        flex-wrap: wrap;
        background: #ffffff;
        min-height: calc(100vh - 70px);
        align-items: stretch;
    }

    .hero {
        flex: 1 1 45%;
        position: relative;
        padding: 40px 32px;
        overflow: hidden;
        background: linear-gradient(135deg, var(--hd-orange) 0%, var(--hd-orange-brown) 55%, var(--hd-dark-red) 100%);
        color: #ffffff;
        display: flex;
        align-items: center;
    }

    .hero::before {
        content: "";
        position: absolute;
        inset: -40px -60px auto;
        background-image: url('{{ asset('images/homedome-logo.png') }}');
        background-repeat: no-repeat;
        background-position: top left;
        background-size: 260px 260px;
        filter: blur(6px);
        opacity: 0.25;
        z-index: 0;
    }

    .hero-inner {
        position: relative;
        z-index: 1;
    }

    .hero-title {
        font-size: clamp(32px, 4vw, 44px);
        font-weight: 900;
        letter-spacing: -0.03em;
        line-height: 1.1;
    }

    .hero-sub {
        margin-top: 10px;
        font-size: 16px;
        max-width: 320px;
    }

    .hero-badge {
        margin-top: 20px;
        display: inline-block;
        padding: 8px 16px;
        border-radius: 999px;
        background: rgba(0, 0, 0, 0.16);
        font-size: 13px;
    }

    .form-side {
        flex: 1 1 55%;
        padding: 32px 40px 36px;
        display: flex;
        align-items: center;
    }

    .form-inner {
        width: 100%;
        max-width: 600px;
        margin: 0 auto;
    }

    .form-heading {
        font-size: 22px;
        margin-bottom: 4px;
        color: var(--hd-black);
    }

    .form-sub {
        font-size: 13px;
        color: var(--hd-text-muted);
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
    }

    .field input {
        width: 100%;
        padding: 10px 11px;
        border-radius: 10px;
        border: 1px solid #d1d5db;
        font-size: 14px;
    }

    .btn-primary {
        width: 100%;
        border: none;
        border-radius: 999px;
        padding: 10px;
        background: var(--hd-dark-red);
        color: #ffffff;
        font-weight: 600;
        font-size: 15px;
        cursor: pointer;
        box-shadow: 0 12px 36px rgba(176, 58, 46, 0.5);
    }
</style>

<main class="content">
    <section class="hero">
        <div class="hero-inner">
            <h1 class="hero-title">Reset your password</h1>
            <p class="hero-sub">Enter your account email and get sent a password reset link.</p>
            <span class="hero-badge">Quick and easy password reset</span>
        </div>
    </section>

    <section class="form-side">
        <div class="form-inner">
            <h2 class="form-heading">Forgot Password</h2>
            <p class="form-sub">Enter your email address to receive a link.</p>

            @if (session('status'))
                <p style="color: green; font-size: 13px; margin-bottom: 10px;">
                   If an account exists with that email, We have emailed you!
                </p>
            @endif

            @error('email')
                <p style="color: red; font-size: 12px; margin-bottom: 10px;">
                    {{ $message }}
                </p>
            @enderror

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="field">
                    <label for="email">Email address</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required>
                </div>

                <button type="submit" class="btn-primary">Send Reset Link</button>
            </form>
        </div>
    </section>
</main>

@endsection