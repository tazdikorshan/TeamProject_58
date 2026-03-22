@extends('layouts.app')

@section('title', 'Returns Policy')

@section('content')

<style>
    .return-box {
  max-width: 1000px;
      margin: 20px auto;
      padding: 40px 30px;
      background: #ffffff;
      border-radius: 20px;
      box-shadow: 0px 8px 30px rgba(0, 0, 0, 0.546);
      text-align: left;
}

h1 {
 font-size: 40px;
margin-bottom: 20px;
color: var(--hd-orange);
font-weight: 800;
}

h2 {
margin-top: 30px;
    font-size: 20px;
    color: var(--hd-dark-red);
    font-weight: 700;
}

p {
margin: 3px;
      color: black;
      font-size: 15px;
}

ul {
      margin: 20px;
}
</style>

<div class="return-box">

<h1>Return Policy</h1>
<p>
At HomeDome, we want you to be completely satisfied with your purchase. If you're not happy with your order, you may return it in accordance with the policy below.
</p>

<h2>1. Return Period</h2>
<p>
You may request a return within <strong>30 days</strong> of receiving your order. After this period, we may not be able to accept returns.
</p>

<h2>2. Conditions for Returns</h2>
<p>To be eligible for a return, the item must:</p>
<ul>
<li>Be unused and in its original condition</li>
<li>Be returned in the original packaging</li>
<li>Include all accessories, manuals, and parts</li>
<li>Not be damaged after delivery</li>
</ul>

<h2>3. Non-Returnable Items</h2>
<p>The following items cannot be returned:</p>
<ul>
<li>Items that have been assembled or used</li>
<li>Custom-made or personalised products</li>
<li>Items damaged due to misuse</li>
<li>Clearance or final sale items</li>
</ul>

<h2>4. How to Request a Return</h2>
<p>
To request a return, please contact our support team and include your order number and reason for the return. Once approved, we will provide instructions on how to send the item back.
</p>

<h2>5. Refunds</h2>
<p>
Once we receive and inspect your returned item, we will notify you of the outcome. If approved, your refund will be processed to your original payment method within a few working days.
</p>

<h2>6. Return Shipping</h2>
<p>
Customers are responsible for return shipping costs unless the item is faulty, damaged, or incorrect.
</p>

<h2>7. Damaged or Incorrect Items</h2>
<p>
If you receive a damaged or incorrect item, please contact us within 48 hours of delivery. We will arrange a replacement or refund as quickly as possible.
</p>

<h2>8. Contact Us</h2>
<p>
If you have any questions about our return policy, please contact us at:
</p>

<p><strong>Email:</strong> homedomequeries@gmail.com</p>

</div>

@endsection