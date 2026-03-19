@extends('layouts.app')

@section('title', 'Shipping Options')

@section('content')

<style>
        .Shipping {
      max-width: 1100px;
      margin: auto;
      padding: 40px 20px;
      text-align: center;
    }

    h1 {
      font-size: 50px;
      margin-bottom: 10px;
      color: var(--hd-dark-red);
    }

    .subheading {
      color: var(--hd-orange);
      margin-bottom: 40px;
      font-weight: 600;
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 25px;
    }

    .card {
      background: #fff;
      border: 4px solid brown;
      border-radius: 16px;
      padding: 25px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.582);
  transition: transform .25s ease;
    }
    .card:hover {
  transform: translateY(-6px);
    }
    .option {
      font-size: 25px;
      font-weight: bold;
      margin-bottom: 5px;
    }

    .waiting-time {
      color: #5e5e5e;
    }

    .description {
      font-size: 15px;
      margin-bottom: 20px;
      min-height: 70px;
    }

    .price {
    font-size: 25px;
      font-weight: 700;
      margin-bottom: 15px;
    }
</style>
<body>
    <div class="Shipping">
    <h1>HomeDome Shipping Options</h1>
    <p class="subheading">Choose the delivery option that works best for your home.</p>

    <div class="grid">
      <div class="card">
        <div class="option">Standard Delivery</div>
        <div class="waiting-time">3–7 business days</div>
        <div class="description">
          Affordable delivery to your doorstep. Items arrive flat-packed and ready for self-assembly.
        </div>
        <div class="price">£3.99</div>
      </div>

      <div class="card">
        <div class="option">Click & Collect</div>
        <div class="waiting-time">Ready in 1–3 days</div>
        <div class="description">
          Order online and pick up your items at your nearest HomeDome store within opening times.
        </div>
        <div class="price">Free</div>
      </div>

      <div class="card">
        <div class="option">Reserve in Store</div>
        <div class="waiting-time">Same-day availability</div>
        <div class="description">
          Reserve your items online and visit a HomeDome store to view and collect them in person.
        </div>
        <div class="price">Free</div>
      </div>
    </div>

</body>

@endsection