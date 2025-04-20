@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
@endpush

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-6 order-lg-1 order-2">
            <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                @php
                    $images = json_decode($product->images, true);
                    $images = array_map(function($image) {
                        return str_replace(['\\', '\/'], '/', $image);
                    }, $images);
                @endphp
                <div class="carousel-inner">
                @foreach ($images as $index => $image)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <img src="{{ asset('pictures/' . $image) }}" class="d-block w-100 prod-image" alt="{{ $product->name }}">
                    </div>
                @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

            <div class="specifications mt-3 w-100">
                <h4>Specifications</h4>
                <ul>
                    <li><strong>Platform:</strong> 
                        @foreach(json_decode($product->platforms) as $platform)
                            {{ $platform }}
                            @if(!$loop->last){{ ', ' }}@endif
                        @endforeach
                    </li>
                    
                    <li><strong>Genre:</strong> 
                        @foreach(json_decode($product->genres) as $genre)
                            {{ $genre }}
                            @if(!$loop->last){{ ', ' }}@endif
                        @endforeach
                    </li>

                    <li><strong>Release Date:</strong> {{ $product->release_year }}</li>
                </ul>
            </div>
        </div>

        <div class="col-lg-6 order-lg-2 order-1">
            <h1 class="fw-bold">{{ $product->name }}</h1>
            <p class="price-text">${{ $product->price }}</p>

            <button class="btn mb-3">
                <i class="bi bi-basket2-fill text-white" style="font-size: 16px;"></i>
                Add to Cart
            </button>
            <button class="btn mb-3">
                <i class="bi bi-fast-forward-fill" style="font-size: 16px;"></i>
                Buy Now
            </button>

            <p class="product-description">
                {{ $product->description }}
            </p>
        </div>
    </div>
</div>
@endsection