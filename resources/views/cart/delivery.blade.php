@extends('layouts.app')

@section('title', 'Checkout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/delivery.css') }}">
@endpush

@section('content')
<div class="container mt-4">
    <h1 class="checkout-title">Checkout</h1>
    
    <div class="card mb-5 shadow-sm checkout-container">
        <div class="row">
            <!-- order details -->
            <div class="col-lg-5 order-lg-2 order-1 mb-4">
                <div class="card bg-light h-100 p-3 rounded">
                    <h3 class="section-title">Order Summary</h3>
                    <div class="order-items">
                        @if(Auth::check())
                            @php $total = 0; @endphp
                            @foreach($cartItems as $item)
                                @php 
                                    $images = json_decode($item->product->images, true);
                                    $firstImage = is_array($images) && count($images) > 0 ? $images[0] : 'default.webp';
                                    $subtotal = $item->product->price * $item->quantity;
                                    $total += $subtotal;
                                @endphp
                                <div class="d-flex mb-3 pb-3 border-bottom">
                                    <div class="order-item-image">
                                        <img src="{{ asset('pictures/' . $firstImage) }}" alt="{{ $item->product->name }}">
                                    </div>
                                    <div class="flex-grow-1">
                                        <h4>{{ $item->product->name }}</h4>
                                        <div class="d-flex justify-content-between text-secondary fs-6">
                                            <span>Qty: {{ $item->quantity }}</span>
                                            <span>${{ number_format($item->product->price, 2) }}</span>
                                        </div>
                                        <div class="text-end fw-semibold">
                                            ${{ number_format($subtotal, 2) }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div id="order-items-container">
                            </div>
                        @endif
                    </div>
                    
                    <div class="order-totals">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span>$<span id="order-subtotal">{{ number_format($total ?? 0, 2) }}</span></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping:</span>
                            <span>$<span id="order-shipping">0.00</span></span>
                        </div>
                        <div class="d-flex justify-content-between fw-bold fs-5 pt-2 mt-2 border-top">
                            <span>Total:</span>
                            <span>$<span id="order-total">{{ number_format($total ?? 0, 2) }}</span></span>
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">Modify Cart</a>
                    </div>
                </div>
            </div>
            
            <!-- customer info and payment -->
            <div class="col-lg-7 order-lg-1 order-2">
               <form id="checkout-form" method="POST" action="{{ route('orders.store') }}">
                @csrf
                
                @if(!Auth::check())
                    <input type="hidden" id="cart_data" name="cart_data" value="">
                @endif
                    <div class="card mb-4 bg-white p-3 rounded shadow-sm">
                        <h3 class="section-title">Customer Information</h3>
                        <div class="mb-3">
                            <label for="full_name" class="form-label">Full Name *</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" 
                                value="{{ Auth::check() ? Auth::user()->full_name : '' }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address *</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                value="{{ Auth::check() ? Auth::user()->email : '' }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number *</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>
                    </div>
                    
                    <div class="card mb-4 bg-white p-3 rounded shadow-sm">
                        <h3 class="section-title">Delivery Options</h3>
                        <div class="row row-cols-1 row-cols-md-2 g-3 mb-3">
                            <div class="col">
                                <div class="delivery-option">
                                    <input type="radio" class="form-check-input me-2" id="delivery_courier" name="delivery_method" value="courier" data-price="5">
                                    <label class="form-check-label" for="delivery_courier">
                                        <div class="fw-semibold mb-1">Courier Delivery</div>
                                        <div class="d-flex justify-content-between">
                                            <span class="fst-italic">2-3 business days</span>
                                            <span class="fw-medium">€5.00</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col">
                                <div class="delivery-option">
                                    <input type="radio" class="form-check-input me-2" id="delivery_postal" name="delivery_method" value="postal" data-price="3">
                                    <label class="form-check-label" for="delivery_postal">
                                        <div class="fw-semibold mb-1">Postal Delivery</div>
                                        <div class="d-flex justify-content-between">
                                            <span class="fst-italic">3-5 business days</span>
                                            <span class="fw-medium">€3.00</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col">
                                <div class="delivery-option">
                                    <input type="radio" class="form-check-input me-2" id="delivery_gamegobox" name="delivery_method" value="gamegobox" data-price="4">
                                    <label class="form-check-label" for="delivery_gamegobox">
                                        <div class="fw-semibold mb-1">GameGoBox</div>
                                        <div class="d-flex justify-content-between">
                                            <span class="fst-italic">1-2 business days</span>
                                            <span class="fw-medium">€4.00</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col">
                                <div class="delivery-option">
                                    <input type="radio" class="form-check-input me-2" id="delivery_pickup" name="delivery_method" value="pickup" data-price="0">
                                    <label class="form-check-label" for="delivery_pickup">
                                        <div class="fw-semibold mb-1">Pickup</div>
                                        <div class="d-flex justify-content-between">
                                            <span class="fst-italic">Same day</span>
                                            <span class="fw-medium">Free</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div id="delivery-address-container" class="mt-4">
                            <div class="mb-3">
                                <label for="delivery_address" class="form-label">Delivery Address *</label>
                                <textarea class="form-control" id="delivery_address" name="delivery_address" rows="3" required></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card mb-4 bg-white p-3 rounded shadow-sm">
                        <h3 class="section-title">Payment Method</h3>
                        <div class="d-flex flex-column gap-3">
                            <div class="payment-option">
                                <input type="radio" class="form-check-input me-2" id="payment_card" name="payment_method" value="card">
                                <label class="form-check-label" for="payment_card">
                                    <div class="fw-semibold mb-1">Credit/Debit Card</div>
                                    <div class="d-flex align-items-center gap-1 text-secondary fs-6">
                                        <i class="bi bi-credit-card"></i>
                                        <span>Visa, MasterCard, etc.</span>
                                    </div>
                                </label>
                            </div>
                            
                            <div class="payment-option">
                                <input type="radio" class="form-check-input me-2" id="payment_paypal" name="payment_method" value="paypal">
                                <label class="form-check-label" for="payment_paypal">
                                    <div class="fw-semibold mb-1">PayPal</div>
                                </label>
                            </div>
                            
                            <div class="payment-option">
                                <input type="radio" class="form-check-input me-2" id="payment_cash" name="payment_method" value="cash" data-fee="2">
                                <label class="form-check-label" for="payment_cash">
                                    <div class="fw-semibold mb-1">Cash on Delivery</div>
                                </label>
                            </div>
                        </div>
                        
                        <div id="card-details-container" class="mt-4 d-none">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="card_number" class="form-label">Card Number *</label>
                                    <input type="text" class="form-control" id="card_number" name="card_number" placeholder="1234 5678 9012 3456">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="card_expiry" class="form-label">Expiry Date *</label>
                                    <input type="text" class="form-control" id="card_expiry" name="card_expiry" placeholder="MM/YY">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="card_cvv" class="form-label">CVV *</label>
                                    <input type="text" class="form-control" id="card_cvv" name="card_cvv" placeholder="123">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 text-start ps-3">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="terms" required>
                            <label class="form-check-label" for="terms">
                                I agree to the terms and conditions
                            </label>
                        </div>
                        
                        <button type="submit" class="btn proceed-btn">Complete Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/delivery.js') }}"></script>
@endpush