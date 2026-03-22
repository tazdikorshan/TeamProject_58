@extends('layouts.app')

@section('title', 'Login')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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
        display: block;
        white-space: nowrap;
        max-width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
        animation: fadeSlide 0.8s ease-out forwards;
        opacity: 0;
        transform: translateY(12px);
    }

    @keyframes fadeSlide {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
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

    .field input::placeholder {
        color: #9ca3af;
    }

    .field input:focus {
        outline: none;
        border-color: var(--hd-orange);
        box-shadow: 0 0 0 1px rgba(245, 124, 0, 0.25);
    }

    .row-between {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 12px;
        margin-bottom: 10px;
    }

    .checkbox {
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .checkbox input {
        width: 14px;
        height: 14px;
        accent-color: var(--hd-orange);
    }

    .link-inline {
        color: var(--hd-dark-red);
        font-weight: 500;
        text-decoration: none;
    }

    .link-inline:hover {
        text-decoration: underline;
    }

    .captcha-box {
        margin: 10px 0 6px;
        padding: 10px;
        border-radius: 10px;
        border: 1px dashed #d1d5db;
        font-size: 12px;
        text-align: center;
        color: var(--hd-text-muted);
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

    .btn-primary:hover {
        background: #8b241b;
    }

    .helper-text {
        margin-top: 10px;
        font-size: 12px;
        text-align: center;
        color: var(--hd-text-muted);
    }

    .helper-text a {
        color: var(--hd-dark-red);
        text-decoration: none;
        font-weight: 600;
    }

    .helper-text a:hover {
        text-decoration: underline;
    }

    @media (max-width: 900px) {
        .content { flex-direction: column; align-items: stretch; }
        .hero { order: -1; }
        .form-side { padding-top: 24px; padding-bottom: 32px; }
    }

    @media (max-width: 600px) {
        .form-side { padding-inline: 20px; }
        .hero { padding-inline: 20px; }
        .hero-title { font-size: 32px; white-space: normal; }
    }
</style>

<main class="content">
    <section class="hero">
        <div class="hero-inner">
            <h1 class="hero-title">Welcome to HomeDome</h1>
            <p class="hero-sub">Log in for a personalised experience at HomeDome.</p>
            <span class="hero-badge">Safe and Secure login | Protected with reCAPTCHA</span>
        </div>
    </section>

    <section class="form-side">
        <div class="form-inner">
            <h2 class="form-heading">Log in to your account</h2>
            <p class="form-sub">Enter your details to access your HomeDome account.</p>

    <!--UI success notifier for when a background process successfully ran-->
    @if (session('success'))
        <p style="color: green; font-size: 13px; margin-bottom: 10px;">
            {{ session('success') }}
        </p>
    @endif

    <!--UI error notifier for when a background process has failed-->
    @if (session('error'))
        <p style="color: red; font-size: 13px; margin-bottom: 10px;">
            {{ session('error') }}
        </p>
    @endif

            <form method="POST" action="{{ route('login.submit') }}">
                @csrf

                <div class="field">
                    <label for="email">Email address</label>
                    <input id="email" name="email" type="email" placeholder="you@example.com" value="{{ old('email') }}" required>

                    @error('email')
                        <span style="color: var(--hd-dark-red); font-size: 12px; margin-top: 4px; display: block;">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" placeholder="**********" required>

                    @error('password')
                        <span style="color: var(--hd-dark-red); font-size: 12px; margin-top: 4px; display: block;">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="row-between">
                    <label class="checkbox">
                        <input type="checkbox" name="remember">
                        <span>Remember me</span>
                    </label>

                    <a href="/forgot-password" class="link-inline">Forgot password?</a>
                </div>

                <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>

                    @error('g-recaptcha-response')
                    <p style="color: red; font-size: 12px; margin-top: 5px;">
                    {{ $message }}</p>
                    @enderror

                    @error('recaptcha')
                    <p style="color: red; font-size: 12px; margin-top: 5px;">
                        {{ $message }}</p>
                    @enderror

                <button type="submit" class="btn-primary">Login</button>

                <p class="helper-text">
                    New to HomeDome?
                    <a href="/register">Create an account</a>
                </p>
            </form>
        </div>
    </section>
</main>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

@endsection