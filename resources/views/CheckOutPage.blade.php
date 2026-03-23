<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Checkout Page</title>
<style>
body {
    margin: 0;
    font-family: Arial, Helvetica, sans-serif;
    background: #f5ebe0;
}

header {
    background: #74462e;
    color: #fff;
    padding: 18px 40px;
    font-size: 25px;
    font-weight: bold;
}

.container {
    display: flex;
    gap: 40px;
    padding: 40px;
}

.CheckOutDetails, .ItemsSummary {
    background: #fffaf3;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 5px 10px rgb(0,0,0);
}

.CheckOutDetails {
    flex: 2;
}

.ItemsSummary {
    flex: 1;
    height: fit-content;
}
.section-title {
    font-size: 25px;
    font-weight: bolder;
    margin-bottom: 20px;
    color: #804729;    
}

.product {
    display: flex;
    gap: 20px;
    padding: 15px 0px;
    border-bottom: 1px solid #e5d3c5;
}

.product img {
    width: 90px;
    height: 90px;
    object-fit: cover;
    border-radius: 8px;
}

.product-details {
    flex: 1;
}

.product-name {
    font-weight: bold;
    margin-bottom: 5px;
    color: #3b2a20;
}

.product-price {
    font-weight: bold;
    color: #c26a2e;
}

.form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 15px;
}

#DescriptionTitle {
    margin-bottom: 5px;
    color: #6b3e26;
    font-weight: bold;
}

input {
    padding: 12px;
    border: 1px solid #d6bfa9;
    border-radius: 6px;
    background: #fff;
}
.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    color: #3b2a20;    
}

.summary-row p{
    margin: 0;
}

.total {
    font-weight: bold;
    font-size: 20px;
}

.checkout-btn {
    width: 100%;
    padding: 15px;
    background: #c78355;
    color: white;
    border: none;
    font-size: 16px;
    font-weight: bolder;
    margin-top: 20px;
    border-radius: 8px;
}

.checkout-btn:hover {
    background: #a35421;
}

input:invalid:not(:placeholder-shown) {
  border: 2px solid red;
}
</style>
<link rel="stylesheet" href="{{ asset('css/alert.css') }}">
</head>

<body>
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

<header style="display: flex; justify-content: space-between; align-items: center;">
    <span>CHECKOUT</span>
    <a href="/" style="color: #fff; font-size: 14px; text-decoration: underline;">← Back to Home</a>
</header>


<div class="container">
    

    <div class="CheckOutDetails">
        <div class="PersonalDetails">
        <div class="section-title">Delivery Details</div>
            <form id = "deliveryForm" method = "post" action = "{{ route('checkout.submit', ['id' => $orderInformation->orderID]) }}">
                @csrf
                <div class="form-group">
                    <p id="DescriptionTitle">Full Name</p>
                    <input name="name" pattern="[A-Za-z\s]+" required placeholder="Enter your full name" id="name" type="text">
                </div>

                <div class="form-group">
                    <p id="DescriptionTitle">Email</p>
                    <input name="email" id="email" type="email" required placeholder="Enter in your email address">
                 </div>

                <div class="form-group">
                    <p id="DescriptionTitle">Phone Number</p>
                    <input name="phoneNumber" id="phoneNumber" type="tel" placeholder="Optional" inputmode="numeric" minlength="11">
                </div>

                <div class="form-group">
                    <p id="DescriptionTitle">Street</p>
                    <input name="street" id="street" type="text" required placeholder="Enter in your Street">
                </div>

                <div class="form-group">
                    <p id="DescriptionTitle">City</p>
                    <input name="city" id="city" type="text" required placeholder="Enter in your City">
                </div>

                <div class="form-group">
                    <p id="DescriptionTitle">Post Code</p>
                    <input name="postcode" id="postcode" type="text" required placeholder="Enter in your Postcode">
                </div>

                <!--Dummy payout form-->
                <div class="PaymentInformation">
                    <div class="section-title">PaymentType</div>

                    <div class="form-group">
                        <p id="DescriptionTitle">Card Holder Name</p>
                        <input name="CHName" type="text" required pattern="[A-Za-z\s]+" placeholder="Enter in the name of the Card Holder" id="CHName">
                    </div>

                    <div class="form-group">
                        <p id="DescriptionTitle">Card Number</p>
                        <input name="CardNum" type="text" required pattern="[0-9]{16,19}" maxlength="19" placeholder="Enter in your cards number" id="CardNum">
                    </div>

                    <div class="form-group">
                        <p id="DescriptionTitle">Expiry Date</p>
                        <input name="ExpDate" type="text" required pattern="(0[1-9]|1[0-2])\/[0-9]{2}" placeholder="Enter expiry as MM/YY" id="ExpDate">
                    </div>

                    <div class="form-group">
                        <p id="DescriptionTitle">CVV</p>
                        <input name="CVV" type="text" required pattern="[0-9]{3,4}" maxlength="4" placeholder="Enter the CVV" id="CVV">
                    </div>
                </div>

                <button class="checkout-btn">Submit Order</button>
            </form>
        </div>
    </div>

    <div class="ItemsSummary">
        <div class="section-title">Your Bag</div>
            @if ($orderedProducts->isEmpty())
                <p>Bag is empty</p>
            @else 
                @foreach($orderedProducts as $product)
                    <div class="product">
                        @if(isset($product['media']) && count($product['media']) > 0)
                            <img src="{{ asset($product['media'][0]['url']) }}">
                        @endif 
                        <div class="product-details">
                            <div class="product-name">{{ $product['name'] }}</div>
                            <div>Quantity: {{ $product['quantity'] }}</div>
                            <div class="product-price">{{ $product['price'] }}</div>
                        </div>
                    </div>
                @endforeach
            @endif


        <div class="summary-row">
            <p>Subtotal</p>
            <p>{{ $orderInformation->subtotal }}</p>
        </div>

        <div class="summary-row">
            <p>Delivery</p>
            <p>£3.99</p>
        </div>

        <div class="summary-row total">
            <p>Total</p>
            <p>£{{ $orderInformation->subtotal + 3.99 }}</p>
        </div>
    </div>
</div>
</body>
</html>
