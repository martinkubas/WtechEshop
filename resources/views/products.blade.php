@extends('layouts.app')

@section('title', 'Products')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
@endpush

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="text-center mb-3">
            <button class="filter-button btn" data-bs-toggle="offcanvas" data-bs-target="#filtersMenu">
                <i class="bi bi-sliders2"></i> Filters & Sorting
            </button>
        </div>

        <section class="col-12">
            <div class="row g-4">
                @foreach($products as $product)
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                        <div class="card product-card">
                            @php
                                $images = json_decode($product->images, true);
                                $images = array_map(function($image) {
                                    return str_replace(['\\', '\/'], '/', $image); 
                                }, $images);
                            @endphp
                            <a href="{{ url('product/' . $product->id) }}" class="product-link">
                                <div class="product-image">
                                    <img src="{{ asset('pictures/' . $images[0]) }}" class="card-img-top" alt="{{ $product->name }}">
                                </div>
                            </a>
                            <div class="card-body text-center">
                                <h6 class="fw-bold">
                                    <a href="{{ url('product/' . $product->id) }}" class="product-link product-title">
                                        {{ $product->name }}
                                    </a>
                                </h6>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="price-tag">${{ number_format($product->price, 2) }}</span>
                                    <button class="btn btn-sm">
                                        <i class="bi bi-basket2-fill" style="font-size: 24px;"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
</div>

@if ($products->hasPages())
    <ul class="pagination d-flex justify-content-center mt-4">
        @if ($products->onFirstPage())
            <li class="page-item disabled mx-1"><span class="page-link">&laquo;</span></li>
        @else
            <li class="page-item mx-1">
                <a class="page-link" href="{{ $products->previousPageUrl() }}&{{ http_build_query(request()->except('page')) }}" rel="prev">&laquo;</a>
            </li>
        @endif

        @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
            <li class="page-item mx-1 {{ $page == $products->currentPage() ? 'active' : '' }}">
                <a class="page-link" href="{{ $url }}&{{ http_build_query(request()->except('page')) }}">{{ $page }}</a>
            </li>
        @endforeach

        @if ($products->hasMorePages())
            <li class="page-item mx-1">
                <a class="page-link" href="{{ $products->nextPageUrl() }}&{{ http_build_query(request()->except('page')) }}" rel="next">&raquo;</a>
            </li>
        @else
            <li class="page-item disabled mx-1"><span class="page-link">&raquo;</span></li>
        @endif
    </ul>
@endif

<!-- Filters Menu -->
<div class="offcanvas offcanvas-start" id="filtersMenu">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Filters & Sorting</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <form action="{{ route('products') }}" method="GET">

        <div class="offcanvas-body">
            <div class="order-grid">
                <a href="{{ route('products', array_merge(request()->query(), ['sort' => 'recommended'])) }}" class="btn btn-light btn-sm">Recommended</a>
                <a href="{{ route('products', array_merge(request()->query(), ['sort' => 'best_selling'])) }}" class="btn btn-light btn-sm">Best Selling</a>
                <a href="{{ route('products', array_merge(request()->query(), ['sort' => 'lowest_price'])) }}" class="btn btn-light btn-sm">Lowest Price</a>
                <a href="{{ route('products', array_merge(request()->query(), ['sort' => 'highest_price'])) }}" class="btn btn-light btn-sm">Highest Price</a>
            </div>

            <h5 class="mt-3">Price</h5>
            <div class="d-flex gap-2">
                <input type="number" class="form-control" name="min_price" placeholder="Min" value="{{ request('min_price') }}">
                <input type="number" class="form-control" name="max_price" placeholder="Max" value="{{ request('max_price') }}">
            </div>

            <h5 class="mt-3">Date of release</h5>
            <select class="form-select" name="release_year">
                <option value="">Select year</option>
                @foreach(range(2020, date('Y')) as $year)
                    <option value="{{ $year }}" {{ request('release_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endforeach
            </select>

            <h5 class="mt-3">Platform</h5>
            <label><input type="checkbox" name="platforms[]" value="PC" {{ in_array('PC', request('platforms', [])) ? 'checked' : '' }}> PC</label><br>
            <label><input type="checkbox" name="platforms[]" value="Playstation" {{ in_array('Playstation', request('platforms', [])) ? 'checked' : '' }}> PlayStation</label><br>
            <label><input type="checkbox" name="platforms[]" value="Xbox" {{ in_array('Xbox', request('platforms', [])) ? 'checked' : '' }}> Xbox</label><br>

            <h5 class="mt-3">Genre</h5>
            <label><input type="checkbox" name="genres[]" value="Action" {{ in_array('Action', request('genres', [])) ? 'checked' : '' }}> Action</label><br>
            <label><input type="checkbox" name="genres[]" value="Adventure" {{ in_array('Adventure', request('genres', [])) ? 'checked' : '' }}> Adventure</label><br>
            <label><input type="checkbox" name="genres[]" value="Sports" {{ in_array('Sports', request('genres', [])) ? 'checked' : '' }}> Sports</label><br>

            <div id="more-genres" style="display: none;">
                <label><input type="checkbox" name="genres[]" value="RPG" {{ in_array('RPG', request('genres', [])) ? 'checked' : '' }}> RPG</label><br>
                <label><input type="checkbox" name="genres[]" value="Racing" {{ in_array('Racing', request('genres', [])) ? 'checked' : '' }}> Racing</label><br>
                <label><input type="checkbox" name="genres[]" value="Horror" {{ in_array('Horror', request('genres', [])) ? 'checked' : '' }}> Horror</label><br>
                <label><input type="checkbox" name="genres[]" value="Puzzle" {{ in_array('Puzzle', request('genres', [])) ? 'checked' : '' }}> Puzzle</label><br>
                <label><input type="checkbox" name="genres[]" value="Strategy" {{ in_array('Strategy', request('genres', [])) ? 'checked' : '' }}> Strategy</label><br>
                <label><input type="checkbox" name="genres[]" value="Fighting" {{ in_array('Fighting', request('genres', [])) ? 'checked' : '' }}> Fighting</label><br>
            </div>

            <a href="#" class="text-danger" id="see-more">See more...</a>
            
            <button type="submit" class="btn btn-primary mt-4 submit-button">Apply Filters</button>
            
            
        </div>
    </form>
</div>
@endsection

@push('scripts')
    @vite('resources/js/products.js')
@endpush