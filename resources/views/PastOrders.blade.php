@extends('layouts.app')

@section('title', 'Confirmation Page')

@section('content')
<div class="PastOrder-page">
<style>
    .PastOrder-page{
min-height: 70vh;
    }
        .pastOrdercontent {
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
        .Return-button{
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
<div class="pastOrdercontent">
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
                            <button class="Return-button">Return</button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
</div>
@endsection