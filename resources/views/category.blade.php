@extends('layouts.app')

@section('title', ucwords(str_replace('-', ' ', $slug)))

@section('content')

<style>
    .product_showing {
        text-align: center;
        font-size: 36px;
        font-weight: 900;

    }

    .product-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 24px;
        width: 90%;
        margin: 0 auto 60px auto;
    }

    .product-card {
        background: #ffffff;
        padding: 18px;
        border-radius: 14px;
        border: 2px solid #e5e7eb;
        text-align: center;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .product-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
    }

    .product-card img {
        width: 100%;
        height: 200px;
        object-fit: contain;
        margin-bottom: 10px;
    }

    .product-card h3 {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .product-card p {
        font-size: 16px;
        font-weight: 600;
    }
</style>

<h1 class="product_showing">
    {{ ucwords(str_replace('-', ' ', $slug)) }}
</h1>

@if($results->isEmpty())
<p style="text-align:center; font-size:18px;">
    No products found.
</p>
@else
<div class="product-container">
    @foreach($results as $product)
    <div class="product-card">
        <h3>{{ $product->name }}</h3>

        @if($product->url)
        <a href="{{ route('product.show', ['id' => $product->id]) }}">
            <img src="{{ asset($product->url) }}" alt="{{ $product->name }}">
        </a>
        @endif

        <p>£{{ number_format($product->price, 2) }}</p>
    </div>
    @endforeach
</div>
@endif

@endsection
