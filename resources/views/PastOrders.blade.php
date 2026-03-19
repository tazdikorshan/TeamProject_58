<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
        <style>
        :root {
            --hd-orange: #F57C00;       
            --hd-orange-brown: #E67E22; 
            --hd-dark-red: #B03A2E;      
            --hd-black: #000000;
            --hd-grey: #333333;
            --hd-text-muted: #6b7280; }

        * { box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; }

        body { min-height: 100vh;
           background: #ffffff;
           display: block;
           margin: 0; }

        .header { width: 100%;
           height: 100%;
           margin: 0;
           border: none;
           border-radius: 0;
           box-shadow: none; }

        .top-bar { background: var(--hd-orange);
            padding: 12px 24px;
            display: flex;
            align-items: center;
            gap: 16px; }

        .top-logo { display: flex;
            align-items: center;
            gap: 8px; }

        .top-logo img { width: 44px;
            height: 44px;
            border-radius: 8px;
            border: 2px solid #ffffff; }

        .top-logo-text { font-weight: 800;
            font-size: 20px;
            color: #ffffff; }

        .top-search { flex: 1;
            display: flex;
            justify-content: center; }

        .top-search-input { width: 100%;
            max-width: 600px;
            border-radius: 999px;
            border: none;
            padding: 8px 14px;
            font-size: 14px; }

        .top-search-button { margin-left: 8px;
            padding: 8px 16px;
            border-radius: 999px;
            border: none;
            background: var(--hd-dark-red);
            color: white;
            font-size: 14px;
            cursor: pointer; }

        .top-icons { display: flex;
            gap: 28px;
            align-items: center; }

        .icon-item { display: flex;
            flex-direction: column;
            align-items: center;
            color: #ffffff;
            text-decoration: none;
            font-size: 12px;
            font-weight: 500;
            position: relative;}

        .icon-item i { font-size: 20px;
            margin-bottom: 4px; }

        .icon-item:hover { opacity: 0.8; }

        .icon-badge { position: absolute;
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
            box-shadow: 0 0 4px rgba(0,0,0,0.25); }

        .icon-badge.wishlist { background: #ffffff;
            color: #B03A2E; }

        .icon-badge.basket { background: #ffffff;
            color: #B03A2E; }

        .category-bar { background: var(--hd-orange-brown);
            color: #ffffff;
            font-size: 13px;
            padding: 8px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center; }
    
        .category-bar a { color: #ffffff;
            text-decoration: none;
            font-weight: 500;
            white-space: nowrap; }

        .category-bar a:hover { text-decoration: underline;}

        .content {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
        }
        .title {
            font-size: 35px;
            font-weight: 700;
            color: brown;
            margin-bottom: 5px;
        }

        .subheading {
            color: rgb(66, 59, 59);
            margin-bottom: 30px;
            font: 25px;
        }
        .OrderCard {
            background-color: #e5e1de;
            border-left: 6px solid orange;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.08);
        }
        .order-header {
            display: flex;
            justify-content: space-between;
            border-bottom: 2px solid rgb(255, 255, 255);
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        .OrderNumber {
            font-weight: bolder;
        }
        .status {
            background:orange;
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bolder;
        }
        .status:hover{
            background-color: brown;
        }
         .order-details p, .order-items p {
            margin: 4px 0;
            color: #5c3b1e;
        }
        button{
            background-color: orange;
            border: #e5e1de 2px solid;
            border-radius: 30px;
            color: white;
            padding: 5px;
            font-weight: bold;
            
        }
        .Item {
            display: flex; 
            align-items: center; 
            justify-content: space-evenly; 
        }
        
    </style>
    <link rel="stylesheet" href="{{ asset('css/alert.css') }}">
</head>
<body>
<div class="header">

    <header class="top-bar">
        <div class="top-logo">
            <img src="{{ asset('images/homedome-logo.png') }}" alt="HomeDome logo">
            <span class="top-logo-text">HomeDome</span>
        </div>

        <div class="top-search">
            <input class="top-search-input" type="text" placeholder="Search products...">
            <button class="top-search-button">Search</button>
        </div>

        <div class="top-icons">
            <a href="/login" class="icon-item">
                <i class="fa-solid fa-user"></i>
                <span>Account</span>
            </a>
            <a href="/cart" class="icon-item">
                <i class="fa-solid fa-cart-shopping"></i>
                <span>Basket</span>
            </a>
        </div>

    </header>
    
    <div class="category-bar">
        <a href="/furniture">Furniture</a>
        <a href="/appliances">Appliances</a>
        <a href="/home-decor">Home Decor</a>
        <a href="/kitchen-ware">Kitchen Ware</a>
        <a href="/lighting">Lighting</a>
    </div>
</div>
<!--UI success notifier for when a background process successfully ran-->
@if (session('success'))
    <div class="success">
        {{ session('success') }}
    </div>
@endif

<!--UI error notifier for when a background process has failed-->
@if (session('error'))
    <div class="error">
        {{ session('error') }}
    </div>
@endif
<div class="content">
    <div class="title">My Past Orders</div>
    <div class="subheading">View your past purchases that you've made</div>
    <div class="PurchasedOrderList"></div>

    <!--This card will be the Ordered one-->
    <div class="OrderCard">
        @foreach($orders as $order)
            <div class="order-header">
                    <p class="OrderNumber">Order: {{ $order->id }}</p>
                    <p class="status">Status: {{ $order->status }}</p>
            </div>
            <div class="order-details">
                    <p class="PurchasedDate">Date: {{ $order->order_date }}</p>
                    <p class="Purchasetotal">Total: {{ $order->total_amount }}</p>
                    <p class="Qty">Items: {{ count($order->order_items) }}</p>
            </div>

            <div class="order-items">
                @foreach($order->order_items as $item)
                    <div class="Item"> 
                        @php
                            $media = null; 
                            $mediaList = $item['media'] ?? null; 
                            if ($mediaList instanceof \Illuminate\Support\Collection){
                                $media = $mediaList->first(); 
                            } elseif (is_array($mediaList)) {
                                $media = $mediaList[0] ?? null; 
                            }

                            $mediaUrl = null; 
                            if (is_array($media ?? null)){
                                $mediaUrl = $media['url'] ?? null; 
                            } elseif (is_object($media ?? null)){
                                $mediaUrl = $media->url ?? null; 
                            }
                        @endphp
                        <a href="{{ route('product.show', ['id' => $item['id']]) }}">
                            <img id="SuggestedProductImage" src="{{ $mediaUrl ? asset($mediaUrl) : asset('images/homeDomeLogo.png') }}"
                                alt="{{ $item['name'] }}">
                        </a>
                        
                        <p><b>{{ $item['name'] }}</b></p>
                        <p><b>Quantity:</b> {{ $item['quantity'] }}</p>
                        <p><b>Price:</b> {{ $item['price'] }}</p>

                        <form method="POST" action="{{ route('pastOrders.returnProduct', ['oid' => $order->id, 'pid' => $item['id']]) }}">
                            @csrf
                            <button>Return</button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
</body>
</html>