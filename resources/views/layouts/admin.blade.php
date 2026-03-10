<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Admin | HomeDome')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" type="image/png" href="{{ asset('images/homeDomeLogo.png') }}">
</head>

<body class="min-h-screen bg-gray-50 text-gray-900">
    @include('partials.admin-header')

    <main class="max-w-6xl mx-auto px-4 py-6">
        @yield('content')
    </main>
</body>

</html>