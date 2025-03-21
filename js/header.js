function loadHeader() {
    const headerHTML = `
        <nav class="navbar navbar-expand-lg bg-danger navbar-dark">
            <div class="container">

                <a class="navbar-brand fw-bold text-white" href="index.html">
                    <span id="game">Game</span><span class="text-light">Go</span>
                </a>

                <!-- Navbar Toggler -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navbar Content -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto text-center">
                        <!-- Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="categoriesDropdown" role="button" data-bs-toggle="dropdown">
                                ☰ All Categories
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
                        <li class="nav-item"><a class="nav-link text-white text font-weight-bold" href="#"> HOT & NEW</a></li>
                        <li class="nav-item"><a class="nav-link text-whitefont-weight-bold" href="#"> Best Deals</a></li>

                        <!-- Search Bar (Moves inside menu on mobile) -->
                        <li class="nav-item w-100 px-3 d-lg-none">
                            <form class="d-flex mt-2" id="searchForm">
                                <input class="form-control" type="search" placeholder="Search products..." id="searchInput">
                            </form>
                        </li>

                        <!-- Icons (Move inside menu on mobile) -->
                        <li class="nav-item d-lg-none text-center mt-3">
                            <a href="#" class="btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" viewBox="0 0 24 24">
                                    <path d="M7 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zM7.16 14h9.68l3.3-7H5.84l1.32 7zM3 4h2.05l.93 5H19l2-5H5.82L5 2H1v2h2z"/>
                                </svg>
                            </a>

                            <a href="#" class="btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" viewBox="0 0 24 24">
                                    <path d="M12 12c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm0 2c-3.33 0-10 1.67-10 5v3h20v-3c0-3.33-6.67-5-10-5z"/>
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Search Bar (desktop) -->
                <form class="d-flex d-none d-lg-block" id="searchFormDesktop">
                    <input class="form-control" type="search" placeholder="Search products..." id="searchInputDesktop">
                </form>

                <!-- Icons (desktop) -->
                <div class="ms-3 d-flex gap-2 d-none d-lg-flex">
                    <a href="#" class="btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" viewBox="0 0 24 24">
                            <path d="M7 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zM7.16 14h9.68l3.3-7H5.84l1.32 7zM3 4h2.05l.93 5H19l2-5H5.82L5 2H1v2h2z"/>
                        </svg>
                    </a>

                    <a href="#" class="btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" viewBox="0 0 24 24">
                            <path d="M12 12c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm0 2c-3.33 0-10 1.67-10 5v3h20v-3c0-3.33-6.67-5-10-5z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </nav>
    `;

    document.getElementById("site-header").innerHTML = headerHTML;

    // Make search forms submit on Enter
    function setupSearchForm(formId, inputId) {
        document.getElementById(formId).addEventListener("submit", function (event) {
            event.preventDefault();
            const query = document.getElementById(inputId).value.trim();
            if (query) {
                window.location.href = `search.html?q=${encodeURIComponent(query)}`;
            }
        });
    }

    setupSearchForm("searchForm", "searchInput");
    setupSearchForm("searchFormDesktop", "searchInputDesktop");
}

document.addEventListener("DOMContentLoaded", loadHeader);
