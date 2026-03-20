@extends('layouts.app')

@section('title', 'Track Order')

@section('content')

<style>
.track-box {
    width: 50%;
    margin: 100px auto;
    background: white;
    padding: 50px;
    border: 5px solid var(--hd-dark-red);
    border-radius: 20px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.489);
    text-align: center;
}

h1 {
    margin-bottom: 10px;
    color: var(--hd-dark-red);
    font-weight: 1000;
}

p {
    color: var(--hd-orange);
    margin-bottom: 25px;
    font-weight: 700;
}

.input {
    width: 100%;
    padding: 10px;
    border-radius: 10px;
    border: 2px solid brown;
    margin-bottom: 20px;
    font-size: 14px;
}

.track-button {
    width: 200px;
    padding: 10px;
    border: none;
    border-radius: 10px;
    background: var(--hd-dark-red);
    color: white;
    font-size: 20px;
    font-weight: 700;
    cursor: pointer;
}

.track-button:hover {
    color: #000000;
}
</style>
<body>
    <div class="track-box">
        <h1>Track Your Order</h1>
        <p>Enter your order ID below to check the status of your delivery.</p>
        
    <input class="input" type="text" id="orderID" placeholder="orderID">
    <button class="track-button">Track Order</button>
</body>
<script>
    const Button = document.querySelector(".track-button");

Button.addEventListener("click", function () {

    const orderID = document.getElementById("orderID").value.trim();

    if (orderID === "") {
        alert("Please enter your Order ID, if your experiencing any issues please contact us.");
        return;
    }
    if (!orderID.startsWith("HD-")) {
        alert("Invalid Order ID format.  Please enter the right orderID, if your experiencing any issues please contact us.");
        return;
    }
    if (orderID.length > 11) {
        alert("Order ID cannot exceed 11 characters. Please enter the right orderID, if your experiencing any issues please contact us.");
        return;
    }
    window.location.href = "{{ route('Order-tracking') }}";
  });
</script>