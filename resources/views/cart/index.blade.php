@extends('layouts.app')

@section('title', 'Your Cart')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
@endpush

@section('content')
<div class="container">
    <div class="cart-wrapper">
        @if((Auth::check() && count($cartItems) > 0) || (!Auth::check() && session('has_cart_items', true)))
            <div class="cart-container">
                @if(Auth::check())
                    @foreach($cartItems as $item)
                        <div class="cart-item" data-id="{{ $item->product_id }}" data-price="{{ $item->product->price }}">
                            @php
                                $images = json_decode($item->product->images, true);
                                $firstImage = is_array($images) && count($images) > 0 ? $images[0] : 'default.webp';
                            @endphp
                            <img src="{{ asset('pictures/' . $firstImage) }}" alt="{{ $item->product->name }}" class="item-image">
                            <div class="item-name">{{ $item->product->name }}</div>
                            <div class="quantity-control">
                                <button class="quantity-btn minus">-</button>
                                <input type="text" value="{{ $item->quantity }}" class="quantity-input" min="1">
                                <button class="quantity-btn plus">+</button>
                            </div>
                            <span class="item-price">${{ number_format($item->product->price, 2) }}</span>
                            <button class="remove-item">&times;</button>
                        </div>
                    @endforeach
                @else
                    <!-- Client-rendered items for guests -->
                    <div id="cart-items-container">
                    </div>
                @endif
            </div>
            <div class="cart-footer">
                <button onclick="window.location.href='{{ route('home') }}'" class="btn">Back to Shopping</button>
                <span>Total: $<span id="cart-total">0.00</span></span>
                <button onclick="window.location.href='{{ route('delivery') }}'" class="btn" id="proceed-to-payment">Proceed to Payment</button>
            </div>
        @else
            <!-- Empty cart view -->
            <div class="empty-cart-container">
                <div class="empty-cart">
                    <i class="bi bi-cart-x empty-cart-icon"></i>
                    <h3>Your cart is empty</h3>
                    <p>Looks like you haven't added any games to your cart yet.</p>
                </div>
                <div class="cart-footer">
                    <button onclick="window.location.href='{{ route('home') }}'" class="btn">Back to Shopping</button>
                    <span>Total: $<span id="cart-total">0.00</span></span>
                    <button onclick="window.location.href='{{ route('delivery') }}'" class="btn" id="proceed-to-payment">Proceed to Payment</button>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/cart.js') }}"></script>
@endpush