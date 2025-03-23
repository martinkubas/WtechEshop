function loadHeader() {
    if (!document.querySelector('link[href*="bootstrap-icons"]')) {
        const link = document.createElement("link");
        link.rel = "stylesheet";
        link.href = "https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css";
        document.head.appendChild(link);
    }
    const headerHTML = `
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand fw-bold text-white" href="index.html">
                    <span id="game">Game</span><span class="text-light">Go</span>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon">
                    
                    </span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto text-center">
                        <li class="nav-item dropdown position-relative">
                            <a class="nav-link category-link" href="../html/products.html" id="categoriesDropdown">
                                ☰ <span class="category-text">All Categories</span>
                            </a>
                            <div class="dropdown-menu p-3 custom-dropdown">
                                <div class="row">
                                    <div class="col-md-4">
                                        <strong>Genres</strong>
                                        <ul class="list-unstyled">
                                            <li>Action</li>
                                            <li>Adventure</li>
                                            <li>Puzzle</li>
                                            <li>Indie</li>
                                            <li>Horror</li>
                                            <li>Competitive</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Themes</strong>
                                        <ul class="list-unstyled">
                                            <li>Singleplayer</li>
                                            <li>Multiplayer</li>
                                            <li>Co-Operative</li>
                                            <li>Anime</li>
                                            <li>Adult Only</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Platform</strong>
                                        <ul class="list-unstyled">
                                            <li>PC</li>
                                            <li>PlayStation 5</li>
                                            <li>PlayStation 4</li>
                                            <li>Xbox One</li>
                                            <li>Xbox 360</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item"><a class="nav-link text-white fw-bold" href="../html/products.html"> HOT & NEW</a></li>
                        <li class="nav-item"><a class="nav-link text-white fw-bold" href="../html/products.html"> Best Deals</a></li>
                        
                        <!-- Search Bar in Mobile Menu -->
                        <li class="nav-item d-lg-none">
                            <form class="d-flex" id="searchFormMobile">
                                <input class="form-control" type="search" placeholder="Search products..." id="searchInputMobile">
                            </form>
                        </li>

                        <!-- User Icon in Mobile Menu -->
                        <li class="nav-item d-lg-none">
                            <a href="../html/login.html" class="btn">
                                <i class="bi bi-person-circle text-white" style="font-size: 24px;"></i>
                            </a>
                        </li>

                        <!-- Shopping Cart in Mobile Menu -->
                        <li class="nav-item d-lg-none">
                            <a href="#" class="btn">
                                <i class="bi bi-basket2-fill text-white" style="font-size: 24px;"></i>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Search Bar for Desktop -->
                <form class="d-flex d-none d-lg-block" id="searchFormDesktop">
                    <input class="form-control" type="search" placeholder="Search products..." id="searchInputDesktop">
                </form>
                
                <!-- User and Shopping Cart for Desktop -->
                <div class="ms-3 d-flex gap-3 d-none d-lg-flex">
                    <a href="../html/login.html" class="btn">
                        <i class="bi bi-person-circle text-white" style="font-size: 24px;"></i>
                    </a>
                    <a href="#" class="btn">
                        <i class="bi bi-basket2-fill text-white" style="font-size: 24px;"></i>
                    </a>
                </div>
            </div>
        </nav>
    `;

    document.getElementById("site-header").innerHTML = headerHTML;
    
    /* --searchbar--
    function handleSearch(event) {
        event.preventDefault(); // Prevents page refresh
        const query = event.target.querySelector("input").value.trim();
        if (query) {
            window.location.href = `search.html?query=${encodeURIComponent(query)}`;
        }
    }
    
    document.getElementById("searchFormDesktop").addEventListener("submit", handleSearch);
    document.getElementById("searchFormMobile").addEventListener("submit", handleSearch);
   */

    document.querySelector(".category-text").addEventListener("mouseover", function() {
        document.querySelector(".custom-dropdown").style.display = "block";
    });

    document.querySelector(".custom-dropdown").addEventListener("mouseleave", function() {
        this.style.display = "none";
    });

    let currentPage = window.location.href;

    if (!currentPage.includes("login.html") && !currentPage.includes("signup.html")) {
        localStorage.setItem("lastValidPage", currentPage);
    }

}

document.addEventListener("DOMContentLoaded", loadHeader);
