@extends('layouts.app')

@section('title', 'User Profile')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endpush

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <i class="bi bi-person-circle" style="font-size: 100px;"></i>
                    <h5 class="mt-3">{{ $user->full_name }}</h5>
                    <p class="text-muted">{{ $user->email }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <h3>Account Information</h3>
            <ul class="list-group">
                <li class="list-group-item"><strong>Username:</strong> {{ $user->username }}</li>
                <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
                <li class="list-group-item"><strong>Member Since:</strong> {{ $user->created_at->format('M d, Y') }}</li>
            </ul>

            <h3 class="mt-4">Order History</h3>
            <table class="table">
                <thead class="orders">
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody class="orders">
                    @foreach($user->orders as $order)
                    <tr>
                        <td>#{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $order->created_at->format('F d, Y') }}</td>
                        <td>{{ ucfirst($order->order_status) }}</td>
                        <td>
                            ${{ number_format(
                                $order->products->sum(function ($product) {
                                    return $product->pivot->price * $product->pivot->quantity;
                                }), 2) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
