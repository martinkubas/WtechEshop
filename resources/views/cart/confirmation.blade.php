@extends('layouts.app')

@section('title', 'Order Confirmation')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/confirmation.css') }}">
@endpush

@section('content')
<div class="container">
    <div class="confirmation-container">
        <div class="confirmation-header">
            <i class="bi bi-check-circle-fill"></i>
            <h1>Order Confirmed!</h1>
            <p>Your order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }} has been received.</p>
        </div>

        <div class="confirmation-details">
            <h3>Order Details</h3>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Order Date:</strong> {{ $order->created_at->format('F d, Y H:i') }}</p>
                    <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
                    <p><strong>Order Status:</strong> {{ ucfirst($order->order_status) }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Delivery Method:</strong> {{ $order->delivery_method }}</p>
                    <p><strong>Delivery Status:</strong> {{ $order->delivery_status }}</p>
                    @if($order->delivery_address)
                        <p><strong>Delivery Address:</strong> {{ $order->delivery_address }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="order-summary">
            <h3>Order Summary</h3>
            <div class="order-items">
                @foreach($order->products as $product)
                    <div class="order-item">
                        <div>
                            <span>{{ $product->name }} x {{ $product->pivot->quantity }}</span>
                        </div>
                        <div>${{ number_format($product->pivot->price * $product->pivot->quantity, 2) }}</div>
                    </div>
                @endforeach
            </div>
            
            <div class="order-totals">
                <div class="order-total-row">
                    <span>Subtotal:</span>
                    <span>
                        ${{ number_format($order->products->sum(function($product) {
                            return $product->pivot->price * $product->pivot->quantity;
                        }), 2) }}
                    </span>
                </div>
                <div class="order-total-row">
                    <span>Shipping:</span>
                    <span>
                        @if($order->delivery_method == 'Pickup')
                            $0.00
                        @elseif($order->delivery_method == 'Courier')
                            $5.00
                        @elseif($order->delivery_method == 'Postal')
                            $3.00
                        @elseif($order->delivery_method == 'GameGoBox')
                            $4.00
                        @else
                            $0.00
                        @endif
                    </span>
                </div>
                <div class="order-total-row total">
                    <span>Total:</span>
                    <span>
                        @php
                            $subtotal = $order->products->sum(function($product) {
                                return $product->pivot->price * $product->pivot->quantity;
                            });
                            
                            $shipping = 0;
                            if($order->delivery_method == 'Courier') $shipping = 5;
                            elseif($order->delivery_method == 'Postal') $shipping = 3;
                            elseif($order->delivery_method == 'GameGoBox') $shipping = 4;
                            
                            $total = $subtotal + $shipping;
                        @endphp
                        ${{ number_format($total, 2) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="confirmation-actions">
            <p>A confirmation email has been sent to your email address.</p>
            <a href="{{ route('home') }}" class="btn btn-continue">Continue Shopping</a>
        </div>
    </div>
</div>
@endsection