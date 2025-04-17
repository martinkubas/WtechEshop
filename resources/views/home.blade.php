@extends('layouts.app')

@section('title', 'Home - GameGo')

@section('content')
    <div id="gameCarousel" class="carousel slide container-fluid mt-4" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach ($topGames as $index => $game)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <img src="{{ asset('pictures/spiderman/' . $game->images[0]) }}" class="d-block w-100" alt="{{ $game->name }}">
                    <div class="carousel-caption d-flex flex-column align-items-start text-start">
                        <h2 class="fw-bold">{{ $game->name }}</h2>
                        <p class="fs-4">${{ number_format($game->price, 2) }}</p>
                        <a href="{{ url('product/' . $game->id) }}" class="btn btn-primary">Buy Now</a>
                    </div>
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#gameCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#gameCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
@endsection
