<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" type="image/png" href="{{ asset('images/homeDomeLogo.png') }}">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HomeDome')</title>
    <script src="{{ asset('js/search.js') }}"></script>
    <style>
        :root {
            --hd-orange: #F57C00;
            --hd-orange-brown: #E67E22;
            --hd-dark-red: #B03A2E;
            --hd-black: #000000;
            --hd-grey: #333333;
            --hd-text-muted: #6b7280;
        }

        body {
            min-height: 100vh;
            background: #ffffff;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
        }

        .page {
            width: 100%;
            height: 100%;
            margin: 0;
            border: none;
            border-radius: 0;
            box-shadow: none;
        }

        .top-bar {
            background: var(--hd-orange);
            padding: 12px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .top-bar a {
            text-decoration: none;

        }

        .top-logo {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .top-logo img {
            width: 44px;
            height: 44px;
            border-radius: 8px;
            border: 2px solid #ffffff;
        }

        .top-logo-text {
            font-weight: 800;
            font-size: 20px;
            color: #ffffff;
        }

        .top-search {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .top-search-input {
            width: 500px;
            height: 38px;
            padding: 0 16px;
            border-radius: 24px;
            border: 1px solid #d1d5db;
            font-size: 14px;
            outline: none;
        }

        .top-search-button {
            margin-left: 10px;
            height: 38px;
            padding: 0 18px;
            border-radius: 24px;
            border: none;
            background: var(--hd-dark-red);
            color: white;
            font-size: 14px;
            cursor: pointer;
        }

        .top-icons {
            display: flex;
            gap: 28px;
            align-items: center;
        }

        .icon-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            color: #ffffff;
            text-decoration: none;
            font-size: 12px;
            font-weight: 500;
            position: relative;
        }

        .icon-item i {
            font-size: 20px;
            margin-bottom: 4px;
        }

        .icon-item:hover {
            opacity: 0.8;
        }

        .icon-badge {
            position: absolute;
            top: -4px;
            right: -10px;
            min-width: 16px;
            height: 16px;
            padding: 0 4px;
            border-radius: 999px;
            background: #ffffff;
            color: var(--hd-dark-red);
            font-size: 10px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 4px rgba(0, 0, 0, 0.25);
        }

        .icon-badge.wishlist {
            background: #ffffff;
            color: #B03A2E;
        }

        .icon-badge.basket {
            background: #ffffff;
            color: #B03A2E;
        }

        .category-bar {
            background: var(--hd-orange-brown);
            color: #ffffff;
            font-size: 13px;
            padding: 8px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .category-bar a {
            color: #ffffff;
            text-decoration: none;
            font-weight: 500;
        }

        .category-bar a:hover {
            text-decoration: underline;
        }

        .content {
            display: flex;
            flex-wrap: wrap;
            background: #ffffff;
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
            background-image: url('{{ asset(' images/homedome-logo.png') }}');
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
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
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

            .content {
                flex-direction: column;
                align-items: stretch;
            }

            .hero {
                order: -1;
            }

            .form-side {
                padding-top: 24px;
                padding-bottom: 32px;
            }
        }

        @media (max-width: 600px) {

            .page {
                margin-top: 10px;
                border-radius: 0;
            }

            .top-bar {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .top-search {
                width: 100%;
            }

            .form-side {
                padding-inline: 20px;
            }

            .hero {
                padding-inline: 20px;
            }

            .hero-title {
                font-size: 32px;
                white-space: normal;
            }
        }


        .filter {
            color: white;
            margin-left: 50px;
        }

        .account-menu {
            position: relative;
        }

        .account-trigger {
            cursor: default;
        }

        .account-menu::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            top: 100%;
            height: 14px;
        }

        .account-dropdown {
            position: absolute;
            top: 100%;
            right: -110px;
            width: 220px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            box-shadow: 0 14px 40px rgba(0, 0, 0, 0.18);
            padding: 8px;
            z-index: 9999;
            display: none;

            transform: translateY(10px);
        }

        .account-menu:hover .account-dropdown {
            display: block;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 10px 10px;
            border-radius: 10px;
            text-decoration: none;
            color: #111827;
            font-size: 13px;
            font-weight: 600;
        }

        .dropdown-item i {
            font-size: 14px;
            color: var(--hd-dark-red);
        }

        .dropdown-item:hover {
            background: #f3f4f6;
        }

        .dropdown-divider {
            height: 1px;
            background: #e5e7eb;
            margin: 8px 6px;
        }

        .dropdown-item-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-family: inherit;
            text-align: left;
        }


        details.filter-dropdown>summary {
            list-style: none;
            cursor: pointer;
            padding: 10px 20px;
            color: white;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: bold;
            transition: opacity 0.2s ease;
        }


        details.filter-dropdown>summary::-webkit-details-marker {
            display: none;
        }

        details.filter-dropdown>summary:hover {
            opacity: 0.8;
        }


        .filter-dropdown {
            position: relative;
            display: inline-block;
            font-family: inherit;
        }

        .dropdown-content {
            position: absolute;
            top: 120%;
            left: 0;
            background: #F57C00;
            border-radius: 8px;
            padding: 20px;
            width: 220px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.15);
            z-index: 10;
            color: white;
        }


        .dropdown-content h4 {
            margin: 0 0 12px 0;
            font-size: 1.1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            padding-bottom: 5px;
        }


        .dropdown-content h4:nth-of-type(2) {
            margin-top: 20px;
        }


        .dropdown-content label {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
            cursor: pointer;
            color: white;
            font-size: 0.95rem;
            transition: transform 0.1s ease;
        }


        .dropdown-content label:hover {
            transform: translateX(4px);
        }


        .dropdown-content input[type="radio"] {
            accent-color: #333;
            width: 16px;
            height: 16px;
            cursor: pointer;
        }


        #FilterButton {
            margin-top: 15px;
            width: 100%;
            padding: 10px;
            background-color: white;
            color: #F57C00;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
            transition: background-color 0.2s, transform 0.1s;
        }

        #FilterButton:hover {
            background-color: #fdfdfd;
            transform: translateY(-2px);
        }

        #FilterButton:active {
            transform: translateY(0);
        }

        footer {
            background: brown;
            color: white;
            padding: 25px 20px;
        }

        footer h4 {
            font-size: 12px;
            text-align: center;
            margin-bottom: 15px;
        }

        .footer-box {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            max-width: 1000px;
            margin: auto;
            gap: 20px;
        }

        .footer-col {
            flex: 1;
            min-width: 150px;
        }

        .footer-col h5 {
            margin-bottom: 10px;
            font-size: 15px;
        }

        .footer-col a {
            display: block;
            color: white;
            font-size: 15px;
            text-decoration: none;
            margin-bottom: 6px;
        }

        .footer-col a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    @include('partials.header')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')
</body>

</html>