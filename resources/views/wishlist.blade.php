@extends('layouts.app')

@section('title', 'My Wishlist')

@section('content')

    <div class="product_showing">
        <h1>My Wishlist</h1>
    </div>

    @if(session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 10px; margin: 20px; border-radius: 5px;">
            {{ session('success') }}
        </div>
    @endif

    @if($wishlistItems->isEmpty())
        <div style="padding: 20px; text-align: center;">
            <p>Your wishlist is empty.</p>
            <a href="/" style="color: var(--hd-dark-red); text-decoration: underline;">Browse Products</a>
        </div>
    @else
        <div class="product-container">
            @foreach($wishlistItems as $item)
                <div class="product-card">
                    <h3>{{ $item->name }}</h3>

                    @if($item->image_url)
                        <a href="{{ route('product.show', ['id' => $item->id]) }}">
                            <img src="{{ asset($item->image_url) }}" alt="{{ $item->name }}">
                        </a>
                    @endif

                    <p>£{{ number_format($item->price, 2) }}</p>

                    <form action="{{ route('wishlist.remove', $item->id) }}" method="POST" style="margin-top: 10px;">
                        @csrf
                        <button type="submit"
                            style="background: none; border: 1px solid var(--hd-dark-red); color: var(--hd-dark-red); padding: 5px 10px; border-radius: 5px; cursor: pointer;">
                            <i class="fa-solid fa-trash"></i> Remove
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif

@endsection

<style>
    /* Reusing styles from app.css via layout, adding specific container style if needed */
    .product-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        padding: 20px;
        justify-content: center;
    }

    .product-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 16px;
        width: 300px;
        text-align: center;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .product-card img {
        max-width: 100%;
        height: 200px;
        object-fit: contain;
        margin-bottom: 10px;
    }

    .product_showing {
        text-align: center;
        margin: 20px 0;
        color: var(--hd-orange-brown);
    }
</style>