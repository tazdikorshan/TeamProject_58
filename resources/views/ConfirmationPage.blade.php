@extends('layouts.app')

@section('title', 'Confirmation Page')

@section('content')
<style>
h1{
 color: #E67E22;
 margin-bottom: 20px;
}
p{
    color: #202329;
    margin-bottom: 10px;
}
.ConfirmationCode{
    margin: 20px 0;
    font-size: 20px;
}
#OrderCode{
    margin-top: 5;
    font-size: 25x;
    color: brown;
    letter-spacing: 2px;
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
    <div class="ConfirmationContent">
        <h1>Order Confirmed</h1>
        <p>Your order has been placed successfully</p>
        <p>Thank you for your Purchase, We hope you're satisfied with your products</p>

        <div class="ConfirmationCode">
            <p>Your Order Code:</p>
            <p id="OrderCode"></p>
            <p>Your Order ID:</p>
            <p>{{ $orderID }}</p>
        </div>

        <p id="OrderCodeInfo">Please save this code as it will be needed to track or return your order</p>
    </div>

<script>
function GenerateOrderCode(){
    const letters = '0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
    let code = 'HD-';

    for(let i = 0; i < 8; i++){
        code += letters.charAt(Math.floor(Math.random() * letters.length));
    }
    return code;
}
    document.getElementById("OrderCode").textContent = GenerateOrderCode();

</script>

</body>
</html>
@endsection