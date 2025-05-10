<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand fw-bold text-white" href="{{ url('/') }}">
            <span id="game">Game</span><span class="text-light">Go</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto text-center">
                <li class="nav-item dropdown position-relative">
                    <a class="nav-link category-link" href="{{ url('products') }}" id="categoriesDropdown">
                         <span class="category-text">All Categories</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white fw-bold" href="{{ route('products', ['sort' => 'created_at']) }}">
                        HOT & NEW
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white fw-bold" href="{{ route('products', ['sort' => 'highest_price']) }}">
                        Best Deals
                    </a>
                </li>

                <li class="nav-item d-lg-none">
                    <form class="d-flex" id="searchFormMobile">
                        <input class="form-control" type="search" placeholder="Search products..." id="searchInputMobile">
                    </form>
                </li>

                <li class="nav-item dropdown d-lg-none">
                    <a href="#" class="btn" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle text-white" style="font-size: 24px;"></i>
                    </a>
                    <ul class="dropdown-menu">
                        @if(session('user_id'))
                            <li><a class="dropdown-item" href="{{ url('profile') }}">Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                        @else
                            <li><a class="dropdown-item" href="{{ url('login') }}">Login/Signup</a></li>
                        @endif
                    </ul>
                </li>

                <li class="nav-item d-lg-none">
                    <a href="{{ url('cart') }}" class="btn position-relative">
                        <i class="bi bi-basket2-fill text-white" style="font-size: 24px;"></i>
                        <span id="cart-counter-mobile" class="position-absolute badge rounded-pill bg-danger" style="display: none;">0</span>
                    </a>
                </li>
            </ul>
        </div>

        <form class="d-flex d-none d-lg-block" id="searchFormDesktop">
            <input class="form-control" type="search" placeholder="Search products..." id="searchInputDesktop">
        </form>

        <div class="ms-3 d-flex gap-3 d-none d-lg-flex">
            <div class="dropdown">
                <a href="#" class="btn" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle text-white" style="font-size: 24px;"></i>
                </a>
                <ul class="dropdown-menu">
                    @if(session('user_id'))
                        <li><a class="dropdown-item" href="{{ url('profile') }}">Profile</a></li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                    @else
                        <li><a class="dropdown-item" href="{{ url('login') }}">Login/Signup</a></li>
                    @endif
                </ul>
            </div>
            <a href="{{ url('cart') }}" class="btn position-relative">
                <i class="bi bi-basket2-fill text-white" style="font-size: 24px;"></i>
                <span id="cart-counter" class="position-absolute badge rounded-pill bg-danger" style="display: none;">0</span>
            </a>
        </div>
    </div>
</nav>
