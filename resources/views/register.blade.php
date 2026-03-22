@extends('layouts.app')

@section('title', 'Register')

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
        font-size: 48px;
        font-weight: 900;
        letter-spacing: -0.03em;
        line-height: 1.1;
        display: block;
        white-space: nowrap;
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
            <h1 class="hero-title">Join us at HomeDome</h1>
            <p class="hero-sub">Sign up for a free HomeDome account — everything you need for your home.</p>
            <span class="hero-badge">Quick sign up | Protected with reCAPTCHA | Hassle free checkout</span>
        </div>
    </section>

    <section class="form-side">
        <div class="form-inner">
            <h2 class="form-heading">Create your HomeDome account</h2>
            <p class="form-sub">Enter your details to get started.</p>

            <form method="POST" action="{{ route('register-submit') }}">
                @csrf

                <div class="field">
                    <label for="name">Full name</label>
                    <input id="name" name="name" type="text" placeholder="Bob Smith" value="{{ old('name') }}" required>

                    @error('name')
                        <span style="color: var(--hd-dark-red); font-size: 12px; margin-top: 4px; display: block;">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

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

                <div class="field">
                    <label for="password_confirmation">Confirm password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" placeholder="**********" required>
                </div>

                <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>

                    @error('g-recaptcha-response')
                    <p style="color: red; font-size: 12px; margin-top: 5px;">
                    {{ $message }}</p>
                    @enderror

                    @error('recaptcha')
                    <p style="color: red; font-size: 12px; margin-top: 5px;">
                        {{ $message }}</p>
                    @enderror

                <button type="submit" class="btn-primary">Create account</button>

                <p class="helper-text">
                    Already a HomeDome member?
                    <a href="/login">Log in</a>
                </p>
            </form>
        </div>
    </section>
</main>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

@endsection