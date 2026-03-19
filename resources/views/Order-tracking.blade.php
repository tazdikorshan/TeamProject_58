@extends('layouts.app')

@section('title', 'Order Tracking')

@section('content')

<style>
.status-box {
      width: 80%;
      margin: 100px auto;
      background:white;
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.457);
    }

    h1 {
      text-align: center;
      font-size: 40px;
      font-weight: 800;
      margin-bottom: 10px;
      color:var(--hd-dark-red);
    }

    .subheading {
      text-align: center;
      color: var(--hd-orange);
      font-size: 15px;
      font-weight: 300;
      margin-bottom: 30px;
    }

    .order-status {
      text-align: center;
      margin-bottom: 30px;
      color: black;
    }

    .order-status strong {
      color:var(--hd-orange);
    }
 .timeline {
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

     .checkpoint {
      width: 30px;
      height: 30px;
      border-radius: 30px;
      background:white;
      border: 4px solid lightgrey;
      margin: auto;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 14px;
    }

    .completed .checkpoint {
      background: var(--hd-orange);
      border-color: var(--hd-orange);
      color: white;
    }

    .active .checkpoint {
      border-color: var(--hd-orange);
      color: var(--hd-orange);
    }
    .line {
      flex: 1;
      height: 4px;
      background: lightgrey;
    }

    .line.completed {
      background: var(--hd-orange);
    }

    .null p {
      font-size: 12px;
      font-weight: 300;
      color: black;
    }
  </style>
<body>

  <div class="status-box">
    <h1>ORDER TRACKING</h1>
    <div class="subheading">Please note delivery dates are estimates and may change.</div>

    <div class="order-status">
      Order Status: <strong>Shipped</strong><br>
      Estimated Arrival: 3–7 business days
    </div>

    <div class="timeline">
        <div class="completed">
        <div class="checkpoint">✔ </div>
        <p>Order Placed</p>
      </div>

      <div class="line completed"></div>

      <div class="completed">
        <div class="checkpoint">✔ </div>
        <p>Processing</p>
      </div>

      <div class="line completed"></div>

      <div class="active">
        <div class="checkpoint">🚚</div>
        <p>Shipped</p>
        </div>

      <div class="line"></div>

      <div class="null">
        <div class="checkpoint">📦</div>
        <p>Out for Delivery</p>
      </div>

      <div class="line"></div>

      <div class="null">
        <div class="checkpoint">🏡</div>
        <p>Delivered</p>
      </div>

    </div>
    </div>

</body>