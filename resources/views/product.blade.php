@extends('layouts.app')

@section('title', ($product['name'] ?? 'Product') . ' - HomeDome')

@section('content')

    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
    <link rel="stylesheet" href="{{ asset('css/advertisement.css') }}">
    <link rel="stylesheet" href="{{ asset('css/alert.css') }}">
    <script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.4.0/model-viewer.min.js"></script>

    <div class="breadcrumbs">
        <a href="/">Home</a> >
        <a href="/appliances">{{ $product['category'] ?? 'Products' }}</a> >
        @if(isset($product['subcategory']))
            <a href="/{{ strtolower(str_replace(' ', '-', $product['subcategory'])) }}">
                {{ $product['subcategory'] }}
            </a> >
        @endif
        <span>{{ $product['name'] ?? 'Product' }}</span>
    </div>

    <!--UI success notifier for when a background process successfully ran-->
    @if (session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif


    <div class="product-container">

        <div class="product-media">
            <div class="product-title-mobile">
                <h1 class="product-title">{{ $product['name'] }}</h1>
                <p class="product-sku">SKU: {{ $product['sku'] }}</p>
            </div>

            <div class="main-image-container">
                @if(isset($product['media']) && count($product['media']) > 0)
                    <img src="{{ asset($product['media'][0]['url']) }}" alt="{{ $product['name'] }}" class="main-image"
                        id="mainImage">
                @else
                    <img src="{{ asset('images/homeDomeLogo.png') }}" alt="{{ $product['name'] }}" class="main-image"
                        id="mainImage">
                @endif

                @if($product['energy_rating'])
                    <span class="energy-badge">
                        <i class="fa-solid fa-leaf"></i> {{ $product['energy_rating'] }}
                    </span>
                @endif

                <button class="viewer-3d-button" onclick="open3DViewer()">
                    <i class="fa-solid fa-cube"></i>
                    View in 3D
                </button>
            </div>

            @if(isset($product['media']) && count($product['media']) > 1)
                <div class="thumbnail-gallery">
                    @foreach($product['media'] as $index => $media)
                        @if($media['type'] === 'image')
                            <img src="{{ asset($media['url']) }}" class="thumbnail {{ $index === 0 ? 'active' : '' }}"
                                onclick="changeImage(this)">
                        @endif
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Right Purchase Info -->
        <div class="product-info">
            <div class="product-title-desktop">
                <h1 class="product-title">{{ $product['name'] }}</h1>
                <p class="product-sku">SKU: {{ $product['sku'] }}</p>
            </div>

            <!-- Star ratings -->
            @if(isset($product['reviews']) && count($product['reviews']) > 0)
                <div class="rating-summary">
                    <div class="stars">
                        @php
                            $rating = $product['average_rating'] ?? 0;
                            $fullStars = floor($rating);
                            $hasHalfStar = ($rating - $fullStars) >= 0.5;
                         @endphp

                        @for($i = 0; $i < $fullStars; $i++)
                            <i class="fa-solid fa-star"></i>
                        @endfor

                        @if($hasHalfStar)
                            <i class="fa-solid fa-star-half-stroke"></i>
                        @endif

                        @for($i = 0; $i < (5 - $fullStars - ($hasHalfStar ? 1 : 0)); $i++)
                            <i class="fa-regular fa-star"></i>
                        @endfor
                    </div>
                    <span class="rating-text">{{ $rating }} out of 5</span>
                    <a href="#reviews" class="rating-link">({{ count($product['reviews']) }} reviews)</a>
                </div>
            @endif

            <!-- Pricing -->
            <div class="price-section">
                <div>
                    <span class="price">£{{ number_format($product['price'], 2) }}</span>
                </div>

                @if($product['is_available'] && $product['stock_quantity'] > 0)
                    <div class="stock-status in-stock">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>In Stock - {{ $product['stock_quantity'] }} Available</span>
                    </div>
                @else
                    <div class="stock-status out-of-stock">
                        <i class="fa-solid fa-circle-xmark"></i>
                        <span>Out of Stock</span>
                    </div>
                @endif
            </div>

            @if($product['is_available'] && $product['stock_quantity'] > 0)
                <!-- Quantity Selector Form for Basket -->
                <form id="basketForm" action="{{ route('addProduct.addProduct', ['pid' => $product['id']]) }}" method="POST">
                    @csrf
                    <div class="quantity-selector">
                        <label>Quantity:</label>
                        <div class="quantity-controls">
                            <button type="button" class="quantity-btn" onclick="decreaseQuantity()">-</button>
                            <input type="number" id="quantity" name="quantity" class="quantity-input" value="1" min="1"
                                max="{{ $product['stock_quantity'] }}">
                            <button type="button" class="quantity-btn" onclick="increaseQuantity()">+</button>
                        </div>
                    </div>
                </form>

                <!-- Wishlist Form -->
                <form id="wishlistForm" action="{{ route('wishlist.add', ['id' => $product['id']]) }}" method="POST">
                    @csrf
                </form>

                <!-- Add to basket and wishlist Buttons -->
                <div class="cta-buttons">
                    <button type="submit" form="basketForm" class="btn btn-primary">
                        <i class="fa-solid fa-cart-shopping"></i>
                        ADD TO BASKET
                    </button>
                    <button type="submit" form="wishlistForm" class="btn btn-secondary">
                        <i class="fa-regular fa-heart"></i>
                        Add to Wishlist
                    </button>
                </div>
            @endif
        </div>

        <div class="product-details">
            <div class="tabs">
                <button class="tab active" onclick="openTab('description')">Description</button>
                <button class="tab" onclick="openTab('specifications')">Specifications</button>
                <button class="tab" onclick="openTab('reviews')">
                    Reviews ({{ isset($product['reviews']) ? count($product['reviews']) : 0 }})
                </button>
            </div>

            <div id="description" class="tab-content active">
                <p>{{ $product['description'] }}</p>
            </div>

            <div id="specifications" class="tab-content">
                <table class="specifications-table">
                    <tbody>
                        <tr>
                            <th>SKU</th>
                            <td>{{ $product['sku'] }}</td>
                        </tr>
                        <tr>
                            <th>Price</th>
                            <td>£{{ number_format($product['price'], 2) }}</td>
                        </tr>
                        <tr>
                            <th>Availability</th>
                            <td>{{ $product['is_available'] ? 'Available' : 'Not Available' }}</td>
                        </tr>
                        <tr>
                            <th>Stock</th>
                            <td>{{ $product['stock_quantity'] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div id="reviews" class="tab-content">
                @if(isset($product['reviews']) && count($product['reviews']) > 0)
                    @foreach($product['reviews'] as $review)
                        <div class="review-item" style="border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 15px;">
                            <strong>{{ $review['user']['name'] ?? 'Anonymous' }}</strong>
                            <div style="color: #ffb829; font-size: 14px; margin-bottom: 5px;">
                                @for($i=0; $i<$review['rating']; $i++) <i class="fa-solid fa-star"></i> @endfor
                            </div>
                            <p style="margin: 0; color: #555;">{{ $review['text'] }}</p>
                        </div>
                    @endforeach
                @else
                    <p>No reviews yet. Be the first to review!</p>
                @endif
                
                <hr style="margin: 30px 0; border-top: 1px solid #e5e7eb;">
                
                @auth
                    <div class="add-review-form">
                        <h3 style="margin-top: 0; font-size: 18px;">Write a Review</h3>
                        <form action="{{ route('product.review', ['id' => $product['id']]) }}" method="POST">
                            @csrf
                            <div style="margin-bottom: 15px;">
                                <label for="rating" style="display: block; font-weight: 600; margin-bottom: 5px;">Rating (1-5) *</label>
                                <select name="rating" id="rating" required style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #e5e7eb; outline: none; transition: border-color 0.2s;">
                                    <option value="5">5 - Excellent</option>
                                    <option value="4">4 - Very Good</option>
                                    <option value="3">3 - Average</option>
                                    <option value="2">2 - Fair</option>
                                    <option value="1">1 - Poor</option>
                                </select>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <label for="review_text" style="display: block; font-weight: 600; margin-bottom: 5px;">Your Review *</label>
                                <textarea name="review_text" id="review_text" rows="4" required style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #e5e7eb; resize: vertical; box-sizing: border-box; outline: none; transition: border-color 0.2s;"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary" style="padding: 10px 20px;">Submit Review</button>
                        </form>
                    </div>
                @else
                    <p>Please <a href="{{ route('login') }}" style="color: #F57C00; font-weight: bold; text-decoration: underline;">Log in</a> to write a review.</p>
                @endauth
            </div>
        </div>

        <div id="viewerModal" class="viewer-modal">
            <div class="viewer-content">
                <button class="close-viewer" onclick="close3DViewer()">×</button>

                @php
                    $modelUrl = '';
                    if (isset($product['media'])) {
                        foreach ($product['media'] as $media) {
                            if ($media['type'] === '3D_MODEL') {
                                $modelUrl = asset($media['url']);
                                break;
                            }
                        }
                    }
                @endphp

                @if($modelUrl)
                    <model-viewer src="{{ $modelUrl }}" auto-rotate camera-controls></model-viewer>
                @else
                    <p>3D model not available.</p>
                @endif
            </div>
        </div>

        

        <script src="{{ asset('js/product.js') }}"></script>
    </div>
<!--Suggest products either random or based on user preferences-->
        @if (isset($advertisedProducts) || isset($backupProducts))
            <div class="SuggestedProductContainer">
                <h2 id="SuggestedProductTitle">Suggested Products</h2>
                <div class="SuggestedProducts">
                    <!--Check if advertisedProducts is not null and is an array with at least 1 item and that the user is logged in-->
                    @if (isset($advertisedProducts) && is_array($advertisedProducts) && count($advertisedProducts) > 0 && Auth::check())
                        @foreach($advertisedProducts as $advertisedProduct)
                            <!--Ensure that the product being suggested is not the same as the product shown-->
                            @if ($advertisedProduct['id'] != $product['id'])
                                <div class="SuggestedProduct">
                                    @if(isset($advertisedProduct['media']) && count($advertisedProduct['media']) > 0)
                                        <a href="{{ route('product.show', ['id' => $advertisedProduct['id']]) }}">
                                            <img id="SuggestedProductImage" src="{{ asset($advertisedProduct['media'][0]['url']) }}"
                                                alt="{{ $advertisedProduct['name'] }}">
                                        </a>
                                    @else
                                        <a href="{{ route('product.show', ['id' => $advertisedProduct['id']]) }}">
                                            <img id="SuggestedProductImage" src="{{ asset('images/homeDomeLogo.png') }}"
                                                alt="{{ $advertisedProduct['name'] }}" />
                                        </a>
                                    @endif
                                    <p id="SuggestedProductName">{{ $advertisedProduct['name'] }}</p>
                                    <span class="price">£{{ number_format($advertisedProduct['price'], 2) }}</span>
                                </div>
                            @endif
                        @endforeach
                        <!--Check if backupProducts is not null and is an array with at least 1 item-->
                        <!--No need to consider authentication considering that backup products does not weight on the users previous orders-->
                    @elseif (isset($backupProducts) && is_array($backupProducts) && count($backupProducts) > 0)
                        @foreach($backupProducts as $backupProduct)
                            <!--Ensure that the product being suggested is not the same as the product shown-->
                            @if ($backupProduct['id'] != $product['id'])
                                <div class="SuggestedProduct">
                                    @if(isset($backupProduct['media']) && count($backupProduct['media']) > 0)
                                        <a href="{{ route('product.show', ['id' => $backupProduct['id']]) }}">
                                            <img id="SuggestedProductImage" src="{{ asset($backupProduct['media'][0]['url']) }}"
                                                alt="{{ $backupProduct['name'] }}">
                                        </a>
                                    @else
                                        <a href="{{ route('product.show', ['id' => $backupProduct['id']]) }}">
                                            <img id="SuggestedProductImage" src="{{ asset('images/homeDomeLogo.png') }}"
                                                alt="{{ $backupProduct['name'] }}" />
                                        </a>
                                    @endif
                                    <p id="SuggestedProductName">{{ $backupProduct['name'] }}</p>
                                    <span class="price">£{{ number_format($backupProduct['price'], 2) }}</span>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        @endif
@endsection