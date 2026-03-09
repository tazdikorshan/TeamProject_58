@extends('layouts.app')

@section('title', 'FAQs')

@section('content')

<style>
.delivery-header{
display:flex;
justify-content:space-between;
align-items:center;
padding:80px 8%;
background:var(--hd-orange);
flex-wrap:wrap;
border-radius: 30px;
}

.delivery-text{
max-width:500px;
}

.delivery-text h1{
font-size:42px;
margin-bottom:20px;
color:rgb(255, 255, 255);
}

.delivery-text p{
font-size:18px;
line-height:1.6;
color:#ffffff;
}

.delivery-text ul{
margin-top:20px;
padding-left:18px;
color: white;
}

.delivery-text li{
margin-bottom:10px;
font-size:17px;
color: white;
}

.header-button{
margin-top:25px;
background:brown;
color:white;
border:none;
padding:12px 28px;
border-radius:30px;
font-size:16px;
cursor:pointer;
}

.delivery-image img{
width:380px;
}
.delivery-info{
display:flex;
justify-content:space-between;
padding:70px 8%;
background:white;
flex-wrap:wrap;
}

.left-side{
max-width:450px;
}

.left-side h2{
font-size:32px;
margin-bottom:15px;
}

.left-side p{
font-size:17px;
line-height:1.7;
color:#555;
}
.right-side{
display:grid;
grid-template-columns:repeat(2,260px);
gap:20px;
}

.card{
background:#fafafa;
padding:22px;
border-radius:10px;
border: 3px solid brown;
box-shadow:0 4px 12px rgba(0,0,0,0.08);
transition:transform .25s ease;
}

.card:hover{
transform:translateY(-5px);
}

.card h3{
  font-size: 20px;
  color: brown;
  margin-bottom: 8px;
}

.card p{
  font-size: 17px;
  color: black;
  line-height: 1.6;
}
.end {
  width: 90%;
  margin: 60px auto 80px auto;
  padding: 44px;
  text-align: center;
  background:var(--hd-orange);
  color: white;
  border-radius: 16px;
  box-shadow: 0 12px 30px rgba(0,0,0,0.08);
}
.end h2 {
  font-size: 34px;
  margin-bottom: 8px;
  font-weight: 900;
}
.end p {
  font-size: 18px;
  margin-bottom: 18px;
  color: white;
}
.end-button {

  background:white;
  color: brown;
  padding: 12px 26px;
  font-size: 16px;
  border-radius: 999px;
  border: none;
  cursor: pointer;
  transition: 0.3s ease;
}
.end-button:hover {
  transform: translateY(-3px);
}
.end h2{
color: white;
}
</style>
<section class="delivery-header">
<div class="delivery-text">
<h1>Fast & Reliable Delivery</h1>
<p>
At HomeDome, we ensure your furniture and appliances arrive quickly and safely.
Our delivery team works carefully to provide a smooth experience from checkout to your doorstep.
</p>
<ul>
<li>Easy order tracking</li>
<li>Nationwide delivery coverage</li>
<li>Dedicated customer support</li>
</ul>
<a href="/"><button class="header-button">Start Shopping</button></a>
</div>
<div class="delivery-image">
<img src="truck outline picture.png" alt="Delivery scooter">
</div>
</section>
<section class="delivery-info">
<div class="left-side">
<h2>Go global with ease</h2>
<p>
We simplify deliveries so your HomeDome purchases arrive on time.
Our logistics network ensures fast processing, secure packaging,
and reliable shipping to homes across the country.
</p>
</div>
<div class="right-side">
<div class="card">
<h3>Fast Processing</h3>
<p>Orders are processed within 24–48 hours after confirmation.</p>
</div>
<div class="card">
<h3>Secure Packaging</h3>
<p>Every product is carefully packaged to prevent damage.</p>
</div>
<div class="card">
<h3>Order Tracking</h3>
<p>Track your order easily through your account dashboard.</p>
</div>
<div class="card">
<h3>Customer Support</h3>
<p>Our team is always ready to assist with delivery questions.</p>
</div>
</div>
</section>
<section class="end">
<h2>Let’s Build Your Dream Home Together!</h2>
<p>
Explore our collections, visit our showroom, or reach out to our friendly team we’re here to guide you every step of the way. Your perfect home starts with the right pieces, and we can’t wait to help you bring it to life.
</p>
<a href='/'><button class="end-button">Shop Now</button></a>
</section>