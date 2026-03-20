@extends('layouts.app')

@section('title', 'HomeDOME')

@section('content')


<div class="welcome-banner">
    <h1>Welcome to the home of home products</h1>
</div>
<div class=product_showing>
    <h2> Liven up your living room with our furniture </h2>
</div>
<div class="product-container">
    @foreach ($products->slice(0, 3) as $product)
    <div class="product-card">
        <h3>{{ $product->name }}</h3>

        @if($product->url)
        <a href="{{ route('product.show', ['id' => $product->id]) }}">
            <img src="{{ str_starts_with($product->url, 'images/') || str_starts_with($product->url, '/images/') ? asset($product->url) : asset('storage/' . $product->url) }}" alt="{{ $product->name }}">
        </a>
        @endif

        <p>£{{ number_format($product->price, 2) }}</p>
    </div>
    @endforeach
</div>

<div class=product_showing>
    <h2> We take appliances seriously </h2>
</div>
<div class="product-container">
    @foreach ($products->slice(6, 3) as $product)
    <div class="product-card">
        <h3>{{ $product->name }}</h3>

        @if($product->url)
        <a href="{{ route('product.show', ['id' => $product->id]) }}">
            <img src="{{ str_starts_with($product->url, 'images/') || str_starts_with($product->url, '/images/') ? asset($product->url) : asset('storage/' . $product->url) }}" alt="{{ $product->name }}">
        </a>
        @endif

        <p>£{{ number_format($product->price, 2) }}</p>
    </div>
    @endforeach
</div>

<div class=product_showing>
    <h2> We put the home in home decor </h2>
</div>
<div class="product-container">
    @foreach ($products->slice(11, 3) as $product)
    <div class="product-card">
        <h3>{{ $product->name }}</h3>

        @if($product->url)
        <a href="{{ route('product.show', ['id' => $product->id]) }}">
            <img src="{{ str_starts_with($product->url, 'images/') || str_starts_with($product->url, '/images/') ? asset($product->url) : asset('storage/' . $product->url) }}" alt="{{ $product->name }}">
        </a>
        @endif

        <p>£{{ number_format($product->price, 2) }}</p>
    </div>
    @endforeach
</div>

<div class=product_showing>
    <h2> Our kitchenware is affordable and built to last </h2>
</div>
<div class="product-container">
    @foreach ($products->slice(16, 3) as $product)
    <div class="product-card">
        <h3>{{ $product->name }}</h3>

        @if($product->url)
        <a href="{{ route('product.show', ['id' => $product->id]) }}">
            <img src="{{ str_starts_with($product->url, 'images/') || str_starts_with($product->url, '/images/') ? asset($product->url) : asset('storage/' . $product->url) }}" alt="{{ $product->name }}">
        </a>
        @endif

        <p>£{{ number_format($product->price, 2) }}</p>
    </div>
    @endforeach
</div>

<div class=product_showing>
    <h2> Make your world brighter with our lighting options </h2>
</div>
<div class="product-container">
    @foreach ($products->slice(21, 3) as $product)
    <div class="product-card">
        <h3>{{ $product->name }}</h3>

        @if($product->url)
        <a href="{{ route('product.show', ['id' => $product->id]) }}">
            <img src="{{ str_starts_with($product->url, 'images/') || str_starts_with($product->url, '/images/') ? asset($product->url) : asset('storage/' . $product->url) }}" alt="{{ $product->name }}">
        </a>
        @endif

        <p>£{{ number_format($product->price, 2) }}</p>
    </div>
    @endforeach
</div>




@endsection